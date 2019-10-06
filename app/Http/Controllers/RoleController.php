<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->type === 'Property') {
            return RoleResource::collection(Role::where('type', Property::class)->get());
        } elseif ($request->type === 'Supplier') {
            return RoleResource::collection(Role::where('type', Supplier::class)->get());
        } else {
            return response()->json('requesting role for unknown type', 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SupplierRoles(Supplier $supplier, Request $request)
    {
        return RoleResource::collection($supplier->roles);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PropertyRoles(Property $property, Request $request)
    {
        return RoleResource::collection($property->roles);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    /**
     * return [suppliers] permission    
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function SupplierPermissions(Supplier $supplier)
    {
        return Permission::where('group', Supplier::class)->get();
    }

        /**
     * return [suppliers] permission    
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function PropertyPermissions(Property $property)
    {
        return Permission::where('group', Property::class)->get();
    }
}
