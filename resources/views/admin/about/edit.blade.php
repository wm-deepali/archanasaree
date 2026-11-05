@php
    $names = [
        'eyebrow' => 'Eyebrow', 'title' => 'Title', 'description' => 'Description',
        'description_2' => 'Second Paragraph', 'description_3' => 'Third Paragraph',
        'btn_text' => 'Button Text', 'btn_link' => 'Button Link', 'tag' => 'Tag',
        'image' => 'Image', 'image_2' => 'Second Image',
    ];
    $labels = $cfg['labels'] ?? [];
    $textareas = ['title', 'description', 'description_2', 'description_3'];
    $current = fn($f) => $section->{$f} ? ($f === 'image' ? $section->image_url : $section->image_2_url) : null;
@endphp
@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>{{ $cfg['label'] }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.about.index') }}">About Page</a><span>›</span>
                        {{ $cfg['label'] }}
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="err-box"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.about.update', $key) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="create-layout">
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Content</h5></div>
                            <div class="section-card-body">
                                @foreach ($cfg['fields'] as $f)
                                    @continue(in_array($f, ['image', 'image_2']))
                                    <div class="field-group">
                                        <label class="field-label">{{ $labels[$f] ?? $names[$f] }}</label>
                                        @if (in_array($f, $textareas))
                                            <textarea name="{{ $f }}" class="field-textarea" maxlength="1500">{{ old($f, $section->{$f}) }}</textarea>
                                            @if ($f === 'title')
                                                <div class="field-hint">Press Enter to start a new line.</div>
                                            @endif
                                        @else
                                            <input type="text" name="{{ $f }}" class="field-input" maxlength="255"
                                                value="{{ old($f, $section->{$f}) }}"
                                                @if ($f === 'btn_link') placeholder="/products" @endif>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if (in_array('image', $cfg['fields']) || in_array('image_2', $cfg['fields']))
                            <div class="section-card">
                                <div class="section-card-header"><h5>Images</h5></div>
                                <div class="section-card-body">
                                    @foreach (['image', 'image_2'] as $f)
                                        @if (in_array($f, $cfg['fields']))
                                            @include('admin.home._image-field', [
                                                'name' => $f,
                                                'label' => $labels[$f] ?? $names[$f],
                                                'current' => $current($f),
                                            ])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @foreach (($cfg['groups'] ?? []) as $g => $gc)
                            @php
                                $rows = old(
                                    "items.$g",
                                    $section->items->where('group_key', $g)
                                        ->map(fn($it) => $it->only(['title', 'description', 'icon', 'value', 'link']))
                                        ->values()->all()
                                );
                            @endphp
                            <div class="section-card">
                                <div class="section-card-header" style="display:flex;justify-content:space-between;align-items:center">
                                    <h5>{{ $gc['label'] }} <span style="font-weight:400;color:var(--text-hint)">(max {{ $gc['max'] }})</span></h5>
                                    <button type="button" class="btn-secondary-dash" style="padding:5px 12px" onclick="addItem('{{ $g }}')">
                                        <i class="fa fa-plus"></i> Add
                                    </button>
                                </div>
                                <div class="section-card-body" id="grp-{{ $g }}" data-next="{{ count($rows) }}">
                                    @foreach ($rows as $i => $row)
                                        @include('admin.about._item-row', ['g' => $g, 'i' => $i, 'row' => $row, 'gc' => $gc])
                                    @endforeach
                                </div>
                                <template id="tpl-{{ $g }}">
                                    @include('admin.about._item-row', ['g' => $g, 'i' => '__i__', 'row' => [], 'gc' => $gc])
                                </template>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Show this section</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $section->exists ? (int) $section->status : 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $section->exists ? (int) $section->status : 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if (!empty($cfg['groups']))
                            <div class="section-card">
                                <div class="section-card-body" style="font-size:12.5px;color:var(--text-secondary);line-height:1.8">
                                    Items show in the order listed. Rows with an empty title are ignored on save. Numbers (01, 02...) are added automatically.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.about.index') }}" class="btn-secondary-dash">Back</a>
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Section</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('admin.footer')

<script>
    function addItem(g) {
        const box = document.getElementById('grp-' + g);
        const i = Number(box.dataset.next);
        box.dataset.next = i + 1;
        box.insertAdjacentHTML('beforeend', document.getElementById('tpl-' + g).innerHTML.replaceAll('__i__', i));
    }
</script>