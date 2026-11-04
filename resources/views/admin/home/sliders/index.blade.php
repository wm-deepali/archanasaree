@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Home Sliders</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a>
                        <span>›</span>
                        Home Sliders
                    </div>
                </div>
                <a href="{{ route('admin.home.sliders.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Slider
                </a>
            </div>

            @if(session('success'))
                <div class="alert-box">{{ session('success') }}</div>
            @endif

            <div class="list-card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="width:120px">Image</th>
                                <th>Content</th>
                                <th>Buttons</th>
                                <th style="width:90px">Theme</th>
                                <th style="width:90px">Sort</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                                <tr id="row{{ $slider->id }}">

                                    <td><span class="id-chip">{{ $slider->id }}</span></td>

                                    <td>
                                        @if($slider->image)
                                            <img src="{{ asset('storage/' . $slider->image) }}" class="slider-img"
                                                alt="Slider #{{ $slider->id }}">
                                        @else
                                            <div class="slider-img-placeholder"><i class="fa fa-image"></i></div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($slider->eyebrow)
                                            <div class="txt-eyebrow">{{ $slider->eyebrow }}</div>
                                        @endif
                                        @if($slider->title)
                                            <div class="txt-title" title="{{ $slider->title }}">
                                                {{ str_replace(["\r\n", "\n"], ' ', $slider->title) }}
                                            </div>
                                        @endif
                                        @if(!$slider->eyebrow && !$slider->title)
                                            <span class="txt-muted">Image only</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $btns = collect([
                                                [$slider->primary_btn_text, $slider->primary_btn_link],
                                                [$slider->secondary_btn_text, $slider->secondary_btn_link],
                                            ])->filter(fn($b) => filled($b[0]));
                                        @endphp
                                        @forelse($btns as [$text, $link])
                                            {{-- a button without a link is hidden on the site, so flag it --}}
                                            <span class="btn-chip {{ filled($link) ? '' : 'warn' }}"
                                                title="{{ filled($link) ? $link : 'No link: hidden on site' }}">{{ $text }}</span>
                                        @empty
                                            <span class="txt-muted">None</span>
                                        @endforelse
                                    </td>

                                    <td><span class="theme-chip">{{ $slider->theme }}</span></td>

                                    <td><span class="sort-chip">{{ $slider->sort_order }}</span></td>

                                    <td>
                                        @if($slider->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.home.sliders.edit', $slider->id) }}" class="action-btn"
                                                title="Edit"><i class="fa fa-pencil"></i></a>
                                            <button type="button" class="action-btn action-btn-danger"
                                                onclick="deleteSlider({{ $slider->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-picture-o"></i></div>
                                            <strong style="font-size:14px;color:var(--text-primary)">No sliders
                                                found</strong>
                                            <p>Add homepage slides to display the hero banner.</p>
                                            <a href="{{ route('admin.home.sliders.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Slider
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-bar">
                    {{ $sliders->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    function deleteSlider(id) {
        Swal.fire({
            title: 'Delete Slider?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b22222',
            cancelButtonColor: '#6d7175',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/home/sliders/delete') }}/" + id,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    beforeSend: function () { Swal.showLoading(); },
                    success: function (res) {
                        Swal.fire('Deleted!', res.message, 'success');
                        $("#row" + id).fadeOut(300, function () { $(this).remove(); });
                    },
                    error: function () {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }
</script>