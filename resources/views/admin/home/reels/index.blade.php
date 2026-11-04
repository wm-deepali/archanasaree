@include('admin.top-header')
<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="detail-page">

            <div class="detail-page-header">
                <div>
                    <h1>Style in Motion (Reels)</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Manage Home Page</a><span>›</span>
                        Reels
                    </div>
                </div>
                <a href="{{ route('admin.home.reels.create') }}" class="btn-primary-dash"><i class="fa fa-plus"></i> Add Reel</a>
            </div>

            @if (session('success'))
                <div class="ok-box">{{ session('success') }}</div>
            @endif

            <div class="section-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:80px">Cover</th>
                            <th>Title</th>
                            <th>Video</th>
                            <th style="width:80px">Order</th>
                            <th style="width:100px">Status</th>
                            <th style="width:100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reels as $reel)
                            <tr id="reel-{{ $reel->id }}">
                                <td><img src="{{ $reel->thumbnail_url }}" class="thumb" alt=""></td>
                                <td>
                                    <strong>{{ $reel->title }}</strong>
                                    @if ($reel->subtitle)
                                        <div style="font-size:12px;color:var(--text-hint)">{{ $reel->subtitle }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($reel->video)
                                        Uploaded file
                                    @elseif ($reel->video_url)
                                        External link
                                    @else
                                        <span style="color:var(--text-hint)">None</span>
                                    @endif
                                </td>
                                <td>{{ $reel->sort_order }}</td>
                                <td><span class="pill {{ $reel->status ? 'pill-on' : 'pill-off' }}">{{ $reel->status ? 'Active' : 'Inactive' }}</span></td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('admin.home.reels.edit', $reel->id) }}" class="icon-btn" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="icon-btn danger" title="Delete" onclick="deleteReel({{ $reel->id }})"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;color:var(--text-hint);padding:32px">No reels yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $reels->links() }}

        </div>
    </div>
</div>
@include('admin.footer')

<script>
    function deleteReel(id) {
        if (!confirm('Delete this reel? This cannot be undone.')) return;

        fetch(@json(url('admin/home/reels')) + '/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(() => document.getElementById('reel-' + id)?.remove())
            .catch(() => alert('Could not delete. Please try again.'));
    }
</script>