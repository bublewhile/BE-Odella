<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('produks')->latest()->paginate(20);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategoris']);
        Kategori::create($request->only('nama_kategori'));
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id . ',id_kategori']);
        $kategori->update($request->only('nama_kategori'));
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
