<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Location;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\JobRequest;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Property $property)
    {
        return $property->location;
    }

    /**
     * supplies the service location.
     *
     * @return \Illuminate\Http\Response
     */
    public function ServiceLocation(Supplier $supplier)
    {
        return $supplier->location;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Property $property, Request $request)
    {
        $location = Location::create([
            'locationable_id'    => $property->id,
            'locationable_type' => Property::class,
            'user_id'            => Auth::user()->id,
            'address1'           => $request->address1,
            'address2'           => $request->address2,
            'city'               => $request->city,
            'state'              => $request->state,
            'country'            => $request->country,
            'lat'                => $request->lat,
            'lng'                => $request->lng,
        ]);
        $property->update(['location_id' => $location->id]);
        return $property->load(['jobrequests', 'photos', 'location', 'videos']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSuplierLocation(Supplier $supplier, Request $request)
    {
        $location = Location::create([
            'locationable_id'    => $supplier->id,
            'locationable_type'  => Supplier::class,
            'user_id'            => Auth::user()->id,
            'address1'           => $request->address1,
            'address2'           => $request->address2,
            'city'               => $request->city,
            'state'              => $request->state,
            'country'            => $request->country,
            'lat'                => $request->lat,
            'lng'                => $request->lng,
        ]);
        $supplier->update(['location_id' => $location->id]);
        return $supplier->load(['joborders', 'photos', 'location', 'videos']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function JobRequestDirection(JobRequest $jr)
    {
        return [
            'supplier' => $jr->joborder->supplier->location,
            'property' => $jr->property->location,
        ];
    }
}
