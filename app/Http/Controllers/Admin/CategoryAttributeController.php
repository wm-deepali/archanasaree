<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\CategoryAttribute;
use Illuminate\Validation\ValidationException;

class CategoryAttributeController extends Controller
{
    public function index()
    {
        $categoryAttributes = CategoryAttribute::with([
            'category',
            'attribute'
        ])
            ->latest()
            ->paginate(20);

        return view(
            'admin.category-attributes.index',
            compact('categoryAttributes')
        );
    }

    public function create()
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $attributes = Attribute::where('status', 1)
            ->orderBy('name')
            ->get();

        $mappingData = CategoryAttribute::with('attribute.values')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'category_id' => $m->category_id,
                'name' => $m->attribute->name ?? '—',
                'is_selectable' => (bool) $m->is_selectable,
                'values' => $m->attribute?->values->map(fn($v) => ['id' => $v->id, 'value' => $v->value])->values() ?? [],
            ])
            ->values();

        return view(
            'admin.category-attributes.create',
            compact(
                'categories',
                'attributes',
                'mappingData'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',

            'used_for_variant' => 'required|boolean',

            // Checkboxes — simply absent from the request when unchecked
            'price_dependent' => 'nullable|boolean',
            'image_dependent' => 'nullable|boolean',
            'stock_dependent' => 'nullable|boolean',
            'sku_dependent' => 'nullable|boolean',

            'show_in_filter' => 'required|boolean',
            'show_on_listing' => 'required|boolean',

            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',

            'is_selectable' => 'nullable|boolean',
            'parent_category_attribute_id' => 'nullable|exists:category_attributes,id',
            'show_when_value_ids' => 'nullable|array',
            'show_when_value_ids.*' => 'integer',
        ]);

        $exists = CategoryAttribute::where(
            'category_id',
            $request->category_id
        )
            ->where(
                'attribute_id',
                $request->attribute_id
            )
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Mapping already exists.'
                );
        }

        $isVariant = $request->boolean('used_for_variant');

        CategoryAttribute::create([

            'category_id' => $request->category_id,

            'attribute_id' => $request->attribute_id,

            ...$this->dependencyFields($request, null),

            'used_for_variant' => $isVariant,
            'price_dependent' => $isVariant && $request->boolean('price_dependent'),
            'image_dependent' => $isVariant && $request->boolean('image_dependent'),
            'stock_dependent' => $isVariant && $request->boolean('stock_dependent'),
            'sku_dependent' => $isVariant && $request->boolean('sku_dependent'),

            'show_in_filter' => $request->show_in_filter,

            'show_on_listing' => $request->show_on_listing,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.category-attributes.index')
            ->with(
                'success',
                'Category Attribute created successfully.'
            );
    }

    public function edit(CategoryAttribute $categoryAttribute)
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $attributes = Attribute::where('status', 1)
            ->orderBy('name')
            ->get();

        $mappingData = CategoryAttribute::with('attribute.values')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'category_id' => $m->category_id,
                'name' => $m->attribute->name ?? '—',
                'is_selectable' => (bool) $m->is_selectable,
                'values' => $m->attribute?->values->map(fn($v) => ['id' => $v->id, 'value' => $v->value])->values() ?? [],
            ])
            ->values();

        return view(
            'admin.category-attributes.edit',
            compact(
                'categoryAttribute',
                'categories',
                'attributes',
                'mappingData'

            )
        );
    }

    public function update(
        Request $request,
        CategoryAttribute $categoryAttribute
    ) {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',

            'used_for_variant' => 'required|boolean',
            'price_dependent' => 'nullable|boolean',
            'image_dependent' => 'nullable|boolean',
            'stock_dependent' => 'nullable|boolean',
            'sku_dependent' => 'nullable|boolean',

            'show_in_filter' => 'required|boolean',
            'show_on_listing' => 'required|boolean',

            'sort_order' => 'nullable|integer',
            'status' => 'required|boolean',

            'is_selectable' => 'nullable|boolean',
            'parent_category_attribute_id' => 'nullable|exists:category_attributes,id',
            'show_when_value_ids' => 'nullable|array',
            'show_when_value_ids.*' => 'integer',

        ]);

        $exists = CategoryAttribute::where(
            'category_id',
            $request->category_id
        )
            ->where(
                'attribute_id',
                $request->attribute_id
            )
            ->where(
                'id',
                '!=',
                $categoryAttribute->id
            )
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Mapping already exists.'
                );
        }

        // ✅ A non-selectable attribute cannot drive price/image/stock/sku
        $isVariant = $request->boolean('used_for_variant');

        $categoryAttribute->update([

            'category_id' => $request->category_id,

            'attribute_id' => $request->attribute_id,

            ...$this->dependencyFields($request, $categoryAttribute),

            'used_for_variant' => $isVariant,
            'price_dependent' => $isVariant && $request->boolean('price_dependent'),
            'image_dependent' => $isVariant && $request->boolean('image_dependent'),
            'stock_dependent' => $isVariant && $request->boolean('stock_dependent'),
            'sku_dependent' => $isVariant && $request->boolean('sku_dependent'),

            'show_in_filter' => $request->show_in_filter,

            'show_on_listing' => $request->show_on_listing,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.category-attributes.index')
            ->with(
                'success',
                'Category Attribute updated successfully.'
            );
    }

    public function destroy(CategoryAttribute $categoryAttribute)
    {
        $categoryAttribute->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully.'
        ]);
    }

    /**
     * is_selectable + parent/show_when ko validate karke return karta hai.
     * Rules: parent usi category ka ho, khud na ho, selectable ho, chain me cycle na ho.
     */
    private function dependencyFields(Request $request, ?CategoryAttribute $self): array
    {
        $selectable = $request->boolean('used_for_variant') || $request->boolean('is_selectable');

        // jis attribute par dusre depend karte hain, use non-selectable nahi bana sakte
        if ($self && !$selectable && $self->children()->exists()) {
            throw ValidationException::withMessages([
                'is_selectable' => 'Other attributes depend on this one, so it must stay customer-selectable.',
            ]);
        }

        $parentId = $request->parent_category_attribute_id ?: null;
        $values = [];

        if ($parentId) {
            $parent = CategoryAttribute::with('attribute.values')->find($parentId);

            if (!$parent || (int) $parent->category_id !== (int) $request->category_id) {
                throw ValidationException::withMessages([
                    'parent_category_attribute_id' => 'Parent attribute must belong to the same category.',
                ]);
            }

            if (!$parent->is_selectable) {
                throw ValidationException::withMessages([
                    'parent_category_attribute_id' => 'Parent attribute must be customer-selectable.',
                ]);
            }

            // cycle check: parent se upar chalte hue khud mil gaye to loop hai
            if ($self) {
                $cursor = $parent;
                $guard = 0;

                while ($cursor && $guard++ < 20) {
                    if ($cursor->id === $self->id) {
                        throw ValidationException::withMessages([
                            'parent_category_attribute_id' => 'This creates a circular dependency.',
                        ]);
                    }
                    $cursor = $cursor->parent_category_attribute_id
                        ? CategoryAttribute::find($cursor->parent_category_attribute_id)
                        : null;
                }
            }

            $valid = $parent->attribute->values->pluck('id')->all();
            $values = array_values(array_intersect(
                array_map('intval', (array) $request->show_when_value_ids),
                $valid
            ));

            if (empty($values)) {
                throw ValidationException::withMessages([
                    'show_when_value_ids' => 'Select at least one parent value that shows this attribute.',
                ]);
            }
        }

        return [
            'is_selectable' => $selectable,
            'parent_category_attribute_id' => $parentId,
            'show_when_value_ids' => $parentId ? $values : null,
        ];
    }
}