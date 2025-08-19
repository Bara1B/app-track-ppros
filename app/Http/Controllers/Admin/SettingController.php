<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
        ];

        return view('admin.settings.index', compact('users', 'stats'));
    }

    public function edit()
    {
        $settings = [
            'wo_tracking_enabled' => config('app.wo_tracking_enabled', true),
            'stock_opname_enabled' => config('app.stock_opname_enabled', true),
            'overmate_enabled' => config('app.overmate_enabled', true),
        ];

        return view('admin.settings.wo', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'wo_tracking_enabled' => 'boolean',
            'stock_opname_enabled' => 'boolean',
            'overmate_enabled' => 'boolean',
        ]);

        // Update settings logic here
        // For now, just return success message
        return redirect()->route('settings.edit')
            ->with('success', 'Pengaturan berhasil diupdate!');
    }

    public function reset()
    {
        // Reset settings logic here
        return redirect()->route('settings.edit')
            ->with('success', 'Pengaturan berhasil direset ke default!');
    }

    // User Management Methods
    public function users()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.settings.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.settings.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.settings.users')
            ->with('success', 'User berhasil dibuat!');
    }

    public function editUser(User $user)
    {
        return view('admin.settings.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.settings.users')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.settings.users')
                ->with('error', 'Tidak bisa menghapus user yang sedang aktif!');
        }

        $user->delete();
        return redirect()->route('admin.settings.users')
            ->with('success', 'User berhasil dihapus!');
    }
}
