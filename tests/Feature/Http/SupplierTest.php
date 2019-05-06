<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\JobOrder;
use App\Models\JobRequest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use JWTAuth;

class SupplierTest extends TestCase
{

    use RefreshDatabase, WithFaker;

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

    public function publishJr($property, $jr) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/jobrequests/' . $jr['id'] . '/publish', [
          'token' => \JWTAuth::fromUser($user)
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

    public function createLocation($supplier) {
        $location = $this->LocationFactory();
        $user = factory(User::class)->create();
        return $this->post('/api/suppliers/' . $supplier['id'] . '/locations/store', [
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

    public function attachTagSupplier($supplier, $tag) {
        $user = factory(User::class)->create();
        return $this->post('/api/suppliers/' . $supplier['id'] . '/tag/' . $tag->id . '/attach', [
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

    /**
     * A basic feature test example.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/SupplierTest
     * @test
     */
    public function user_can_create_supplier()
    {
        $response = $this->createSupplier();
        $response->assertSuccessful();
        $supplier = $response->decodeResponseJson();
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier['id'],
            'name' => $supplier['name']
        ]);
    }

    /**
     * properties can have locations
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_attach_location()
    {
        $supplier = $this->createSupplier()->decodeResponseJson();
        $response = $this->createLocation($supplier);
        $response->assertSuccessful();
        $this->assertDatabaseHas('locations', [
            'locationable_id' => $supplier['id'],
            'locationable_type' => Supplier::class
        ]);
    }

    /**
     * supplier can be tagged
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_be_tagged()
    {
      $tag      = $this->TagFactory();
      $supplier = $this->createSupplier()->decodeResponseJson();
      $response = $this->attachTagSupplier($supplier, $tag);
      $response->assertSuccessful();
      $this->assertDatabaseHas('taggables', [
        'tag_id' => $tag->id,
        'taggable_id' => $supplier['id'],
        'taggable_type' => Supplier::class
      ]);
    }
}
