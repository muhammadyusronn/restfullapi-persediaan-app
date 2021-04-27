<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\Selldetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_sell extends Controller
{

    public function cart_show()
    {
        try {
            return response()->json([
                'status'    =>  'success',
                'sell_cart'  =>  session('sell_cart'),
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cart_create(Request $request)
    {
        try {
            $cart =  session('sell_cart');
            $cart[$request->item_id]    =   [
                'idbarang'  =>  $request->item_id,
                'namabarang' =>  $request->namabarang,
                'hargajual' =>  $request->hargajual,
                'jumlahkeluar' =>  $request->jumlahkeluar,
            ];
            session(['sell_cart'    =>  $cart]);
            return response()->json([
                'status'    =>  'success',
                'message'   => 'Item berhasil fitambah',
                'sell_cart' =>  session('sell_cart'),
            ]);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function cart_delete($item_id)
    {
        try {
            $cart = session('sell_cart');
            unset($cart[$item_id]);
            session(['sell_cart' => $cart]);
            return response()->json([
                'status'    =>  'success',
                'sell_cart'  =>  session('sell_cart'),
                'message'  =>  'Item berhasil dibapus',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cart_cancel(Request $request)
    {
        try {
            $data = $request->session()->forget('sell_cart');
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Transaksi berhasil dibatalkan',
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function all_data()
    {
        try {
            $sell   =   Sell::get();
            return response()->json([
                'status'    =>  'success',
                'sell_data' =>  $sell,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $validation =   $this->validation_rules($request->all());
            if ($validation->fails()) {
                return response()->json($validation->errors());
            }
            // Generate kode transaksi
            $transaksikode  = Sell::get()->max('kodetransaksi');
            $kodetransaksi  = $this->kotransaksi($transaksikode);
            $sell   =  new Sell;
            $sell->kodetransaksi        =   $kodetransaksi;
            $sell->tanggaltransaksi     =   $request->tanggaltransaksi;
            $sell->totaltransaksi       =   $request->totaltransaksi;
            $sell->potongan             =   $request->potongan;
            $sell->konsumen             =   $request->konsumen;
            $sell->kontak               =   $request->kontak;
            $sell->user_id              =   $request->user_id;
            $exc_trasaksi   =   $sell->save();
            if ($exc_trasaksi) {
                $id_sell = $transaksikode  = Sell::get()->max('id');
                $this->save_detail($id_sell);
                return response()->json([
                    'status'     => 'success',
                    'message'    => 'Transaksi Berhasil',
                    'buy_data'   => $sell,
                ], 200);
            }
        } catch (Exception $e) {
        }
    }

    public function detail($sell_id)
    {
        try {
            $sell   =   Sell::find($sell_id);
            // Mengambil data detail transaksi
            $selldetail = Selldetail::get()
                ->where('sell_id', '=', $sell_id);
            return response()->json([
                'status'          =>  'success',
                'sell_data'        =>  $sell,
                'selldetail_data'  =>  $selldetail,
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_detail($sell_id)
    {
        if (session()->has('sell_cart')) {
            try {
                // dd(session('sell_cart'));
                foreach (session('sell_cart') as $i) {
                    $sell = new Selldetail;
                    $sell->sell_id =   $sell_id;
                    $sell->barang_id =   $i['idbarang'];
                    $sell->jumlahkeluar =   $i['jumlahkeluar'];
                    $sell->save();
                };
                session()->forget('sell_cart');
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return 'Tidak ada data order';
        }
    }

    private function validation_rules($data)
    {
        $is_validate    =   Validator::make($data, [
            'tanggaltransaksi'  =>  'required',
            'totaltransaksi'    =>  'required',
            'potongan'          =>  'required',
            'konsumen'          =>  'required',
            'kontak'          =>  'required',
            'user_id'           =>  'required',
        ]);
        return $is_validate;
    }
    private function kotransaksi($character)
    {
        $kode = $character;
        $noUrut = (int) substr($kode, 3, 3);
        $noUrut++;
        $kode = 'PNJ' . sprintf("%03s", $noUrut);
        return ($kode);
    }
}
