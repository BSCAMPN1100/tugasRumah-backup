{{--
    Partial: Empty State
    Deskripsi: Menampilkan pesan & aksi saat data kosong.

    Parameter (via @include):
    - $icon         (string, wajib)   : emoji/icon besar. Contoh: '📦'
    - $title        (string, wajib)   : judul utama. Contoh: 'Belum Ada Barang'
    - $description  (string, opsional): penjelasan singkat.
    - $actionUrl    (string, opsional): URL tombol aksi.
    - $actionLabel  (string, opsional): label tombol aksi.
    - $size         (string, opsional): 'default' | 'sm'. Default: 'default'.
--}}

@php
    $sizeClass = ($size ?? 'default') === 'sm' ? 'empty-state-sm' : '';
@endphp

<div class="empty-state {{ $sizeClass }}">
    @if(!empty($icon))
        <div class="empty-state-icon" aria-hidden="true">{{ $icon }}</div>
    @endif

    @if(!empty($title))
        <h3 class="empty-state-title">{{ $title }}</h3>
    @endif

    @if(!empty($description))
        <p class="empty-state-description">{{ $description }}</p>
    @endif

    @if(!empty($actionUrl) && !empty($actionLabel))
        <a href="{{ $actionUrl }}" class="empty-state-action">
            {{ $actionLabel }}
        </a>
    @endif
</div>
