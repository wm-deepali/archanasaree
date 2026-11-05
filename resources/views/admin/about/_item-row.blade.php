@php
    $names = ['title' => 'Title', 'description' => 'Description', 'icon' => 'Icon (Font Awesome class)', 'value' => 'Value', 'link' => 'Link'];
    $glabels = $gc['labels'] ?? [];
@endphp
<div class="item-row" style="border:1px solid var(--border);border-radius:8px;padding:12px 52px 4px 12px;margin-bottom:10px;position:relative">
    <button type="button" class="icon-btn danger" style="position:absolute;top:10px;right:10px"
        onclick="this.closest('.item-row').remove()" title="Remove"><i class="fa fa-trash"></i></button>

    @foreach ($gc['fields'] as $f)
        <div class="field-group" style="margin-bottom:12px">
            <label class="field-label">{{ $glabels[$f] ?? $names[$f] }}</label>
            @if ($f === 'description')
                <textarea name="items[{{ $g }}][{{ $i }}][{{ $f }}]" class="field-textarea" maxlength="500">{{ $row[$f] ?? '' }}</textarea>
            @else
                <input type="text" name="items[{{ $g }}][{{ $i }}][{{ $f }}]" class="field-input"
                    value="{{ $row[$f] ?? '' }}"
                    @if ($f === 'icon') placeholder="fa-gem" @endif>
            @endif
        </div>
    @endforeach
</div>