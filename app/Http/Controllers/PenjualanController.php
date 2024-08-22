<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index(){
        $penjualan = Penjualan::with("barang")->latest()->simplePaginate(10);
        $barang = Barang::all();
        return view("penjualan.index", compact("penjualan", "barang"));
    }
    public function delete(Penjualan $penjualan){
        try{
            $result = $penjualan->delete();
            if($result) {
                return response()->json(["message" => "Berhasil hapus data"]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(["message" => "Gagal hapus data"]);
        }
    }
    public function upsert(Request $request){
        $validated = $request->validate([
            'tgl_faktur' => 'required',
            'no_faktur' => 'required',
            'nama_konsumen' => 'required',
            'kode_barang' => 'required',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'harga_total' => 'required|numeric',
        ]);
        $validated["barang_id"] = $request->barang_id;
        $barang = Barang::find($request->barang_id);
        
        $validated["harga_satuan"] = $barang->harga_jual;
        $validated["harga_total"] = $barang->harga_jual * $request->jumlah;

        $result = Penjualan::updateOrCreate([
            "id" => $request->id ?? null,
        ], $validated);
    }
}
