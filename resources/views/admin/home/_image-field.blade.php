@php $fid = 'img_' . $name; @endphp
<div class="field-group">
    <label class="field-label">{{ $label }}</label>
    <div class="upload-zone" style="padding:18px 16px">
        <input type="file" name="{{ $name }}" id="{{ $fid }}" accept=".jpg,.jpeg,.png,.webp">
        <div class="uz-title">Click or drag to {{ $current ? 'replace' : 'upload' }}</div>
        <div class="uz-sub">{{ $hint ?? 'JPG, PNG, WEBP · Max 5 MB' }}</div>
    </div>
    <img id="{{ $fid }}_prev" src="{{ $current }}" alt=""
        style="{{ $current ? '' : 'display:none;' }}width:100%;max-height:170px;object-fit:cover;border-radius:8px;border:1px solid var(--border);margin-top:10px">
</div>
<script>
    document.getElementById('{{ $fid }}').addEventListener('change', function () {
        const f = this.files[0];
        if (!f) return;
        const r = new FileReader();
        r.onload = e => {
            const img = document.getElementById('{{ $fid }}_prev');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        r.readAsDataURL(f);
    });
</script>