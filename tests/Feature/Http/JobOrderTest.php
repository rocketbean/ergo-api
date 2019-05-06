<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Tests\Feature\Http\TestHelper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobOrderTest extends TestCase
{

    use RefreshDatabase, WithFaker, TestHelper;

    /**
     * basic job order test
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobOrderTest
     * @test
     */
    public function can_be_created_from_published_jobrequest()
    {
        $property = $this->createProperty()->decodeResponseJson();
        $jr       = $this->createJr($property, $this->JrFactory());
        $jritems  = $this->createJrWithItems($property, $jr->decodeResponseJson())->decodeResponseJson();
        $supplier = $this->createSupplier()->decodeResponseJson();
        $publish  = $this->publishJr($property, $jritems);
        $jo       = $this->JoFactory();
        $joborder = $this->createJobOrder($supplier, $property, $jo, $jritems);
        $arrayjo  = $joborder->assertSuccessful()->decodeResponseJson();
        $this->assertDatabaseHas('job_orders', [
            'id'          => $arrayjo['id'],
            'property_id' => $property['id'],
            'supplier_id' => $supplier['id'],
            'remarks'     => $arrayjo['remarks'],
        ]);
    }

    /**
     * job order items [create] test
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobOrderTest
     * @test
     */
    public function can_create_items()
    {
        $arr      = [];
        $property = $this->createProperty()->decodeResponseJson();
        $supplier = $this->createSupplier()->decodeResponseJson();
        $jr       = $this->createJr($property, $this->JrFactory());
        $jritems  = $this->createJrWithItems($property, $jr->decodeResponseJson())->decodeResponseJson();
        $publish  = $this->publishJr($property, $jritems);
        $joborder = $this->createJobOrder($supplier, $property, $this->JoFactory(), $jritems)->decodeResponseJson();
        foreach ($jritems['items'] as $item) {
            $joitem = $this->createJoItem($supplier, $property, $jritems, $joborder, $item, $this->JoItemFactory());
            $joitem->assertSuccessful();
        }
    }

    /**
     * job order items [publishing] test
     * "./vendor/bin/phpunit" C:/Users/buzzo/OneDrive/Desktop/web/ergo-api/tests/Feature/Http/JobOrderTest
     * @test
     */
    public function can_be_publish()
    {
        $arr      = [];
        $property = $this->createProperty()->decodeResponseJson();
        $supplier = $this->createSupplier()->decodeResponseJson();
        $jr       = $this->createJr($property, $this->JrFactory());
        $jritems  = $this->createJrWithItems($property, $jr->decodeResponseJson())->decodeResponseJson();
        $publish  = $this->publishJr($property, $jritems);
        $joborder = $this->createJobOrder($supplier, $property, $this->JoFactory(), $jritems)->decodeResponseJson();
        $joitems  = $this->JoItemFactory();
        foreach ($jritems['items'] as $item) {
            array_push($arr, $this->createJoItem($supplier, $property, $jritems, $joborder, $item, $this->JoItemFactory()));
        }
        $response = $this->publishJo($supplier, $property, $jritems, $joborder);
        $response->assertSuccessful();
        $this->assertDatabaseHas('job_orders',[
            'id' => $joborder['id'],
            'status_id' => 1,
        ]);
    }
}
