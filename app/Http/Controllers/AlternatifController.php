<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\Validator;

class AlternatifController extends Controller
{
    public function index(){
        $alternatif = Alternatif::orderby('nama','ASC')->get();
        
        $alternatif->map(function($x){
            
            $explode = explode('_',$x->sub_kriteria_ids);
            // Initialize an empty array to hold the related SubKriteria models
            $datas = [];
            
            // Loop through each exploded ID and fetch the corresponding SubKriteria model
            foreach ($explode as $value) {
                $c = SubKriteria::find($value);
                $c['kriteria'] = Kriteria::where('id',$c['kriteria_id'])->first();
                if ($c) {
                    $datas[] = $c;
                }
            }
            
            // Add the exploded array and the related SubKriteria models to the model instance
            $x['explode'] = $explode;
            $x['datas'] = $datas;
            return $x;
        });
        // return $alternatif;
        $kriteria = Kriteria::get();
        $data = [
            'title' => "Alternatif",
            'kriteria' => $kriteria,
            'data' => $alternatif
        ];
        // return $data;
        return view('alternatif.index',compact('data'));
    }

    public function createPages(){
        
        $kriteria = Kriteria::get();
        $kriteria->map(function($x){
            $x['sub'] = SubKriteria::where('kriteria_id',$x->id)->get();
            return $x;
        });

        $data = [
            'title' => "Alternatif",
            'krit' => $kriteria
        ];
        
   
        return view('alternatif.create',compact('data'));
    }

    public function create(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [

        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Buat entri baru di database
            $datas = [];
            $kodes = "";
            foreach($request['krit'] as $key => $value){
          
                $data = [
                    
                    'nama' => $request['nama'],
                    'kriteria_id' => $value,
                    'sub_kriteria_id' => $request['sub_krit'][$key]
                ];
             
                if($kodes != $request['sub_krit'][$key]){
                    if($kodes == ""){
                        $kodes = $request['sub_krit'][$key];
                    }else{
                        $kodes = $kodes.'_'.$request['sub_krit'][$key];
                    }
                    
                }
                array_push($datas, $data);
            }

            // return $kodes;
      
            $data = [
                'tahun' => $request['tahun'],
                'nama' => $request['nama'],
                'sub_kriteria_ids' => $kodes
            ];
             Alternatif::create($data);
            
            
            
            // Jika berhasil, kembalikan respons yang sesuai
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            // Tangani pengecualian umum jika terjadi kesalahan saat membuat data
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }

    public function editPages($id){
        
        $alternatif = Alternatif::where('id',$id)->first();
        if ($alternatif) {
            // Explode the 'sub_kriteria_ids' by '_'
            $explode = explode('_', $alternatif->sub_kriteria_ids);
            
            // Initialize an empty array to hold the related SubKriteria models
            $datas = [];
            
            // Loop through each exploded ID and fetch the corresponding SubKriteria model
            foreach ($explode as $value) {
                $c = SubKriteria::find($value);
                if ($c) {
                    // Fetch the related Kriteria model
                    $kriteria = Kriteria::find($c->kriteria_id);
                    // Add the Kriteria model to the SubKriteria model
                    $c['kriteria'] = $kriteria;
                    // Add the SubKriteria model to the datas array
                    $datas[] = $c;
                }
            }
            
            // Add the exploded array and the related SubKriteria models to the model instance
            $alternatif['explode'] = $explode;
            $alternatif['datas'] = $datas;
        }
        // return $alternatif;
        $kriteria = Kriteria::get();
        $kriteria->map(function($x){
            $x['sub'] = SubKriteria::where('kriteria_id',$x->id)->get();
            return $x;
        });

        $data = [
            'title' => "Alternatif",
            'krit' => $kriteria,
            'data' => $alternatif
        ];
        // return $data;
        
        return view('alternatif.edit',compact('data'));
    }

    public function delete($id){
        try {
            $data = Alternatif::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
