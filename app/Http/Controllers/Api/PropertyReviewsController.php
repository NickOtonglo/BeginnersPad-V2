<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyReview\PropertyReviewRemovalReasonResource;
use App\Http\Resources\PropertyReviewResource;
use App\Models\Property;
use App\Models\PropertyReview;
use App\Models\PropertyReviewRemovalReason;
use Illuminate\Http\Request;
use stdClass;

class PropertyReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $property)
    {
        // $reviews = $property->propertyReviews->take(10)->get();
        $myReview = PropertyReview::where('property_id', $property->id)->where('author_id', auth()->user()->id)->get();
        $reviews = $property->propertyReviews;
        $combined = $myReview->merge($reviews);
        return PropertyReviewResource::collection($combined);
        // return PropertyReviewResource::collection($reviews->merge($myReview)->reverse());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Property $property, Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'review' => 'required'
        ]);

        $data = new PropertyReview;
        $data->review = $request->review;
        $data->rating = $request->rating;
        $data->author_id = auth()->user()->id;
        $data->property_id = $property->id;
        $data->save();

        $response = [
            'property_review' => $data,
            'message' => "New comment added successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $review = PropertyReview::where('author_id', auth()->user()->id)->where('property_id', $property->id)->first();

        if ($review) {
            return new PropertyReviewResource($review);
        } else {
            return response()->noContent();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Property $property, PropertyReview $review, Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'review' => 'required'
        ]);

        $data = $review;
        $data->review = $request->review;
        $data->rating = $request->rating;
        $data->save();

        $response = [
            'property_review' => $data,
            'message' => "Comment updated successfully.",
        ];
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property, PropertyReview $review)
    {
        $review->delete();
        return response()->noContent();
    }

    public function getMyReviews() {
        $reviews = auth()->user()->propertyReviews;
        return PropertyReviewResource::collection($reviews);
    }
    
    public function showMyReview(Property $property) {
        $review = PropertyReview::where('author_id', auth()->user()->id)->where('property_id', $property->id)->first();
        return new PropertyReviewResource($review);
    }

    public function getRemovalReasons() {
        return PropertyReviewRemovalReasonResource::collection(PropertyReviewRemovalReason::get());
    }

    public function removeReview(Property $property, PropertyReview $review, Request $request)
    {
        $request->validate([
            'removal_reason' => 'required',
        ]);

        $reviewId = $review->id;
        $data = new stdClass();
        $data->review = $review->review;
        $data->rating = $review->rating;
        $data->author_id = $review->author_id;
        $data->property_id = $review->property_id;
        $data->removal_reason = $request->removal_reason;
        $data->reason_details = $request->reason_details;
        // $comment = 'Review removed due to reason: '.$data->reason_reason;
        $comment = '';
        
        $review->delete();
        $response = [
            'property_review_removal_reason' => $data,
            'model' => 'PropertyReviewRemovalReason',
            'key' => $reviewId,
            'comment' => $comment,
            'message' => "Review removed by administrator.",
        ];
        return response($response, 201);
    }
}
