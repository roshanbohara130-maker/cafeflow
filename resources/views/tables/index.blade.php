@extends('layouts.restaurant')

@section('title', 'Tables')

@section('content')
    <h1 class="font-display text-3xl uppercase tracking-wide mb-6">Tables</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white border border-raildark rounded-lg divide-y divide-rail">
            @forelse ($tables as $table)
                <div class="px-5 py-3.5 flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $table->name }}</p>
                        <p class="text-xs text-ink/50">{{ $table->seats }} seats</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('tables.update', $table) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $table->name }}">
                            <input type="hidden" name="seats" value="{{ $table->seats }}">
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-mono uppercase border border-raildark rounded px-2 py-1 bg-paper">
                                <option value="available" @selected($table->status === 'available')>Available</option>
                                <option value="occupied" @selected($table->status === 'occupied')>Occupied</option>
                                <option value="reserved" @selected($table->status === 'reserved')>Reserved</option>
                            </select>
                        </form>
                        <form action="{{ route('tables.destroy', $table) }}" method="POST"
                              onsubmit="return confirm('Remove {{ $table->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-signal/70 hover:text-signal font-medium">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="px-5 py-6 text-sm text-ink/40">No tables yet — add one to the right.</p>
            @endforelse
        </div>

        <div class="bg-white border border-raildark rounded-lg p-5 h-fit">
            <p class="font-display uppercase tracking-wide mb-4">Add table</p>
            <form action="{{ route('tables.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-ink/60 mb-1">Name</label>
                    <input type="text" name="name" required placeholder="e.g. Table 5"
                           class="w-full border border-raildark rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ink/20">
                </div>
                <div>
                    <label class="block text-xs font-medium text-ink/60 mb-1">Seats</label>
                    <input type="number" name="seats" min="1" max="50" value="2" required
                           class="w-full border border-raildark rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ink/20">
                </div>
                <button type="submit" class="w-full bg-ink text-paper rounded py-2 text-sm font-medium hover:bg-ink/90">
                    Add table
                </button>
            </form>
        </div>
    </div>
@endsection
