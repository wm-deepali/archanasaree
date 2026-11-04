@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.faq-categories._styles')

    <div class="app-content content container-fluid">
        <div class="faq-page">

            <div class="page-header">
                <div>
                    <h1>FAQ Categories</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.faqs.index') }}">Manage FAQ</a><span>›</span>
                        Categories
                    </div>
                </div>
                <a href="{{ route('admin.faq-categories.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Category
                </a>
            </div>

            @if (session('success'))
                <div style="background:var(--green-bg);color:var(--green);padding:10px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;font-weight:600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="faq-card">
                <div class="faq-table-wrap">
                    <table class="faq-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="width:60px">Icon</th>
                                <th>Name</th>
                                <th style="width:90px">Order</th>
                                <th style="width:90px">FAQs</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $cat)
                                <tr id="row{{ $cat->id }}">
                                    <td><span class="id-chip">{{ $cat->id }}</span></td>
                                    <td><span class="cat-ico"><i class="{{ $cat->icon }}"></i></span></td>
                                    <td><span class="question-text">{{ $cat->name }}</span></td>
                                    <td>{{ $cat->sort_order }}</td>
                                    <td><span class="cat-chip">{{ $cat->faqs_count }}</span></td>
                                    <td>
                                        @if ($cat->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.faq-categories.edit', $cat->id) }}" class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                onclick="deleteCategory({{ $cat->id }}, {{ $cat->faqs_count }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-folder-open"></i></div>
                                            <strong style="font-size:14px">No categories found</strong>
                                            <p>Create categories to group FAQs into tabs.</p>
                                            <a href="{{ route('admin.faq-categories.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteCategory(id, count) {
    Swal.fire({
        title: 'Delete category?',
        text: count > 0
            ? count + ' FAQ(s) in this category will move to "General". This cannot be undone.'
            : 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then(function (result) {
        if (!result.isConfirmed) return;
        $.ajax({
            url: "{{ url('admin/faq-categories') }}/" + id,
            type: "DELETE",
            data: { _token: "{{ csrf_token() }}" },
            beforeSend: function () { Swal.showLoading(); },
            success: function (res) {
                Swal.fire('Deleted!', res.message, 'success');
                $("#row" + id).fadeOut(400, function () { $(this).remove(); });
            },
            error: function () { Swal.fire('Error!', 'Something went wrong.', 'error'); }
        });
    });
}
</script>