@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('danger'))
<div class="alert alert-danger">
    {!! session('danger') !!}
</div>
@endif
@if (session('warning'))
<div class="alert alert-warning">
    {{ session('warning') }}
</div>
@endif

{{-- notifikasi data berhasil di simpan --}}
@if (session('ds'))
<div class="callout callout-success">
    <h5>Berhasil!</h5>
    <p>Data {{ session('ds') }} telah ditambahkan.</p>
  </div>
@endif

{{-- notifikasi data berhasil di update --}}
@if (session('du'))
<div class="callout callout-info">
    <h5>Berhasil!</h5>
    <p>Data {{ session('du') }} telah diperbaharui.</p>
  </div>
@endif

{{-- notifikasi data berhasil di hapus --}}
@if (session('dd'))
<div class="callout callout-danger">
    <h5>Berhasil!</h5>
    <p>Data {{ session('dd') }} telah dihapus.</p>
  </div>
@endif