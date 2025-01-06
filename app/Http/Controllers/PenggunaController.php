<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    protected $data;
    public function index()
    {
        $this->data['users'] = User::all();
        return view('pengguna.index', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $save = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($save) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Ditambahkan',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Gagal Ditambahkan',
        ]);
    }
}
