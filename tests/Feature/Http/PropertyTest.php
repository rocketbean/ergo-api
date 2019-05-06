<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Property;
use App\Models\JobRequest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use JWTAuth;

class PropertyTest extends TestCase
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

    public function JrFactory () {
        return factory(JobRequest::class)->make();
    }

    public function LocationFactory () {
        return factory(Location::class)->make();
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

    public function attachTagProperty($property, $tag) {
        $user = factory(User::class)->create();
        return $this->post('/api/properties/' . $property['id'] . '/tag/' . $tag->id . '/attach', [
          'token' => \JWTAuth::fromUser($user)
        ]);
    }

    /**
     * A basic feature test example.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function user_can_create_property()
    {
        $response = $this->createProperty();
        $response->assertSuccessful();
    }

    /**
     * properties can have locations
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_attach_location()
    {
        $property = $this->createProperty()->decodeResponseJson();
        $response = $this->createLocation($property);
        $response->assertSuccessful();
    }

    /**
     * ensure property returns the right location.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_view_location()
    {
        $property = $this->createProperty()->decodeResponseJson();
        $location = $this->createLocation($property)->decodeResponseJson();
        $user     = $this->UserFactory(); 
        $response = $this->get('/api/properties/' . $property['id'] . '/locations/', [
            'Authorization' => 'Bearer '.\JWTAuth::fromUser($user),
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas('locations', [
            'locationable_id'   => $property['id'],
            'locationable_type' => 'App\Models\Property',
            'address1'          => $location['address1']
        ]);
    }

    /**
     * creates jobrequest from a property.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_submit_jobrequest()
    {
      $property = $this->createProperty()->decodeResponseJson();
      $jr       = $this->JrFactory();
      $response = $this->createJr($property, $jr);
      $response->assertSuccessful();
      $jrs = $response->decodeResponseJson();
      $this->assertDatabaseHas('job_requests', [
          'id'   => $jrs['id'],
          'name' => $jrs['name']
      ]);
    }

    /**
     * property can be tagged
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/PropertyTest
     * @test
     */
    public function can_be_tagged()
    {
      $tag      = $this->TagFactory();
      $property = $this->createProperty()->decodeResponseJson();
      $response = $this->attachTagProperty($property, $tag);
      $response->assertSuccessful();
      $this->assertDatabaseHas('taggables', [
        'tag_id' => $tag->id,
        'taggable_id' => $property['id'],
        'taggable_type' => Property::class
      ]);
    }
}
