<?php

namespace App\Http\Controllers\KelolaAkses;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaAksesController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required|string|max:50',
                'password' => 'required|string|min:6',
                'main' => 'boolean', // Tambahkan validasi untuk 'main'
            ]);

            $validated['password'] = Hash::make($validated['password']);
            // Pastikan 'main' ada di $validated, default ke false jika tidak ada
            $validated['main'] = $request->has('main') ? (bool)$request->input('main') : false;

            $user = User::create($validated);

            return response()->json([
                'message' => 'User berhasil dibuat.',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat user: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string|max:50',
                'password' => 'nullable|string|min:6',
                'main' => 'nullable|boolean', // Tambahkan validasi untuk 'main'
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            // Tangani kolom 'main'
            if ($request->has('main')) {
                $validated['main'] = (bool)$request->input('main');
            } else {
                // Jika 'main' tidak ada dalam request, pastikan tidak diubah
                unset($validated['main']);
            }

            $user->update($validated);

            return response()->json([
                'message' => 'User berhasil diupdate.',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate user: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
