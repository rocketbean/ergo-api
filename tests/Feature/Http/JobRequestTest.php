<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Http\TestHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Property;
use App\Models\JobRequest;
use App\Models\JobRequestItem;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use JWTAuth;

class JobRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestHelper;

    /**
     * creates jobrequest from a property.
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobRequestTest
     * @test
     */
    public function property_can_submit_jobrequest()
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
     * jobrequests can / should have items
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobRequestTest
     * @test
     */
    public function can_have_items()
    {
      // $this->withoutExceptionHandling();
      $property = $this->createProperty()->decodeResponseJson();
      $jr       = $this->createJr($property, $this->JrFactory());
      $jrs      = $jr->decodeResponseJson();
      $items    = $this->JrItemFactory(5);
      foreach ($items as $item) {
          $response = $this->createJrItem($property, $jrs, $item);
          $response->assertSuccessful();
          $this->assertDatabaseHas('job_request_items', [
            'name' => $item->name,
            'description' => $item->description,
            'job_request_id' => $jrs['id']
          ]);
      }
    }

    /**
     * jobrequests can / should have items
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobRequestTest
     * @test
     */
    public function items_can_have_photos()
    {
      // $this->withoutExceptionHandling();
      $property = $this->createProperty()->decodeResponseJson();
      $jr       = $this->createJr($property, $this->JrFactory())->decodeResponseJson();
      $items    = $this->JrItemFactory(5);
      foreach ($items as $item) {
          $response = $this->createJrItem($property, $jr, $item);
          $response->assertSuccessful();
          $this->assertDatabaseHas('job_request_items', [
            'name' => $item->name,
            'description' => $item->description,
            'job_request_id' => $jr['id']
          ]);
      }
      $jobrequest = $response->decodeResponseJson();
      foreach ($jobrequest['items'] as $item) {
        $photo = $this->uploadPhoto(UploadedFile::fake()->image('avatar.jpg', 620, 480))->decodeResponseJson();
        $jrip = $this->JobRequestItemAttachPhoto($jr, $item, $photo);
        $jrip->assertSuccessful()
             ->assertJson([
                'id' => $jobrequest['id'],
             ]);
      }
    }

    /**
     * jobrequests can / cannot be published
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobRequestTest
     * @test
     */
    public function can_be_published()
    {
      $property = $this->createProperty()->decodeResponseJson();
      $jr       = $this->createJr($property, $this->JrFactory());
      $jrs      = $jr->decodeResponseJson();
      $items    = $this->JrItemFactory(5);
      $notPub   = $this->publishJr($property, $jrs);
      $notPub->assertStatus(406);
      foreach ($items as $item) {
          $response = $this->createJrItem($property, $jrs, $item);
      }
      $publish = $this->publishJr($property, $jrs);
      $publish->assertSuccessful();
      $this->assertDatabaseHas('job_requests', [
        'property_id' => $property['id'],
        'id' => $jrs['id'],
        'status_id' => 1
      ]);
    }
}