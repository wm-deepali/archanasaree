@php $ca = $categoryAttribute ?? null; @endphp

<div class="toggle-row">
    <div>
        <div class="toggle-label">Customer Selectable</div>
        <div class="toggle-sub">Customer picks a value on the product page. "No" means info only.</div>
    </div>
    <select name="is_selectable" id="isSelectable" class="field-select-sm">
        <option value="1" {{ old('is_selectable', $ca?->is_selectable ?? 0) ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ !old('is_selectable', $ca?->is_selectable ?? 0) ? 'selected' : '' }}>No</option>
    </select>
</div>

<div class="dependency-group" id="showWhenGroup">
    <div class="dependency-title">Show Only When</div>
    <div class="dependency-hint">Leave as "Always show", or pick a parent attribute and the values that reveal this one.</div>

    <div class="field-group">
        <select name="parent_category_attribute_id" id="parentCa" class="field-select">
            <option value="">— Always show —</option>
        </select>
    </div>

    <div id="showWhenValues"></div>
</div>

<script>
    window.CA_MAP = @json($mappingData);
    window.CA_SELF = {{ $ca?->id ?? 'null' }};
    window.CA_INIT = {
        parent: @json(old('parent_category_attribute_id', $ca?->parent_category_attribute_id)),
        values: @json(array_map('intval', (array) old('show_when_value_ids', $ca?->show_when_value_ids ?? [])))
    };
</script>