@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.faq-categories._styles')

    <div class="app-content content container-fluid">
        <div class="faq-page">

            <div class="page-header">
                <div>
                    <h1>Edit Category</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.faq-categories.index') }}">FAQ Categories</a><span>›</span>
                        Edit Category
                    </div>
                </div>
            </div>

            <form id="categoryForm" method="POST" action="{{ route('admin.faq-categories.update', $category->id) }}">
                @csrf
                @method('PUT')
                @include('admin.faq-categories._form', ['category' => $category])
            </form>

        </div>
    </div>
</div>

@include('admin.footer')