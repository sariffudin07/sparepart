<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function index(){
        $barang = Barang::latest()->simplePaginate(10);
        return view("barang.index", compact("barang"));
    }
    public function delete(Barang $barang){
        try{
            $result = $barang->delete();
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
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'satuan' => 'required',
            'kategori' => 'required',
        ]);
        $result = Barang::updateOrCreate([
            "id" => $request->id ?? null,
        ], $validated);
    }
}
