<?php
namespace Tests\Feature\Http;

use App\Models\Property;
use App\Models\JobRequest;
use App\Models\JobRequestItem;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Supplier;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\JobOrderItem;
use JWTAuth;

trait TestHelper
{

    public function UserFactory () {
        return factory(User::class)->create();
    }

    public function TagFactory () {
        return factory(Tag::class)->create();
    }

    public function Propfactory () {
        return factory(Property::class)->make();
    }

    public function SupplierFactory () {
        return factory(Supplier::class)->make();
    }

    public function JrFactory () {
        return factory(JobRequest::class)->make();
    }

    public function JrItemFactory (Int $num) {
        return factory(JobRequestItem::class, $num)->make();
    }

    public function JoItemFactory () {
        return factory(JobOrderItem::class)->make();
    }

    public function LocationFactory () {
        return factory(Location::class)->make();
    }

    public function JoFactory () {
        return factory(JobOrder::class)->make();
    }

    public function createProperty() {
        $user = $this->UserFactory();
        $property = $this->Propfactory();
        return $this->post('/api/properties/store', [
            'name' => $property->name,
            'description' => $property->description,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createSupplier() {
        $user = $this->UserFactory();
        $supplier = $this->SupplierFactory();
        return $this->post('/api/suppliers/store', [
            'name' => $supplier->name,
            'description' => $supplier->description,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createLocation($property) {
        $location = $this->LocationFactory();
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/locations/store', [
          'address1'     => $location->address1,
          'address2'     => $location->address2,
          'city'     => $location->city,
          'state'     => $location->state,
          'country'     => $location->country,
          'lat'     => $location->lat,
          'lng'     => $location->lng,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createJr($property, $jr) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/store', [
          'name'        => $jr->name,
          'description' => $jr->description,
          'status_id'   => $jr->status_id,
        ],[
          'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createJrItem($property, $jr, $item) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/items/store', [
          'name'        => $item->name,
          'description' => $item->description
        ],[
          'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createJoItem($supplier, $property, $jr, $jo, $jritem, $item) {
        $user = factory(User::class)->create();
        return $this->post('/api/suppliers/' . $supplier['id'] . '/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/joborders/' . $jo['id'] . '/items/store', [
          'amount'              => $item->amount,
          'job_request_item_id' => $jritem['id'],
          'remarks'             => $item->remarks
        ],[
          'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function attachTagProperty($property, $tag) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/tag/' . $tag->id . '/attach', [
          'token' => \JWTAuth::fromUser($user)
        ]);
    }

    public function publishJr($property, $jr) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/publish', [
          'token' => \JWTAuth::fromUser($user)
        ]);
    }

    public function createJobOrder($supplier, $property, $jo, $jr) {
        $user = factory(User::class)->create();
        return $this->post('/api/suppliers/' . $supplier['id'] . '/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/joborders/store', [
            'remarks' => $jo->remarks,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function createJrWithItems($property, $jrs) {
        $user  = factory(User::class)->create();
        $items = $this->JrItemFactory(5);
        foreach ($items as $item) {
          $response = $this->createJrItem($property, $jrs, $item);
        }
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/' . $jrs['id'], [
            'token' => JWTAuth::fromUser($user),
        ]);
    }

    public function createJoWithItems($supplier, $property, $jrs, $jo) {
        $user  = factory(User::class)->create();
        $items = $this->JrItemFactory(5);
        foreach ($items as $item) {
          $response = $this->createJrItem($property, $jrs, $item);
        }
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/' . $jrs['id'], [
            'token' => JWTAuth::fromUser($user),
        ]);
    }

    public function publishJo($supplier, $property, $jr, $jo) {
        $user  = factory(User::class)->create();
        return $this->post('/api/suppliers/' . $supplier['id'] . '/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/joborders/' . $jo['id'] . '/publish', [
            'token' => JWTAuth::fromUser($user),
        ]);
    }

    public function uploadPhoto($file) {
        $user  = factory(User::class)->create();
        return $this->post('/api/uploads/files/store', [
            'file' => $file,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function uploadFile($file) {
        $user  = factory(User::class)->create();
        return $this->post('/api/uploads/files/store', [
            'file' => $file,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function uploadVideo($file) {
        $user  = factory(User::class)->create();
        return $this->post('/api/uploads/files/store', [
            'file' => $file,
        ],[
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
    }

    public function JobRequestItemAttachPhoto($jr, $item, $photo) {
        $user  = factory(User::class)->create();
        return $this->post('/api/jobrequests/' . $jr['id'] . '/items/' . $item['id'] . '/photos/' . $photo['id'] . '/attach', [
            'token' => JWTAuth::fromUser($user),
        ]);
    }
}

