@php $c = $category ?? null; @endphp

<div class="form-layout">
    <div>
        <div class="section-card">
            <div class="section-card-header"><h5>Category Details</h5></div>
            <div class="section-card-body">

                <div class="field-group">
                    <label class="field-label">Name <span class="req">*</span></label>
                    <input type="text" name="name" required
                        class="field-input @error('name') is-invalid @enderror"
                        value="{{ old('name', $c->name ?? '') }}"
                        placeholder="e.g. Shipping & Delivery">
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Icon (Font Awesome classes)</label>
                    <input type="text" name="icon" id="iconInput" class="field-input"
                        value="{{ old('icon', $c->icon ?? 'fa-solid fa-circle-question') }}"
                        placeholder="fa-solid fa-truck-fast">
                    <div class="field-hint">Copy the class string from fontawesome.com, e.g. <code>fa-solid fa-truck-fast</code></div>
                    <div class="icon-preview">
                        <span class="cat-ico"><i id="iconPreview" class="fa-solid fa-circle-question"></i></span>
                        <span style="font-size:12px;color:var(--text-hint)">Preview</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div>
        <div class="section-card">
            <div class="section-card-header"><h5>Settings</h5></div>
            <div class="section-card-body" style="padding:16px 20px">

                <div class="field-group">
                    <label class="field-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0" class="field-input"
                        value="{{ old('sort_order', $c->sort_order ?? 0) }}">
                    <div class="field-hint">Lower numbers appear first in the tabs.</div>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Active</div>
                        <div class="toggle-sub">Show this tab on the FAQ page</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="status" value="1"
                            {{ old('status', $c ? $c->status : 1) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="action-bar">
    <a href="{{ route('admin.faq-categories.index') }}" class="btn-secondary-dash">Cancel</a>
    <button type="submit" id="saveBtn" class="btn-primary-dash">
        <i class="fa-solid fa-save"></i> {{ $c ? 'Update Category' : 'Save Category' }}
    </button>
</div>

<script>
(function () {
    var input = document.getElementById('iconInput'),
        prev  = document.getElementById('iconPreview');
    function paint() { prev.className = input.value.trim() || 'fa-solid fa-circle-question'; }
    input.addEventListener('input', paint);
    paint();

    document.getElementById('categoryForm').addEventListener('submit', function () {
        var b = document.getElementById('saveBtn');
        b.disabled = true;
        b.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
})();
</script>