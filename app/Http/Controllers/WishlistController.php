<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);

        $product = Product::findOrFail($request->product_id);

        $existing = Wishlist::current()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::addProduct($product);
            $added = true;
        }

        return response()->json([
            'success' => true,
            'added'   => $added,
            'count'   => Wishlist::current()->count(),
            'message' => $added ? 'Added to your wishlist.' : 'Removed from your wishlist.',
        ]);
    }
}