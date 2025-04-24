<!-- resources/views/components/status-badge.blade.php -->

@php
    $badgeClass = match ($status) {
        'pending' => 'warning',
        'processing' => 'primary',
        'shipped' => 'info',
        'delivered' => 'success',
        'cancelled' => 'danger',
        default => 'secondary',
    };
@endphp

<span class="badge bg-{{ $badgeClass }}">{{ ucfirst($status) }}</span>
