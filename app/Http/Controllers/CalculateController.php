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
        $data = [
            'title' => "Perhitungan",
            'kriteria' => $krit,
            'bobot' => $bobot
        ];

        return view('hitung.index',compact('data'));
    }

    public function hitung(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            // 'kode' => 'required',
            // 'nama' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {

            $oke = [];
            foreach($request['kriteria'] as $key => $value){
               

                    $cc = [
                        'rel_1' => $request['rel_1'][$key],
                        'rel_2' => $request['rel_2'][$key],
                        'nilai' => $value
                    ];
                

                array_push($oke, $cc);
            }
            // return $oke;
            foreach ($oke as $item) {
            
                // Cek jika pasangan rel_2 dan rel_1 belum ada
                $isReverseExist = false;
                foreach ($oke as $existing) {
                    if ($existing['rel_1'] === $item['rel_2'] && $existing['rel_2'] === $item['rel_1']) {
                        $isReverseExist = true;
                        break;
                    }
                }
            
                // Jika pasangan rel_2 dan rel_1 belum ada, tambahkan ke array baru
                if (!$isReverseExist) {
                    $reversePair = [
                        'rel_1' => $item['rel_2'],
                        'rel_2' => $item['rel_1'],
                        'nilai' => 1 / $item['nilai']
                    ];
                    array_push($oke, $reversePair);
                }
            }
            usort($oke, function($a, $b) {
                return strcmp($a['rel_1'], $b['rel_1']);
            });
            
            // return $oke;
            
        
            KriteriaBobot::truncate();

          
            foreach($oke as $value){
                KriteriaBobot::create([
                    'kriteria_id' => $value['rel_1'],
                    'kriteria_id2' => $value['rel_2'],
                    'nilai' => $value['nilai'],
                ]);
            }

            // $krit = Kriteria::orderby('kode',"ASC")->get();
            // $bobot = KriteriaBobot::get();
            // $bobot->map(function($x){
            //     $x['rel_1'] = Kriteria::where('kode',$x['kriteria_id'])->first();
            //     $x['rel_2'] = Kriteria::where('kode',$x['kriteria_id2'])->first();
            //     $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
            //     return $x;
            // });
            // $totals = [];
            // if($bobot){
            //     foreach ($krit as $kriteria) {
            //         $total = 0; // Inisialisasi total untuk setiap kode
            
            //         // Menghitung total bobot terkait
            //         foreach ($bobot as $items) {
            //             if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode']) {
            //                 $total += $items['nilai']; // Tambahkan nilai bobot
            //             }
            //             if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode']) {
            //                 $total += 1 / $items['nilai']; // Tambahkan nilai kebalikan
            //             }
            //         }
            
            //         // Tambahkan nilai 1 pada diagonal utama
            //         foreach ($krit as $kriteriaDiagonal) {
            //             if ($kriteria['kode'] == $kriteriaDiagonal['kode']) {
            //                 $total += 1; // Tambahkan nilai 1 pada diagonal utama
            //             }
            //         }
            
            //         $cc = [
            //             'kode' => $kriteria['kode'],
            //             'nilai' => $total
            //         ];
            //         array_push($totals, $cc);
            //     }
            // }

            // foreach($totals as $tot){
            //     Kriteria::where('kode',$tot['kode'])->update([
            //         'total_nilai' => $tot['nilai']
            //     ]);
            // }



    
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
            $x['rel_1'] = SubKriteria::where([ 'kode' => $x['kriteria_id']])->first();
            
            $x['rel_2'] = SubKriteria::where([ 'kode' => $x['kriteria_id2']])->first();
            $x->kodes = $x['kriteria_id'].'_'.$x['kriteria_id2'].'_'.$x['nilai'];
            return $x;
        });
       

        $data = [
            'title' => "Perhitungan",
            'kriteria' => $krit,
            'bobot' => $bobot
        ];

        // return $data;
        
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
            $oke = [];
            foreach($request['kriteria'] as $key => $value){
               

                    $cc = [
                        'rel_1' => $request['rel_1'][$key],
                        'rel_2' => $request['rel_2'][$key],
                        'nilai' => $value
                    ];
                

                array_push($oke, $cc);
            }
            // return $oke;
            foreach ($oke as $item) {
            
                // Cek jika pasangan rel_2 dan rel_1 belum ada
                $isReverseExist = false;
                foreach ($oke as $existing) {
                    if ($existing['rel_1'] === $item['rel_2'] && $existing['rel_2'] === $item['rel_1']) {
                        $isReverseExist = true;
                        break;
                    }
                }
            
                // Jika pasangan rel_2 dan rel_1 belum ada, tambahkan ke array baru
                if (!$isReverseExist) {
                    $reversePair = [
                        'rel_1' => $item['rel_2'],
                        'rel_2' => $item['rel_1'],
                        'nilai' => 1 / $item['nilai']
                    ];
                    array_push($oke, $reversePair);
                }
            }
            usort($oke, function($a, $b) {
                return strcmp($a['rel_1'], $b['rel_1']);
            });
            
            // return $oke;
            
        
            
            SubKriteriaBobot::where('kriteria_ids',$request->ids)->delete();
          
            foreach($oke as $value){
                SubKriteriaBobot::create([
                    'kriteria_ids' => $request->ids,
                    'kriteria_id' => $value['rel_1'],
                    'kriteria_id2' => $value['rel_2'],
                    'nilai' => $value['nilai'],
                ]);
            }
           
           



    
            return redirect()->back()->with('success','Berhasil tambah data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat membuat data: ' . $e->getMessage());
        }
    }

    public function resetSub($id){
        try {
            SubKriteriaBobot::where('kriteria_ids',$id)->delete();
            return redirect()->route('sub-hitung.index',$id)->with('success','Berhasil reset data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error','Terjadi kesalahan saat reset data: ' . $e->getMessage());
        }
    }
}
