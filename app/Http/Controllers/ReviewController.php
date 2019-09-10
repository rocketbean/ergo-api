<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Review;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Supplier $supplier)
    {
        $supplier->computescore();
        return new SupplierResource($supplier, 'reviews');
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
    public function store(Supplier $supplier, Request $request)
    {
       $review = $supplier->reviews->where('reviewer_id', Auth::user()->id)
                    ->where('status_id', 2)
                    ->first();
        if(!Review::enableRespondent(Auth::user(), $supplier)) {
            $supplier->computescore();
            $review->update([
                'content' => $request->remarks,
                'score' => $request->score,
                'status_id' => 1,
            ]);
            return new SupplierResource($supplier->load(['photos', 'location', 'videos','users', 'joborders.jobrequest']));

        }
        return response()->json("you've already submitted a review for " . $supplier->name, 403);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
