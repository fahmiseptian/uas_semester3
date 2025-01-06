<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use PDF;

class OrdersController extends Controller
{
    protected $data;
    public function index()
    {
        $this->data['orders'] = Orders::all();
        return view('order.index', $this->data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
        ]);

        $save = Orders::create([
            'nama_tamu' => $request->nama_tamu,
            'tipe_kamar' => $request->tipe_kamar,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
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
    public function update(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'tipe_kamar' => 'required|string|in:single,double,king',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'id_pesanan' => 'required|integer',
        ]);

        $update = Orders::where('id_pesanan', $request->id_pesanan)->update([
            'nama_tamu' => $request->nama_tamu,
            'tipe_kamar' => $request->tipe_kamar,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diperbaharui',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pesanan gagal diperbaharui',
        ]);
    }

    public function order($id)
    {
        $this->data['order'] = Orders::find($id);
        return response()->json([
            'success' => true,
            'data' => $this->data['order'],
        ]);
    }
    public function delete($id)
    {
        $order = Orders::find($id);
        if ($order) {
            $order->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Tidak Ditemukan',
        ]);
    }

    public function exportPdf()
    {
        $order = Orders::all();

        if ($order->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data untuk diekspor.']);
        }

        $pdf = Pdf::loadView('order.export-pdf', ['orders' => $order]);

        // Simpan PDF ke file
        $filePath = storage_path('app/public/data-order.pdf');
        $pdf->save($filePath);

        // Kembalikan URL untuk mengunduh PDF
        return response()->json(['success' => true, 'url' => asset('storage/data-order.pdf')]);
    }
}
