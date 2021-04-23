<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Json;

class C_supplier extends Controller
{
    //
    public function all_data(Supplier $supplier)
    {
        try {
            $suppliers = $supplier->all();
            return response()->json([
                'status'        =>  'success',
                'supplier_data' =>  $suppliers,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        $validation =
            Validator::make($request->all(), [
                'namasupplier'      =>  'required',
                'kontaksupplier'    =>  'required',
                'alamat'            =>  'required',
            ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $suppliers  =   new Supplier;
            $suppliers->namasupplier    =   $request->namasupplier;
            $suppliers->kontaksupplier  =   $request->kontaksupplier;
            $suppliers->alamat          =   $request->alamat;
            // Menyimpan data
            $suppliers->save();
            return response()->json([
                'status'        =>  'success',
                'message'       =>  'Berhasil menambahkan data supplier',
                'supplier_data' =>  $suppliers,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function detail($supplier_id)
    {
        try {
            $suppliers  =   Supplier::find($supplier_id);
            return response()->json([
                'status'        =>  'success',
                'supplier_data' =>  $suppliers,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        $validation =
            Validator::make($request->all(), [
                'id'                =>  'required',
                'namasupplier'      =>  'required',
                'kontaksupplier'    =>  'required',
                'alamat'            =>  'required',
            ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $suppliers  =   Supplier::find($request->id);
            $suppliers->update([
                'namasupplier'    =>   $request->namasupplier,
                'kontaksupplier'  =>   $request->kontaksupplier,
                'alamat'          =>   $request->alamat,

            ]);
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Berhasil merubah data supplier',
                'supplier_data' =>  $suppliers,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($supplier_id)
    {
        try {
            $suppliers  =   Supplier::find($supplier_id)->delete();
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Data supplier berhasil dihapus',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
