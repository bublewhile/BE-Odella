<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('produk')->latest()->paginate(20);
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        $produks = Produk::where('is_active', true)->get();
        return view('admin.promo.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_produk'     => 'nullable|exists:produks,id_produk',
            'kode_promo'    => 'required|string|unique:promos',
            'tgl_berlaku'   => 'required|date',
            'tgl_berakhir'  => 'required|date|after:tgl_berlaku',
            'persen_diskon' => 'required|numeric|min:1|max:100',
            'is_active'     => 'boolean',
        ]);

        Promo::create($data);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dibuat');
    }

    public function edit($id)
    {
        $promo   = Promo::findOrFail($id);
        $produks = Produk::where('is_active', true)->get();
        return view('admin.promo.edit', compact('promo', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $data = $request->validate([
            'id_produk'     => 'nullable|exists:produks,id_produk',
            'kode_promo'    => 'required|string|unique:promos,kode_promo,' . $id . ',id_promo',
            'tgl_berlaku'   => 'required|date',
            'tgl_berakhir'  => 'required|date|after:tgl_berlaku',
            'persen_diskon' => 'required|numeric|min:1|max:100',
            'is_active'     => 'boolean',
        ]);

        $promo->update($data);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui');
    }

    public function destroy($id)
    {
        Promo::findOrFail($id)->delete();
        return redirect()->route('admin.promo.index')->with('success', 'Promo dihapus');
    }
}
