@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Newsletter Subscribers</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a><span>›</span>
                        Subscribers
                    </div>
                </div>
                <a href="{{ route('admin.home.subscribers.export') }}" class="btn-secondary-dash"><i class="fa fa-download"></i> Export CSV</a>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif

            <div class="section-card">
                <div class="toolbar">
                    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
                        <input type="text" name="q" class="field-input" style="width:240px" placeholder="Search email"
                            value="{{ request('q') }}">
                        <select name="status" class="field-select-sm" style="height:38px">
                            <option value="">All</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Unsubscribed</option>
                        </select>
                        <button type="submit" class="btn-primary-dash">Filter</button>
                    </form>
                    <div class="stat-chip"><b>{{ $activeCount }}</b> active of <b>{{ $totalCount }}</b> total</div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th style="width:180px">Subscribed On</th>
                            <th style="width:110px">Status</th>
                            <th style="width:100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $sub)
                            <tr id="sub-{{ $sub->id }}">
                                <td>{{ $sub->email }}</td>
                                <td>{{ $sub->created_at->format('d M Y, h:i A') }}</td>
                                <td><span class="pill {{ $sub->status ? 'pill-on' : 'pill-off' }}">{{ $sub->status ? 'Active' : 'Unsubscribed' }}</span></td>
                                <td>
                                    <div class="row-actions">
                                        <form method="POST" action="{{ route('admin.home.subscribers.toggle', $sub->id) }}">
                                            @csrf
                                            <button type="submit" class="icon-btn" title="{{ $sub->status ? 'Unsubscribe' : 'Re-activate' }}">
                                                <i class="fa {{ $sub->status ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="icon-btn danger" title="Delete" onclick="deleteSub({{ $sub->id }})"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center;color:var(--text-hint);padding:32px">No subscribers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $subscribers->links() }}

        </div>
    </div>
</div>
@include('admin.footer')

<script>
    function deleteSub(id) {
        if (!confirm('Delete this subscriber?')) return;

        fetch(@json(url('admin/home/subscribers')) + '/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(() => document.getElementById('sub-' + id)?.remove())
            .catch(() => alert('Could not delete. Please try again.'));
    }
</script>