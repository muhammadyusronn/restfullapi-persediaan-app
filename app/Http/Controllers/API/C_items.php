<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class C_items extends Controller
{
    //
    public function all_data(Items $items)
    {
        try {
            $item = DB::table('items')
                ->join('categories', 'items.categories_id', '=', 'categories.id')
                ->select('items.*', 'categories.namakategori')
                ->get();
            return response()->json([
                'status'        =>  'success',
                'items_data'    => $item,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function create(Request $request)
    {
        $validation =
            Validator::make($request->all(), [
                'kodebarang'    =>  'required|string',
                'namabarang'    =>  'required|string',
                'hargabeli'     =>  'required',
                'hargajual'     =>  'required',
                'stock'         =>  'required',
                'categories_id' =>  'required',
            ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $item = new Items;
            $item->kodebarang       =   $request->kodebarang;
            $item->namabarang       =   $request->namabarang;
            $item->hargabeli        =   $request->hargabeli;
            $item->hargajual        =   $request->hargajual;
            $item->stock            =   $request->stock;
            $item->categories_id    =   $request->categories_id;
            $item->save();
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Data barang berhasil ditambahkan',
                'items_data' =>  $item,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function detail($items_id)
    {
        try {
            $item = DB::table('items')
                ->join('categories', 'items.categories_id', '=', 'categories.id')
                ->select('items.*', 'categories.namakategori')
                ->where('items.id', '=', $items_id)
                ->get();
            return response()->json([
                'status'        =>  'success',
                'items_data'    =>  $item,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        $validation =
            Validator::make($request->all(), [
                'kodebarang'    =>  'required|string',
                'namabarang'    =>  'required|string',
                'hargabeli'     =>  'required',
                'hargajual'     =>  'required',
                'stock'         =>  'required',
                'categories_id' =>  'required',
            ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $item   =   Items::find($request->id);
            $item->update([
                'kodebarang'       =>   $request->kodebarang,
                'namabarang'       =>   $request->namabarang,
                'hargabeli'        =>   $request->hargabeli,
                'hargajual'        =>   $request->hargajual,
                'stock'            =>   $request->stock,
                'categories_id'    =>   $request->categories_id,
            ]);
            return response()->json([
                'status'     =>  'success',
                'message'    =>  'Data barang berhasil diubah',
                'items_data' =>  $item,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($items_id)
    {
        try {
            $item = Items::find($items_id)->delete();
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Data berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
