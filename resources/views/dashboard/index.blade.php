@extends('layouts.restaurant')

@section('title', 'Floor')

@section('content')
    <div class="flex items-baseline justify-between mb-6">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Floor</h1>
            <p class="text-sm text-ink/50 mt-1">{{ $tables->count() }} tables · tap one to start or continue an order</p>
        </div>
        <a href="{{ route('tables.index') }}" class="text-sm font-medium text-ink/60 hover:text-ink underline underline-offset-4">
            Manage tables
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($tables as $table)
            @php
                $order = $table->orders->first();
                $statusColor = match(true) {
                    $order !== null => 'signal',
                    $table->status === 'reserved' => 'wait',
                    default => 'go',
                };
                $label = $order ? ucfirst($order->status) : ucfirst($table->status);
            @endphp
            <a href="{{ $order ? route('orders.show', $order) : route('orders.create', $table) }}"
               class="group block bg-white border border-raildark rounded-lg p-4 hover:shadow-md hover:-translate-y-0.5 transition">
                <div class="flex items-start justify-between mb-3">
                    <p class="font-display text-lg uppercase tracking-wide">{{ $table->name }}</p>
                    <span class="w-2.5 h-2.5 rounded-full status-dot bg-{{ $statusColor }} mt-1.5"></span>
                </div>
                <p class="text-xs text-ink/50 mb-2">{{ $table->seats }} seats</p>
                <p class="text-xs font-mono font-medium text-{{ $statusColor }} uppercase tracking-wide">{{ $label }}</p>
                @if ($order)
                    <p class="mt-2 text-sm font-mono font-semibold">${{ number_format($order->items->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}</p>
                @endif
            </a>
        @endforeach
    </div>

    @if ($tables->isEmpty())
        <div class="text-center py-16 text-ink/40">
            <p class="font-display text-lg uppercase">No tables yet</p>
            <p class="text-sm mt-1">Add your first table to start taking orders.</p>
            <a href="{{ route('tables.index') }}" class="inline-block mt-4 px-4 py-2 bg-ink text-paper rounded text-sm font-medium">Manage tables</a>
        </div>
    @endif
@endsection
