<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Exception;
use Illuminate\Support\Facades\Validator;

class C_categories extends Controller
{
    //
    public function all_data(Categories $categories)
    {
        try {
            // Save Data
            $category = $categories->all();
            return response()->json([
                'status'            => 'success',
                'categories_data'   => $category,
            ], 200);
        } catch (Exception $e) {
            // Errror Message
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        // Validation Request
        $validation = Validator::make($request->all(), [
            'kodekategori'  => 'required|string',
            'namakategori'  => 'required|string',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            // Save Data
            $category = new Categories;
            $category->kodekategori    =   $request->kodekategori;
            $category->namakategori    =   $request->namakategori;
            $category->save();
            return response()->json([
                'status'        =>  'success',
                'message'        =>  'Berhasil menambah data category',
                'category_data' =>  $category,
            ], 200);
        } catch (Exception $e) {
            // Error Message
            return $e->getMessage();
        }
    }

    public function detail($categories_id)
    {
        try {
            $categoriy = Categories::find($categories_id);
            return response()->json([
                'status'    =>  'success',
                'categories_data'   =>  $categoriy,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        // Validation Request
        $validation = Validator::make($request->all(), [
            'kodekategori'  => 'required|string',
            'namakategori'  => 'required|string',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }

        try {
            // Save Data
            $category = Categories::find($request->id);
            $category->update([
                'kodekategori'    =>   $request->kodekategori,
                'namakategori'    =>   $request->namakategori,
            ]);
            return response()->json([
                'status'        =>  'success',
                'message'        =>  'Berhasil mengubah data kategori',
                'category_data' =>  $category,
            ], 200);
        } catch (Exception $e) {
            // Error Message
            return $e->getMessage();
        }
    }

    public function delete($category_id)
    {
        try {
            $category   =   Categories::find($category_id)->delete();
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Berhasil menghapus data',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
