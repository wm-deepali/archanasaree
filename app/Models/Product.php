<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public const SORT_OPTIONS = [
        'recommended' => 'Recommended',
        'newest' => 'New Arrivals',
        'sold' => 'Best Selling',
        'low' => 'Price: Low to High',
        'high' => 'Price: High to Low',
        'rating' => 'Customer Rating',
    ];

    protected $fillable = [

        'category_id',
        'subcategory_id',
        'brand_id',

        'name',
        'slug',

        'sku',

        'short_description',
        'fabric_material',
        'care_instructions',
        'shipping_delivery',
        'returns_exchange',
        'offers_how_to_avail',

        'mrp',
        'discount_type',
        'discount',
        'price',

        'stock',
        'min_qty',

        'delivery_time',

        'colour_customization',
        'dye_price',

        'meta_title',
        'meta_description',

        'status',

    ];

    protected $casts = [

        'status' => 'boolean',
        'colour_customization' => 'boolean',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * ✅ Used across all grid/listing views (homepage sections, product
     * listing pages, luxury tabs, etc). Prefers the compressed THUMB
     * (400px) since these are always shown small — falls back to the
     * full image for older rows created before the thumb column existed.
     */
    public function getDisplayImageAttribute()
    {
        $default = $this->images()
            ->where('is_default', 1)
            ->first();

        if ($default) {
            return asset('storage/' . ($default->thumb ?? $default->image));
        }

        $image = $this->images()->first();

        return $image
            ? asset('storage/' . ($image->thumb ?? $image->image))
            : null;
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ new: product videos (Media → Video)
    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // ✅ new: addon options (Addon Options section)
    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }

    // OCCASIONS
    public function occasions()
    {
        return $this->belongsToMany(
            GiftingOccasion::class,
            'occasion_product',
            'product_id',
            'occasion_id'
        );
    }

    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_product',
            'product_id',
            'collection_id'
        );
    }

    public function cartItems()
    {
        return $this->hasMany(
            CartItem::class
        );
    }

    public function scopeVisible($query)
    {
        $query->where('status', 1);

        if (StockSetting::current()->auto_disable_out_of_stock) {
            $query->where('stock', '>', 0);
        }

        return $query;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // card ke liye jo relations aur rating chahiye, ek jagah
    public function scopeForCard($query)
    {
        return $query->with(['images', 'collections:id,name', 'category:id,name', 'subcategory:id,name'])
            ->withAvg('approvedReviews as avg_rating', 'rating');
    }

    // recently viewed: product detail page se call hoga
    public static function trackView(int $id, int $limit = 10): void
    {
        $ids = array_values(array_diff(session('recently_viewed', []), [$id]));
        array_unshift($ids, $id);
        session(['recently_viewed' => array_slice($ids, 0, $limit)]);
    }

    public function getDiscountPercentAttribute(): int
    {
        return $this->mrp > $this->price
            ? (int) round((($this->mrp - $this->price) / $this->mrp) * 100)
            : 0;
    }
    public function scopeOrderForListing($query, ?string $sort)
    {
        switch ($sort) {
            case 'low':
                $query->orderBy('price');
                break;
            case 'high':
                $query->orderByDesc('price');
                break;
            case 'rating':
                $query->orderByDesc('avg_rating'); // forCard() ka alias
                break;
            case 'sold':
                if (method_exists($this, 'orderDetails')) {
                    $query->withSum('orderDetails as sold_qty', 'quantity')->orderByDesc('sold_qty');
                } else {
                    $query->orderByDesc('created_at'); // relation nahi to crash ki jagah newest
                }
                break;
            case 'newest':
                $query->orderByDesc('created_at');
                break;
        }

        // tie-breaker: barabar values par bhi order stable rahe
        return $query->orderByDesc('id');
    }

    /**
     * Customer ka pehla aisa order item jo is product ka hai, deliver ho chuka hai,
     * aur jis par abhi tak review nahi diya gaya. Nahi mila to null.
     */
    public function reviewableOrderItemFor(int $customerId): ?OrderItem
    {
        $reviewed = ProductReview::where('customer_id', $customerId)
            ->where('product_id', $this->id)
            ->whereNotNull('order_item_id')
            ->pluck('order_item_id');

        return OrderItem::where('product_id', $this->id)
            ->whereNotIn('id', $reviewed)
            ->whereHas('order', function ($q) use ($customerId) {
                $q->where('customer_id', $customerId)
                    ->whereIn('status', ['delivered', 'completed']); // apne status values yahan rakho
            })
            ->orderBy('id')
            ->first();
    }

}