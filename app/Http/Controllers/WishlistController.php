<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Services\Tracking\PixelTracker;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);

        $product = Product::findOrFail($request->product_id);

        $existing = Wishlist::current()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();

            return response()->json([
                'success' => true,
                'added' => false,
                'count' => Wishlist::current()->count(),
                'message' => 'Removed from your wishlist.',
            ]);
        }

        Wishlist::addProduct($product);

        return response()->json([
            'success' => true,
            'added' => true,
            'count' => Wishlist::current()->count(),
            'tracking_events' => PixelTracker::addToWishlist($product),
            'message' => 'Added to your wishlist.',
        ]);
    }
}