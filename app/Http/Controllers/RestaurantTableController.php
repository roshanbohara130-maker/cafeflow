<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::orderBy('name')->get();

        return view('tables.index', compact('tables'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:50',
        ]);

        RestaurantTable::create($data);

        return back()->with('status', 'Table added.');
    }

    public function update(Request $request, RestaurantTable $table)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:50',
            'status' => 'required|in:available,occupied,reserved',
        ]);

        $table->update($data);

        return back()->with('status', 'Table updated.');
    }

    public function destroy(RestaurantTable $table)
    {
        $table->delete();

        return back()->with('status', 'Table removed.');
    }
}
