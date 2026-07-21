@extends('layouts.restaurant')

@section('title', 'New order · ' . $table->name)

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xs text-ink/40 hover:text-ink">&larr; Floor</a>
            <h1 class="font-display text-3xl uppercase tracking-wide mt-1">{{ $table->name }}</h1>
            <p class="text-sm text-ink/50">{{ $table->seats }} seats · new order</p>
        </div>
    </div>

    @if ($menuItems->isEmpty())
        <p class="text-sm text-ink/50">No menu items available. Add some in the <code>menu_items</code> table first.</p>
    @else
        <form action="{{ route('orders.store') }}" method="POST" x-data="orderForm()">
            @csrf
            <input type="hidden" name="restaurant_table_id" value="{{ $table->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    @foreach ($menuItems->groupBy('category') as $category => $items)
                        <div>
                            <p class="text-xs font-mono uppercase tracking-widest text-ink/40 mb-2">{{ $category }}</p>
                            <div class="bg-white border border-raildark rounded-lg divide-y divide-rail">
                                @foreach ($items as $item)
                                    <div class="flex items-center justify-between px-4 py-3">
                                        <div>
                                            <p class="font-medium text-sm">{{ $item->name }}</p>
                                            <p class="text-xs font-mono text-ink/50">${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="dec({{ $item->id }})"
                                                    class="w-7 h-7 rounded border border-raildark text-sm font-medium hover:bg-rail">-</button>
                                            <input type="number" name="items[{{ $item->id }}][quantity]" min="0" max="50"
                                                   x-model.number="qty[{{ $item->id }}]"
                                                   class="w-10 text-center text-sm border-0 focus:ring-0 font-mono">
                                            <input type="hidden" name="items[{{ $item->id }}][menu_item_id]" value="{{ $item->id }}">
                                            <button type="button" @click="inc({{ $item->id }})"
                                                    class="w-7 h-7 rounded border border-raildark text-sm font-medium hover:bg-rail">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white border border-raildark rounded-lg p-5 h-fit sticky top-6">
                    <p class="font-display uppercase tracking-wide mb-3">Ticket</p>
                    <template x-if="itemCount() === 0">
                        <p class="text-sm text-ink/40">No items selected yet.</p>
                    </template>
                    <template x-if="itemCount() > 0">
                        <p class="text-sm text-ink/60 mb-4" x-text="itemCount() + ' item(s) selected'"></p>
                    </template>
                    <button type="submit" :disabled="itemCount() === 0"
                            class="w-full bg-ink text-paper rounded py-2.5 text-sm font-medium disabled:opacity-30 disabled:cursor-not-allowed hover:bg-ink/90">
                        Send order
                    </button>
                </div>
            </div>
        </form>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function orderForm() {
            return {
                qty: { @foreach ($menuItems as $item) {{ $item->id }}: 0, @endforeach },
                inc(id) { this.qty[id] = (this.qty[id] || 0) + 1 },
                dec(id) { this.qty[id] = Math.max(0, (this.qty[id] || 0) - 1) },
                itemCount() { return Object.values(this.qty).filter(q => q > 0).length }
            }
        }
    </script>
@endsection
