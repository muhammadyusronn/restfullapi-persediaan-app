<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class C_user extends Controller
{
    //
    public function all_data(User $user)
    {
        try {
            $users = $user->all();
            return response()->json([
                'status'   => 'success',
                'user_data' => $users,
            ], 200);
        } catch (Exception $e) {
            // do task when error
            echo $e->getMessage();   // insert query
        }
    }

    public function register(Request $request)
    {
        $validation = $this->validator($request->all());
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $users = new  User;
            $users->name    = $request['name'];
            $users->email    = $request['email'];
            $users->password    = Hash::make($request['password']);
            $users->save();
            return response()->json([
                'status'   => 'success',
                'message'   => 'Registrasi Berhasil!',
                'user_data' => $users,
            ], 200);
        } catch (\Exception $e) {
            // do task when error
            echo $e->getMessage();   // insert query
        }
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password'  => 'required|min:8',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors());
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Email atau password salah!',
                ], 401);
            }
            $token = $user->createToken('token-qu')->plainTextToken;
            return response()->json([
                'status'    => 'success',
                'message'   =>  'Anda Berhasil Login!',
                'user_data' =>  $user,
                'token'     =>  $token,
            ], 200);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function logout(Request $request)
    {
        $users = $request->user();
        //Menghapus token yang sedang digunakan
        $users->currentAccessToken()->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Anda berhasil logout!',
        ], 200);
    }

    public function validator($data)
    {
        return Validator::make($data, [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password'  => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);
    }
}
