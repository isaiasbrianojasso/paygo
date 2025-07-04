@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-4 rounded-3" role="alert">
    ✅ {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-4 rounded-3" role="alert">
    ❌ {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif