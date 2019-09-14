<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\Photo;
use App\Models\User;
use App\Models\JobRequestItem;
use App\Services\AuthDriverService;
use Auth;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return $user->suppliers->load(['users']);
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
        $supplier = Supplier::create([
            'user_id'     => Auth::user()->id,
            'name'        => $request->name,
            'description' => $request->description,
            'primary'     => 1
        ]);

        $client = (new AuthDriverService)->grant($request, $supplier);

        return Auth::user()->suppliers()->attach($supplier->id, ['client_id' => $client['id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier->load(['photos', 'location', 'videos','users', 'joborders.jobrequest']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * returns supplier assoc. photos
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function photos(Supplier $supplier)
    {
        return $supplier->photos;
    }

    /**
     * returns supplier assoc. users
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function users(Supplier $supplier)
    {
            foreach ($supplier->supplierUsers as $user) {
                $user->supplierUsers->load(['role']);
            };
            return $supplier->supplierUsers;
        // return [];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLocation(Supplier $supplier, Request $request)
    {
        return $supplier->location()->create([
            'user_id'   => Auth::user()->id,
            'address1'  => $request->address1,
            'address2'  => $request->address2,
            'city'      => $request->city,
            'state'     => $request->state,
            'country'   => $request->country,
            'lat'       => $request->lat,
            'lng'       => $request->lng,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function attach(Supplier $supplier, Tag $tag)
    {
        return $supplier->tags()->attach($tag->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function primary(Supplier $supplier, Photo $photo)
    {
        $supplier->update(['primary' => $photo->id]);
        return Supplier::find($supplier->id);
    }

    /**
     * user invitations
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function invite(Supplier $supplier, Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user) {
            $supplier->logActivity(['description' => ' has been invited ', 'activity' => 'invite'], $user);
            $supplier->users()->attach($user->id, ['role_id' => $request->role, 'status' => 2, 'client_id' => $supplier->id ]);
            return $supplier->supplierUsers;
        } else {
            return response()->json('user not found', 400);
        }
    }
}