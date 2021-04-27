<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use App\Models\Buydetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class C_buy extends Controller
{
    public function cart_show(Request $request)
    {
        try {
            return response()->json([
                'status'    =>  'success',
                'buy_cart'  =>  session('buy_cart'),
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cart_create(Request $req)
    {
        try {
            $cart = session('buy_cart');
            $cart[$req->item_id] = [
                'idbarang'      =>  $req->item_id,
                'namabarang'    =>  $req->namabarang,
                'hargabeli'     =>  $req->hargabeli,
                'jumlahmasuk'   =>  $req->jumlahmasuk
            ];
            session(['buy_cart' => $cart]);
            return response()->json([
                'status'    =>  'success',
                'message'    =>  'Item berhasil ditambahkan',
                'buy_cart'  =>  session('buy_cart'),
            ]);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function cart_delete($item_id)
    {
        try {
            $cart = session('buy_cart');
            unset($cart[$item_id]);
            session(['buy_cart' => $cart]);
            return response()->json([
                'status'    =>  'success',
                'buy_cart'  =>  session('buy_cart'),
                'message'  =>  'Item berhasil dibapus',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cart_cancel(Request $request)
    {
        try {
            $data = $request->session()->forget('buy_cart');
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Transaksi berhasil dibatalkan',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function all_data(Buy $buy)
    {
        try {
            $buys   =   $buy->all();
            return $buys;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $validation = $this->validation_rules($request->all());
            if ($validation->fails()) {
                return response()->json($validation->errors());
            }
            // Generate kode transaksi
            $transaksikode  = Buy::get()->max('kodetransaksi');
            $kodetransaksi  = $this->kotransaksi($transaksikode);
            $buys   =  new Buy;
            $buys->kodetransaksi        =   $kodetransaksi;
            $buys->tanggaltransaksi     =   $request->tanggaltransaksi;
            $buys->totaltransaksi       =   $request->totaltransaksi;
            $buys->supplier_id          =   $request->supplier_id;
            $buys->user_id              =   $request->user_id;
            $exc_trasaksi   =   $buys->save();
            if ($exc_trasaksi) {
                $this->save_detail();
                return response()->json([
                    'status'     => 'success',
                    'message'    => 'Transaksi Berhasil',
                    'buy_data'   => $buys,
                ], 200);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function save_detail()
    {
        $id_buy = $transaksikode  = Buy::get()->max('id');
        if (session()->has('buy_cart')) {
            try {
                foreach (session('buy_cart') as $i) {
                    $buydetails = new Buydetail;
                    $buydetails->buy_id =   $id_buy;
                    $buydetails->barang_id =   $i['idbarang'];
                    $buydetails->jumlahmasuk =   $i['jumlahmasuk'];
                    $buydetails->hargabeli =   $i['hargabeli'];
                    $buydetails->save();
                };
                session()->forget('buy_cart');
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            echo 'Tidak ada data order';
        }
    }

    public function detail($buy_id)
    {
        try {
            $buys   =   Buy::find($buy_id);
            // Mengambil data detail transaksi
            $buydetails = Buydetail::get()
                ->where('buy_id', '=', $buy_id);
            return response()->json([
                'status'          =>  'success',
                'buy_data'        =>  $buys,
                'buydetail_data'  =>  $buydetails,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function validation_rules($request)
    {
        $is_validate    =   Validator::make($request, [
            'tanggaltransaksi'  =>  'required',
            'totaltransaksi'    =>  'required',
            'supplier_id'       =>  'required',
            'user_id'           =>  'required',
        ]);
        return $is_validate;
    }

    private function kotransaksi($character)
    {
        $kode = $character;
        $noUrut = (int) substr($kode, 3, 3);
        $noUrut++;
        $kode = 'PMB' . sprintf("%03s", $noUrut);
        return ($kode);
    }
}
