<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Property;
use App\Models\Photo;
use App\Models\User;
use App\Models\Permission;
use App\Models\Tag;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return $user->properties;
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
    public function store(Request $request)
    {
        $property = Property::create([
            'user_id'     => Auth::user()->id,
            'name'        => $request->name,
            'description' => $request->description,
            'primary'     => 1
        ]);
        $property->users()->attach(Auth::user()->id, ['role_id' => 1, 'status' => 1]);
        return $property;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {  
        // return $property->load(['photos', 'location', 'videos','users', 'jobrequests.joborders']);
        return new PropertyResource($property->load(['photos', 'location', 'videos','users', 'jobrequests.joborders']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function attach(Property $property, Tag $tag)
    {
        return $property->tags()->attach($tag->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function primary(Property $property, Photo $photo)
    {
        $property->update(['primary' => $photo->id]);
        return Property::find($property->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function photos(Property $property)
    {
        return $property->photos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function users(Property $property)
    {
        if($property->authorized('read_user')) {
            foreach ($property->propertyUsers as $user) {
                $user->propertyUsers->load(['role']);
            };
            return $property->propertyUsers;
        }
        return [];

    }

    /**
     * returns [Permission::class] property
     *
     * @return \Illuminate\Http\Response
     */
    public function permissions()
    {
        return Permission::where('group', Property::class)->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function invite(Property $property, Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user) {
            $property->users()->attach($user->id, ['role_id' => $request->role, 'status' => 2 ]);
            return $property->propertyUsers;
        } else {
            return response()->json('user not found', 400);
        }
    }
}
