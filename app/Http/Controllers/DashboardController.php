<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;

class DashboardController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::with(['orders' => function ($query) {
            $query->whereNotIn('status', ['paid', 'cancelled'])->with('items');
        }])->orderBy('name')->get();

        return view('dashboard.index', compact('tables'));
    }
}
