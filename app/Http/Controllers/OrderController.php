<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(RestaurantTable $table)
    {
        $menuItems = MenuItem::where('is_available', true)->orderBy('category')->orderBy('name')->get();

        return view('orders.create', compact('table', 'menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_table_id' => 'required|exists:restaurant_tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:0|max:50',
        ]);

        // Drop any lines left at zero from the quantity stepper.
        $data['items'] = array_values(array_filter($data['items'], fn ($line) => $line['quantity'] > 0));

        if (empty($data['items'])) {
            return back()->withErrors(['items' => 'Add at least one item to the order.']);
        }

        $order = Order::create([
            'restaurant_table_id' => $data['restaurant_table_id'],
            'status' => 'open',
        ]);

        foreach ($data['items'] as $line) {
            $menuItem = MenuItem::find($line['menu_item_id']);
            $order->items()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $line['quantity'],
                'unit_price' => $menuItem->price,
            ]);
        }

        $order->table->update(['status' => 'occupied']);

        return redirect()->route('orders.show', $order)->with('status', 'Order placed.');
    }

    public function show(Order $order)
    {
        $order->load(['items.menuItem', 'table']);

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:open,preparing,served,paid,cancelled',
        ]);

        if ($data['status'] === 'paid') {
            $order->markPaid();
        } else {
            $order->update(['status' => $data['status']]);
        }

        return back()->with('status', 'Order updated.');
    }
}
