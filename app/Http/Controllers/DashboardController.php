<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }

    public function signups(): JsonResponse
    {
        $days = 30;
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $counts = User::query()
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $running = User::query()->where('created_at', '<', $start)->count();

        $labels = [];
        $data = [];
        $cumulative = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $key = $date->format('Y-m-d');
            $count = (int) ($counts[$key] ?? 0);

            $labels[] = $date->format('M j');
            $data[] = $count;

            $running += $count;
            $cumulative[] = $running;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'cumulative' => $cumulative,
        ]);
    }
}
