@extends('layouts.restaurant')

@section('title', 'Menu')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">🍽 Restaurant Menu</h1>
            <p class="text-gray-500 mt-1">Manage all your menu items in one place.</p>
        </div>

        <input
            type="text"
            id="search"
            placeholder="🔍 Search menu..."
            class="w-full md:w-80 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Menu Items -->
        <div class="lg:col-span-2">

            @forelse($menuItems->groupBy('category') as $category => $items)

                <div class="mb-8">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $category }}
                        </h2>

                        <span class="text-sm bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
                            {{ $items->count() }} Items
                        </span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">

                        @foreach($items as $item)

                        <div class="menu-card bg-white rounded-2xl shadow hover:shadow-xl transition duration-300 overflow-hidden border">

                            <!-- Image -->
                            <div class="h-40 bg-gradient-to-r from-orange-100 to-yellow-100 flex items-center justify-center">

                                @switch(strtolower($item->category))

                                    @case('drink')
                                        <span class="text-6xl">🥤</span>
                                        @break

                                    @case('coffee')
                                        <span class="text-6xl">☕</span>
                                        @break

                                    @case('pizza')
                                        <span class="text-6xl">🍕</span>
                                        @break

                                    @case('burger')
                                        <span class="text-6xl">🍔</span>
                                        @break

                                    @case('dessert')
                                        <span class="text-6xl">🍰</span>
                                        @break

                                    @default
                                        <span class="text-6xl">🍽️</span>

                                @endswitch

                            </div>

                            <div class="p-5">

                                <div class="flex justify-between items-start">

                                    <div>

                                        <h3 class="text-xl font-bold text-gray-800">
                                            {{ $item->name }}
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $item->category }}
                                        </p>

                                    </div>

                                    @if($item->is_available)

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Available
                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Sold Out
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-5 flex justify-between items-center">

                                    <h2 class="text-3xl font-bold text-indigo-600">
                                        ${{ number_format($item->price,2) }}
                                    </h2>

                                </div>

                                <div class="mt-6 flex gap-2">

                                    <!-- Toggle -->
                                    <form action="{{ route('menu.update',$item) }}" method="POST" class="flex-1">

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="name" value="{{ $item->name }}">
                                        <input type="hidden" name="category" value="{{ $item->category }}">
                                        <input type="hidden" name="price" value="{{ $item->price }}">
                                        <input type="hidden" name="is_available" value="{{ $item->is_available ? 0 : 1 }}">

                                        <button
                                            class="w-full py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white">

                                            {{ $item->is_available ? 'Disable' : 'Enable' }}

                                        </button>

                                    </form>

                                    <!-- Delete -->
                                    <form
                                        action="{{ route('menu.destroy',$item) }}"
                                        method="POST"
                                        class="flex-1"
                                        onsubmit="return confirm('Delete {{ $item->name }} ?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="w-full py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-xl shadow p-10 text-center">

                    <div class="text-7xl mb-4">
                        🍽️
                    </div>

                    <h2 class="text-2xl font-bold">
                        No Menu Items
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Add your first menu item using the form.
                    </p>

                </div>

            @endforelse

        </div>

        <!-- Add Item -->
        <div>

            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">

                <h2 class="text-2xl font-bold mb-6">
                    ➕ Add New Item
                </h2>

                <form action="{{ route('menu.store') }}" method="POST">

                    @csrf

                    <div class="space-y-4">

                        <div>

                            <label class="font-semibold block mb-2">
                                Item Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500"
                                placeholder="Cheese Burger">

                        </div>

                        <div>

                            <label class="font-semibold block mb-2">
                                Category
                            </label>

                            <select
                                name="category"
                                class="w-full border rounded-lg px-4 py-3">

                                <option>Coffee</option>
                                <option>Drink</option>
                                <option>Burger</option>
                                <option>Pizza</option>
                                <option>Main</option>
                                <option>Dessert</option>

                            </select>

                        </div>

                        <div>

                            <label class="font-semibold block mb-2">
                                Price
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                required
                                name="price"
                                class="w-full border rounded-lg px-4 py-3"
                                placeholder="0.00">

                        </div>

                        <button
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg text-lg font-semibold">

                            Save Menu Item

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.getElementById('search').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();

    document.querySelectorAll('.menu-card').forEach(card => {

        card.style.display =
            card.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';

    });

});
</script>

@endsection
