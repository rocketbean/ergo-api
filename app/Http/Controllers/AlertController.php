<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use App\Models\JobOrder;
use App\Models\Alert;
use Illuminate\Http\Request;
use Auth;
class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->alerts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jr = JobRequest::find(2)->load('property');
        $jo = JobOrder::find(2)->load('property');
        Alert::create([
            'user_id' => 1,
            'subjectable_id' => $jo->id,
            'subjectable_type' => JobOrder::class,
            'title' => $jo->property->name,
            'message' => $jo->name . ' has been approved',
            'data' => serialize([
                (object) ['_activate' => (object) ['joborder' => 'subject']],
                (object) ['_modals' => (object) ['joborderModal' => (object) ['open'=> true]]]
             ])
        ]);
        return Alert::create([
            'user_id' => 1,
            'subjectable_id' => $jr->id,
            'subjectable_type' => JobRequest::class,
            'title' => $jr->property->name,
            'message' => $jr->name . ' has been approved',
            'data' => serialize([
                (object) ['_activate' => (object) ['jobrequest' => 'subject']],
                (object) ['_modals' => (object) ['addJrItem' => (object) ['open'=> true]]]
             ])
        ]);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
