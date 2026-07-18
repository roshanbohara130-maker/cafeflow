<?php

namespace App\Http\Controllers;

use App\Models\DailyEntry;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Render the dashboard shell (page loads entries via JS after mount).
     */
    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * Return all of the logged-in user's daily entries, oldest first.
     */
    public function entries(): JsonResponse
    {
        $entries = auth()->user()
            ->dailyEntries()
            ->orderBy('date')
            ->get(['date', 'revenue', 'orders', 'covers']);

        return response()->json($entries);
    }

    /**
     * Create or overwrite the entry for a given date.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'date'    => ['required', 'date'],
            'revenue' => ['required', 'numeric', 'min:0'],
            'orders'  => ['required', 'integer', 'min:0'],
            'covers'  => ['required', 'integer', 'min:0'],
        ]);

        $entry = DailyEntry::updateOrCreate(
            ['user_id' => auth()->id(), 'date' => $data['date']],
            $data
        );

        return response()->json($entry);
    }

    /**
     * Delete the entry for a given date.
     */
    public function destroy(string $date): JsonResponse
    {
        auth()->user()
            ->dailyEntries()
            ->where('date', $date)
            ->delete();

        return response()->json(['ok' => true]);
    }
}