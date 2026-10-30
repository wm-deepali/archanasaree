<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductReviewImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product): JsonResponse
    {
        $data = $request->validate([
            'rating'     => 'required|integer|between:1,5',
            'title'      => 'required|string|max:150',
            'review'     => 'required|string|min:10|max:2000',
            'photos'     => 'nullable|array|max:5',
            'photos.*'   => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $customer = $request->user('customer');

        // Server par dobara check: client ki baat par bharosa nahi
        $orderItem = $product->reviewableOrderItemFor($customer->id);

        if (!$orderItem) {
            return response()->json([
                'status'  => false,
                'message' => 'Only customers who purchased this product can review it, once per purchase.',
            ], 403);
        }

        DB::transaction(function () use ($request, $data, $product, $customer, $orderItem) {
            $review = ProductReview::create([
                'product_id'        => $product->id,
                'customer_id'       => $customer->id,
                'order_id'          => $orderItem->order_id,
                'order_item_id'     => $orderItem->id,
                'rating'            => $data['rating'],
                'title'             => $data['title'],
                'review'            => $data['review'],
                'verified_purchase' => true,
                'featured'          => false,
                'status'            => 'pending',
            ]);

            foreach ($request->file('photos', []) as $photo) {
                ProductReviewImage::create([
                    'product_review_id' => $review->id,
                    'image'             => $photo->store('review-photos', 'public'),
                ]);
            }
        });

        return response()->json([
            'status'  => true,
            'message' => 'Thank you! Your review has been submitted and will appear after approval.',
        ]);
    }
}