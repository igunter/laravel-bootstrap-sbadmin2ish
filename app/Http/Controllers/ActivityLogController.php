<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Columns DataTables is allowed to order by, keyed by column index.
     *
     * @var array<int, string>
     */
    protected array $sortable = [
        0 => 'created_at',
        1 => 'action',
    ];

    public function index(): View
    {
        return view('activity-log.index');
    }

    public function data(Request $request): JsonResponse
    {
        $query = ActivityLog::query()->with('causer');

        if ($search = $request->input('search.value')) {
            $query->where(function ($query) use ($search) {
                $query->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('causer', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $recordsTotal = ActivityLog::count();
        $recordsFiltered = (clone $query)->count();

        $orderColumn = $this->sortable[$request->integer('order.0.column')] ?? 'created_at';
        $orderDir = $request->input('order.0.dir') === 'asc' ? 'asc' : 'desc';

        $logs = $query
            ->orderBy($orderColumn, $orderDir)
            ->skip($request->integer('start'))
            ->take($request->integer('length', 10))
            ->get();

        $data = $logs->map(fn (ActivityLog $log) => [
            'created_at' => $log->created_at->format('M j, Y g:i A'),
            'causer' => $log->causer?->name ?? 'System',
            'action' => $log->action,
            'description' => $log->description,
            'ip_address' => $log->ip_address,
            'old_values' => $log->old_values,
            'new_values' => $log->new_values,
        ]);

        return response()->json([
            'draw' => $request->integer('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
