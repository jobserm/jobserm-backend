<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReviewController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $reviews = Review::get();
        return ReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Review
     */
    public function store(ReviewRequest $request)
    {
//        $this->authorize('create', Review::class); //??
        $review = new Review();
//        $user = JWTAuth::user();
        $review->comment = $request->input('comment');
        $review->rating = $request->input('rating');
        $review->user_id = $request->input('id');

        $review->save();
        return $review;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Review $review
     * @return Review
     */
    public function show(Review $review)
    {
        $this->authorize('view', $review);
        return $review;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();

        return response()->json(['message' => 'Successfully deleted',]);

    }

    public function getReviewByUserID($id) {
        return Review::get()->where('user_id', $id);
    }

}
