<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\SubKriteriaBobot;
use DB;

class SubKriteriaController extends Controller
{
    public function index(){
        $x = SubKriteria::orderby('kriteria_id','ASC')->get();
        $x->map(function($c){
            $c['kriteria'] = Kriteria::where('id',$c->kriteria_id)->first();
            return $c;
        });
        $data = [
            'title' => "Sub Kriteria",
            'data' => $x
        ];
        // return $data;
        return view('sub_kriteria.index',compact('data'));
    }

    public function createPages(){
        $x = Kriteria::orderby('kode','ASC')->get();
        $data = [
            'title' => "Kriteria",
            'data' => $x
        ];
        return view('sub_kriteria.create',compact('data'));
    }

    public function create(Request $request){
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'kriteria' => 'required',
            'kode' => 'required',
            'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            SubKriteria::where('kriteria_id',$request->kriteria)->update([
                'total_nilai' => 0,
                'jumlah' => NULL,
                'prioritas' => NULL,
                'eigen_value' => NULL,
            ]);

            SubKriteriaBobot::where('kriteria_ids',$request->kriteria)->delete();
            DB::table('hasil_bobot_sub_kriteria')->truncate();
            DB::table('alternatif')->truncate();

            SubKriteria::create([
                'kriteria_id' => $request->kriteria,
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);

           
    
            // Jika berhasil, kembalikan respons yang sesuai
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            // Tangani pengecualian umum jika terjadi kesalahan saat membuat data
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }


    public function editPages($id){
        $kriteria = Kriteria::orderby('kode','ASC')->get();
        $datas = SubKriteria::where('id',$id)->first();
        $data = [
            'title' => "Kriteria",
            'kriteria' => $kriteria,
            'data' => $datas
        ];
        return view('sub_kriteria.edit',compact('data'));
    }

    public function edit(Request $request, $id){

        
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'kriteria' => 'required',
            'kode' => 'required',
            'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            $x = SubKriteria::where('id',$id)->first();
            $x->update([
                'kriteria_id' => $request->kriteria,
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
    
            // Jika berhasil, kembalikan respons yang sesuai
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            // Tangani pengecualian umum jika terjadi kesalahan saat membuat data
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }

    public function delete($id){
        try {
            $data = SubKriteria::findOrFail($id);
            SubKriteria::where('kriteria_id',$data->kriteria_id)->update([
                'total_nilai' => 0,
                'jumlah' => NULL,
                'prioritas' => NULL,
                'eigen_value' => NULL,
            ]);

            SubKriteriaBobot::where('kriteria_ids',$data->kriteria_id)->delete();
            DB::table('hasil_bobot_sub_kriteria')->truncate();
            DB::table('alternatif')->truncate();
            $data->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
