@extends('layouts.restaurant')

@section('title', 'Order · ' . $order->table->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-xs text-ink/40 hover:text-ink">&larr; Floor</a>
        <h1 class="font-display text-3xl uppercase tracking-wide mt-1">{{ $order->table->name }}</h1>
        <p class="text-sm text-ink/50">Order #{{ $order->id }} · placed {{ $order->created_at->format('g:ia') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-raildark rounded-lg p-5">
                <p class="text-xs font-mono uppercase tracking-widest text-ink/40 mb-3">Status</p>
                <form action="{{ route('orders.status', $order) }}" method="POST" class="flex flex-wrap gap-2">
                    @csrf
                    @foreach (['open' => 'Open', 'preparing' => 'Preparing', 'served' => 'Served', 'paid' => 'Paid', 'cancelled' => 'Cancelled'] as $value => $label)
                        <button type="submit" name="status" value="{{ $value }}"
                                class="px-3 py-1.5 rounded-full text-xs font-medium uppercase tracking-wide border
                                       {{ $order->status === $value ? 'bg-ink text-paper border-ink' : 'border-raildark text-ink/60 hover:border-ink/40' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </form>
            </div>

            @if ($order->notes)
                <div class="bg-white border border-raildark rounded-lg p-5">
                    <p class="text-xs font-mono uppercase tracking-widest text-ink/40 mb-2">Notes</p>
                    <p class="text-sm">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white border border-raildark rounded-lg p-6 relative"
             style="background-image: repeating-linear-gradient(to bottom, transparent 0, transparent 6px, #E8E1D3 6px, #E8E1D3 8px); background-size: 1px 8px; background-repeat: repeat-y; background-position: left 0 top 0;">
            <div class="text-center mb-4 pb-4 border-b border-dashed border-raildark">
                <p class="font-display text-lg uppercase tracking-widest">The Pass</p>
                <p class="text-xs text-ink/50">{{ $order->table->name }} · #{{ $order->id }}</p>
            </div>

            <div class="space-y-2 font-mono text-sm">
                @foreach ($order->items as $item)
                    <div class="flex justify-between">
                        <span class="text-ink/80">{{ $item->quantity }}&times; {{ $item->menuItem->name }}</span>
                        <span>${{ number_format($item->subtotal(), 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-dashed border-raildark flex justify-between items-baseline">
                <span class="font-display uppercase tracking-wide text-sm">Total</span>
                <span class="font-mono text-xl font-semibold">${{ number_format($order->total(), 2) }}</span>
            </div>

            @if ($order->status !== 'paid')
                <form action="{{ route('orders.status', $order) }}" method="POST" class="mt-5"
                      onsubmit="return confirm('Mark this bill as paid?');">
                    @csrf
                    <input type="hidden" name="status" value="paid">
                    <button type="submit" class="w-full bg-go text-white rounded py-2.5 text-sm font-medium hover:bg-go/90">
                        Mark paid
                    </button>
                </form>
            @else
                <p class="mt-5 text-center text-xs font-mono uppercase tracking-widest text-go">Paid · {{ $order->paid_at->format('g:ia') }}</p>
            @endif
        </div>
    </div>
@endsection
