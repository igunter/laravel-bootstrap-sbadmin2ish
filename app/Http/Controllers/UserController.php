<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Columns DataTables is allowed to order/search by, keyed by column index.
     *
     * @var array<int, string>
     */
    protected array $sortable = [
        0 => 'name',
        1 => 'email',
        2 => 'is_admin',
        3 => 'created_at',
    ];

    public function index(): View
    {
        return view('users.index');
    }

    public function data(Request $request): JsonResponse
    {
        $query = User::query();

        if ($search = $request->input('search.value')) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $recordsTotal = User::count();
        $recordsFiltered = (clone $query)->count();

        $orderColumn = $this->sortable[$request->integer('order.0.column')] ?? 'name';
        $orderDir = $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc';

        $users = $query
            ->orderBy($orderColumn, $orderDir)
            ->skip($request->integer('start'))
            ->take($request->integer('length', 10))
            ->get();

        $data = $users->map(fn (User $user) => [
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'created_at' => $user->created_at->format('M j, Y'),
            'edit_url' => route('users.edit', $user),
            'delete_url' => route('users.destroy', $user),
            'is_self' => $request->user()->is($user),
        ]);

        return response()->json([
            'draw' => $request->integer('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['sometimes', 'boolean'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }

    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.edit', $user);
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['sometimes', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $request->boolean('is_admin');

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }
}
