<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);

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
            'wo_prefix' => Setting::getValue('wo_prefix', '86'),
            'wo_tracking_enabled' => Setting::getValue('wo_tracking_enabled', true),
            'stock_opname_enabled' => Setting::getValue('stock_opname_enabled', true),
            'overmate_enabled' => Setting::getValue('overmate_enabled', true),
        ];

        return view('admin.settings.wo', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'wo_prefix' => 'required|string|max:10',
            'wo_tracking_enabled' => 'boolean',
            'stock_opname_enabled' => 'boolean',
            'overmate_enabled' => 'boolean',
        ]);

        // Update WO prefix
        Setting::setWOPrefix($request->wo_prefix);

        // Update other settings
        Setting::setValue('wo_tracking_enabled', $request->boolean('wo_tracking_enabled'), 'boolean', 'wo');
        Setting::setValue('stock_opname_enabled', $request->boolean('stock_opname_enabled'), 'boolean', 'stock_opname');
        Setting::setValue('overmate_enabled', $request->boolean('overmate_enabled'), 'boolean', 'overmate');

        return redirect()->route('settings.edit')
            ->with('success', 'Pengaturan berhasil diupdate!');
    }

    public function reset()
    {
        // Reset to default values
        Setting::setWOPrefix('86');
        Setting::setValue('wo_tracking_enabled', true, 'boolean', 'wo');
        Setting::setValue('stock_opname_enabled', true, 'boolean', 'stock_opname');
        Setting::setValue('overmate_enabled', true, 'boolean', 'overmate');

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
