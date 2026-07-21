<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();

        return view('menu.index', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999.99',
        ]);

        MenuItem::create($data);

        return back()->with('status', 'Menu item added.');
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999.99',
            'is_available' => 'sometimes|boolean',
        ]);

        $data['is_available'] = $request->boolean('is_available');

        $menuItem->update($data);

        return back()->with('status', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return back()->with('status', 'Menu item removed.');
    }
}
