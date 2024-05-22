<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\KriteriaBobot;

use App\Models\SubKriteria;
use App\Models\SubKriteriaBobot;
use Illuminate\Support\Facades\Validator;

class CalculateController extends Controller
{
    public function index(){
        
        $krit = Kriteria::orderby('kode',"ASC")->get();
        $bobot = KriteriaBobot::get();
        $bobot->map(function($x){
            $x['rel_1'] = Kriteria::where('kode',$x['kriteria_id'])->first();
            $x['rel_2'] = Kriteria::where('kode',$x['kriteria_id2'])->first();
            $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
            return $x;
        });
        $totals = [];
        if($bobot){
            foreach ($krit as $kriteria) {
                $total = 0; // Inisialisasi total untuk setiap kode
        
                // Menghitung total bobot terkait
                foreach ($bobot as $items) {
                    if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
                        $total += $items['nilai']; // Tambahkan nilai bobot
                    }
                    if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
                        $total += 1 / $items['nilai']; // Tambahkan nilai kebalikan
                    }
                }
        
                // Tambahkan nilai 1 pada diagonal utama
                foreach ($krit as $kriteriaDiagonal) {
                    if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
                        $total += 1; // Tambahkan nilai 1 pada diagonal utama
                    }
                }
                $cc = [
                    'kode' => $kriteria['kode'],
                    'nilai' => $total
                ];
                array_push($totals, $cc);
            }
        }

        $data = [
            'title' => "Perhitungan",
            'kriteria' => $krit,
            'bobot' => $bobot
        ];
    //    return $bobot;



            



        return view('hitung.index',compact('data'));
    }

    public function hitung(Request $request){
    
        $validator = Validator::make($request->all(), [
            // 'kode' => 'required',
            // 'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // return $request;
            KriteriaBobot::truncate();
            $data = [];

            foreach($request['kriteria'] as $key => $value){
                    $x = explode('_', $value);
                    $k = [
                        "kriteria_1" => $x[0],
                        "kriteria_2" => $x[1],
                        "nilai" => $x[2]
                    ];
                    array_push($data,$k);
            }

          
            foreach($data as $value){
                KriteriaBobot::create([
                    'kriteria_id' => $value['kriteria_1'],
                    'kriteria_id2' => $value['kriteria_2'],
                    'nilai' => $value['nilai'],
                ]);
            }

            $krit = Kriteria::orderby('kode',"ASC")->get();
            $bobot = KriteriaBobot::get();
            $bobot->map(function($x){
                $x['rel_1'] = Kriteria::where('kode',$x['kriteria_id'])->first();
                $x['rel_2'] = Kriteria::where('kode',$x['kriteria_id2'])->first();
                $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
                return $x;
            });
            $totals = [];
            if($bobot){
                foreach ($krit as $kriteria) {
                    $total = 0; // Inisialisasi total untuk setiap kode
            
                    // Menghitung total bobot terkait
                    foreach ($bobot as $items) {
                        if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
                            $total += $items['nilai']; // Tambahkan nilai bobot
                        }
                        if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
                            $total += 1 / $items['nilai']; // Tambahkan nilai kebalikan
                        }
                    }
            
                    // Tambahkan nilai 1 pada diagonal utama
                    foreach ($krit as $kriteriaDiagonal) {
                        if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
                            $total += 1; // Tambahkan nilai 1 pada diagonal utama
                        }
                    }
            
                    $cc = [
                        'kode' => $kriteria['kode'],
                        'nilai' => $total
                    ];
                    array_push($totals, $cc);
                }
            }

            foreach($totals as $tot){
                Kriteria::where('kode',$tot['kode'])->update([
                    'total_nilai' => $tot['nilai']
                ]);
            }



    
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }

    public function reset(){
        try {
            KriteriaBobot::truncate();
            return redirect()->back()->with('success','Berhasil reset data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat reset data: ' . $e->getMessage());
        }
    }

    public function indexSub($id){
        $krit = SubKriteria::where('kriteria_id',$id)->orderby('kode',"ASC")->get();

        $bobot = SubKriteriaBobot::where('kriteria_ids',$id)->get();
        $bobot->map(function($x){
            $x['rel_1'] = SubKriteria::where(['id' => $x->kriteria_ids, 'kode' => $x['kriteria_id']])->first();
            $x['rel_2'] = SubKriteria::where(['id' => $x->kriteria_ids, 'kode' => $x['kriteria_id2']])->first();
            $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
            return $x;
        });
        // return $bobot;
        $totals = [];
        if($bobot->count() > 0){
            foreach ($krit as $kriteria) {
                $total = 0; // Inisialisasi total untuk setiap kode
        
                // Menghitung total bobot terkait
                foreach ($bobot as $items) {
                    if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
                        $total += $items['nilai']; // Tambahkan nilai bobot
                    }
                    if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
                        $total += 1 / $items['nilai']; // Tambahkan nilai kebalikan
                    }
                }
        
                // Tambahkan nilai 1 pada diagonal utama
                foreach ($krit as $kriteriaDiagonal) {
                    if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
                        $total += 1; // Tambahkan nilai 1 pada diagonal utama
                    }
                }
                $cc = [
                    'kode' => $kriteria['kode'],
                    'nilai' => $total
                ];
                array_push($totals, $cc);
            }
        }

        $data = [
            'title' => "Perhitungan",
            'kriteria' => $krit,
            'bobot' => $bobot
        ];
       
        $totals = [];
        $total_row = [];
        if($bobot->count() > 0){
            foreach ($krit as $kriteria) {
                $total = 0; // Inisialisasi total untuk setiap kode
                $total_r = 0;
                // Menghitung total bobot terkait
                foreach ($bobot as $items) {
                    if($kriteria['kode'] != $items){

                    }
                    if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
                        $total += $items['nilai'] / $kriteria['total_nilai']; // Tambahkan nilai bobot
                        
                    }
                   
                    if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
                        $total += 1 / $items['nilai'] / $kriteria['total_nilai']; // Tambahkan nilai kebalikan
                       
                    }
                    
                }
        
                // Tambahkan nilai 1 pada diagonal utama
                foreach ($krit as $kriteriaDiagonal) {
                    if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
                        $total += 1 / $kriteria['total_nilai']; // Tambahkan nilai 1 pada diagonal utama
                        
                    }
                }
        
                $cc = [
                    'kode' => $kriteria['kode'],
                    'nilai' => $total
                ];
                array_push($totals, $cc);

                $cc_r = [
                    'kode' => $kriteria['kode'],
                    'nilai' => $total_r
                ];
                array_push($total_row, $cc_r);
            }
        }
        // return $total_row;
        
        return view('hitung.index',compact('data'));
    }

    public function hitungSub(Request $request){
    
        
        $validator = Validator::make($request->all(), [
            // 'kode' => 'required',
            // 'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // return $request;
            SubKriteriaBobot::where('kriteria_ids',$request->ids)->delete();
            $data = [];

            foreach($request['kriteria'] as $key => $value){
                    $x = explode('_', $value);
                    $k = [
                        "kriteria_1" => $x[0],
                        "kriteria_2" => $x[1],
                        "nilai" => $x[2]
                    ];
                    array_push($data,$k);
            }

           
            foreach($data as $value){
                SubKriteriaBobot::create([
                    'kriteria_ids' => $request->ids,
                    'kriteria_id' => $value['kriteria_1'],
                    'kriteria_id2' => $value['kriteria_2'],
                    'nilai' => $value['nilai'],
                ]);
            }

            $krit = SubKriteria::orderby('kode',"ASC")->get();
            $bobot = SubKriteriaBobot::where('kriteria_ids',$request->ids)->get();
            $bobot->map(function($x){
                $x['rel_1'] = Kriteria::where('kode',$x['kriteria_id'])->first();
                $x['rel_2'] = Kriteria::where('kode',$x['kriteria_id2'])->first();
                $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
                return $x;
            });
            $totals = [];
            if($bobot){
                foreach ($krit as $kriteria) {
                    $total = 0; // Inisialisasi total untuk setiap kode
            
                    // Menghitung total bobot terkait
                    foreach ($bobot as $items) {
                        if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
                            $total += $items['nilai']; // Tambahkan nilai bobot
                        }
                        if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
                            $total += 1 / $items['nilai']; // Tambahkan nilai kebalikan
                        }
                    }
            
                    // Tambahkan nilai 1 pada diagonal utama
                    foreach ($krit as $kriteriaDiagonal) {
                        if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
                            $total += 1; // Tambahkan nilai 1 pada diagonal utama
                        }
                    }
            
                    $cc = [
                        'kode' => $kriteria['kode'],
                        'nilai' => $total
                    ];
                    array_push($totals, $cc);
                }
            }

            foreach($totals as $tot){
                SubKriteria::where('kode',$tot['kode'])->update([
                    'total_nilai' => $tot['nilai']
                ]);
            }



    
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }

    public function resetSub($id){
        try {
            SubKriteriaBobot::where('kriteria_ids',$id);
            return redirect()->route('sub-hitung.index',$id)->with('success','Berhasil reset data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat reset data: ' . $e->getMessage());
        }
    }
}
