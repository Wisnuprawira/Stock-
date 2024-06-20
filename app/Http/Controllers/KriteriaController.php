<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\SubKriteriaBobot;
use App\Models\KriteriaBobot;
use DB;
class KriteriaController extends Controller
{
    public function index(){
        $kriteria = Kriteria::orderby('nama','ASC')->get();
        $data = [
            'title' => "Kriteria",
            'data' => $kriteria
        ];
        return view('kriteria.index',compact('data'));
    }

    public function createPages(){
        $data = [
            'title' => "Kriteria"
        ];
        return view('kriteria.create',compact('data'));
    }

    public function create(Request $request){
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            KriteriaBobot::truncate();
            DB::table('hasil_bobot_kriteria')->truncate();
            DB::table('alternatif')->truncate();
            $kriteria = Kriteria::get();
            foreach ($kriteria as $item) {
                $item->update([
                    'total_nilai' => 0,
                    'jumlah' => NULL,
                    'prioritas' => NULL,
                    'eigen_value' => NULL,
                ]);
            }

            Kriteria::create([
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
        $datas = Kriteria::where('id',$id)->first();
        $data = [
            'title' => "Kriteria",
            'data' => $datas
        ];
        return view('kriteria.edit',compact('data'));
    }

    public function edit(Request $request, $id){

        
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            $x = Kriteria::where('id',$id)->first();
            $x->update([
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
            $kriteria = Kriteria::findOrFail($id);
            KriteriaBobot::truncate();
            SubKriteria::where('kriteria_id',$id)->delete();
            SubKriteriaBobot::where('kriteria_ids',$id)->delete();
            DB::table('hasil_bobot_kriteria')->truncate();
            DB::table('hasil_bobot_sub_kriteria')->where('sub_kriteria_id',$id)->delete();
            $kriteria->delete();
            DB::table('alternatif')->truncate();
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
