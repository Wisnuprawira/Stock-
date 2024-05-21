<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller

{

    public function loginPage(){
        return view('auth.login');
    }
    public function login(Request $request){
        // return $request;
        // Validasi data yang diterima dari request
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('name', $request['name'])->first();
        // Coba melakukan otentikasi user
        if ($user && $user->password == $request['password']) {
            Auth::login($user);
            return redirect()->route('dashboard.index'); // Redirect ke halaman dashboard
        } else {
            // Otentikasi gagal
            return back()->withInput()->withErrors(['email' => 'Email atau password salah.']); // Redirect kembali dengan pesan kesalahan
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function getUser(){
        $user = User::get();
        $data = [
            "title" => "User",
            "user" => $user
        ];
        // return $data;
        return view('user.index',compact('data'));
    }

    public function createPages(){
        $data = [
            'title' => "User"
        ];
        return view('user.create',compact('data'));
    }

    public function create(Request $request){
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            User::create([
                'name' => $request->username,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'password' => $request->password
            ]);
            
            // Jika berhasil, kembalikan respons yang sesuai
            return redirect()->route('user.create')->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            // Tangani pengecualian umum jika terjadi kesalahan saat membuat data
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }


    public function editPages($id){
        $datas = User::where('id',$id)->first();
        $data = [
            'title' => "User",
            'data' => $datas
        ];
        // return $data;
        return view('user.edit',compact('data'));
    }

    public function edit(Request $request, $id){

        
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            $x = User::where('id',$id)->first();
            $x->update([
                'name' => $request->username,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'password' => $request->password
            ]);
    
            // Jika berhasil, kembalikan respons yang sesuai
            return redirect()->back()->with('success','Berhasil edit data!');
        } catch (\Exception $e) {
            // Tangani pengecualian umum jika terjadi kesalahan saat membuat data
            return redirect()->back()->with('error','Terjadi kesalahan saat edit data: ' . $e->getMessage());
        }
    }

    public function delete($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
