<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\KriteriaBobot;

use App\Models\SubKriteria;
use App\Models\SubKriteriaBobot;
use Illuminate\Support\Facades\Validator;
use DB;

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

            $data_ri = [
                '1' => 0.0,
                '2' => 0.0,
                '3' => 0.58,
                '4' => 0.9,
                '5' => 1.12,
                '6' => 1.24,
                '7' => 1.32,
                '8' => 1.41,
                '9' => 1.45,
                '10' => 1.49,
            ];

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

            $data_ri = [
                '1' => 0.0,
                '2' => 0.0,
                '3' => 0.58,
                '4' => 0.9,
                '5' => 1.12,
                '6' => 1.24,
                '7' => 1.32,
                '8' => 1.41,
                '9' => 1.45,
                '10' => 1.49,
            ];
    
            $count = count($data['kriteria']);
            $nilai_ri = $data_ri[$count];
    
            $totalJumlah = 0;
            $totalPrioritas = 0;
            $totalEigen = 0;
    
            $totalNilai = [];
            $array_totalNilai = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilai[$kriteria1['kode']] = 0;
                foreach ($data['kriteria'] as $kriteria2) {
                    foreach ($data['bobot'] as $b) {
                        if (
                            $kriteria2['kode'] . $kriteria1['kode'] ==
                                $b['kriteria_id'] . $b['kriteria_id2'] ||
                            $kriteria1['kode'] . $kriteria2['kode'] ==
                                $b['kriteria_id2'] . $b['kriteria_id']
                        ) {
                            $totalNilai[$kriteria1['kode']] += $b['nilai'];
                            
                        }
                    }
                }
                
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilai[$kriteria1['kode']]
                ];
                array_push($array_totalNilai,$kk);
                Kriteria::where('kode',$kriteria1['kode'])->update([
                    'total_nilai' => $totalNilai[$kriteria1['kode']]
                ]);
            }


            $totalNilais = [];
            $array_totalNilais = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilais[$kriteria1['kode']] = 0;
                foreach ($data['kriteria'] as $kriteria2) {
                    foreach ($data['bobot'] as $b) {
                        if (
                            $kriteria2['kode'] . $kriteria1['kode'] ==
                                $b['kriteria_id'] . $b['kriteria_id2'] ||
                            $kriteria1['kode'] . $kriteria2['kode'] ==
                                $b['kriteria_id2'] . $b['kriteria_id']
                        ) {
                            $o = $b['nilai'] / $totalNilai[$kriteria1['kode']];
                            $totalNilais[$kriteria1['kode']] += $o;
                        }
                    }
                }
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilais[$kriteria1['kode']]
                ];
                array_push($array_totalNilais,$kk);
                
            }

            $totalNilaiJumlah = [];
            $array_totalNilaiJumlah = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilaiJumlah[$kriteria1['kode']] = 0;
                foreach ($data['bobot'] as $b) {
                    if ($kriteria1['kode'] == $b['kriteria_id']) {
                        $o = $b['nilai'] / $totalNilai[$b['kriteria_id2']];
                        $totalNilaiJumlah[$kriteria1['kode']] += $o;
                    }
                }
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilaiJumlah[$kriteria1['kode']]
                ];
                array_push($array_totalNilaiJumlah,$kk);
                Kriteria::where('kode',$kriteria1['kode'])->update([
                    'jumlah' =>  $totalNilaiJumlah[$kriteria1['kode']],
                    'prioritas' => $totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']),
                    'eigen_value' => ($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) * $totalNilai[$kriteria1['kode']]
                ]);
            }

            foreach ($data['kriteria'] as $kriteria1){
                $totalJumlah += $totalNilaiJumlah[$kriteria1['kode']];
                $totalPrioritas += $totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']);
                $totalEigen += ($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) *
                $totalNilai[$kriteria1['kode']];
            }
            DB::table('hasil_bobot_kriteria')->truncate();
            DB::table('hasil_bobot_kriteria')->insert([
                'ci' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1),
                'ri' => $nilai_ri,
                'cr' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1) / $nilai_ri, 
            ]);
    
            // return [
            //     'ci' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1),
            //     'ri' => $nilai_ri,
            //     'cr' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1) / $nilai_ri,
            // ];

    
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
        
 
        return view('hitung.index',compact('data'));
    }

    public function hitungSub(Request $request){
    
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
            
        
            
            SubKriteriaBobot::where('kriteria_ids',$request->ids)->delete();
          
            foreach($oke as $value){
                SubKriteriaBobot::create([
                    'kriteria_ids' => $request->ids,
                    'kriteria_id' => $value['rel_1'],
                    'kriteria_id2' => $value['rel_2'],
                    'nilai' => $value['nilai'],
                ]);
            }

            $krit = SubKriteria::where('kriteria_id',$request->ids)->orderby('kode',"ASC")->get();

            $bobot = SubKriteriaBobot::where('kriteria_ids',$request->ids)->get();
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
            
            $data_ri = [
                '1' => 0.0,
                '2' => 0.0,
                '3' => 0.58,
                '4' => 0.9,
                '5' => 1.12,
                '6' => 1.24,
                '7' => 1.32,
                '8' => 1.41,
                '9' => 1.45,
                '10' => 1.49,
            ];
    
            $count = count($data['kriteria']);
            $nilai_ri = $data_ri[$count];
    
            $totalJumlah = 0;
            $totalPrioritas = 0;
            $totalEigen = 0;
    
            $totalNilai = [];
            $array_totalNilai = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilai[$kriteria1['kode']] = 0;
                foreach ($data['kriteria'] as $kriteria2) {
                    foreach ($data['bobot'] as $b) {
                        if (
                            $kriteria2['kode'] . $kriteria1['kode'] ==
                                $b['kriteria_id'] . $b['kriteria_id2'] ||
                            $kriteria1['kode'] . $kriteria2['kode'] ==
                                $b['kriteria_id2'] . $b['kriteria_id']
                        ) {
                            $totalNilai[$kriteria1['kode']] += $b['nilai'];
                            
                        }
                    }
                }
                
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilai[$kriteria1['kode']]
                ];
                array_push($array_totalNilai,$kk);
                SubKriteria::where('kode',$kriteria1['kode'])->update([
                    'total_nilai' => $totalNilai[$kriteria1['kode']]
                ]);
            }


            $totalNilais = [];
            $array_totalNilais = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilais[$kriteria1['kode']] = 0;
                foreach ($data['kriteria'] as $kriteria2) {
                    foreach ($data['bobot'] as $b) {
                        if (
                            $kriteria2['kode'] . $kriteria1['kode'] ==
                                $b['kriteria_id'] . $b['kriteria_id2'] ||
                            $kriteria1['kode'] . $kriteria2['kode'] ==
                                $b['kriteria_id2'] . $b['kriteria_id']
                        ) {
                            $o = $b['nilai'] / $totalNilai[$kriteria1['kode']];
                            $totalNilais[$kriteria1['kode']] += $o;
                        }
                    }
                }
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilais[$kriteria1['kode']]
                ];
                array_push($array_totalNilais,$kk);
                
            }

            $totalNilaiJumlah = [];
            $array_totalNilaiJumlah = [];
            foreach ($data['kriteria'] as $kriteria1) {
                $totalNilaiJumlah[$kriteria1['kode']] = 0;
                foreach ($data['bobot'] as $b) {
                    if ($kriteria1['kode'] == $b['kriteria_id']) {
                        $o = $b['nilai'] / $totalNilai[$b['kriteria_id2']];
                        $totalNilaiJumlah[$kriteria1['kode']] += $o;
                    }
                }
                $kk = [
                    'kode' => $kriteria1['kode'],
                    'nilai' => $totalNilaiJumlah[$kriteria1['kode']]
                ];
                array_push($array_totalNilaiJumlah,$kk);
                SubKriteria::where('kode',$kriteria1['kode'])->update([
                    'jumlah' =>  $totalNilaiJumlah[$kriteria1['kode']],
                    'prioritas' => $totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']),
                    'eigen_value' => ($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) * $totalNilai[$kriteria1['kode']]
                ]);
            }

            foreach ($data['kriteria'] as $kriteria1){
                $totalJumlah += $totalNilaiJumlah[$kriteria1['kode']];
                $totalPrioritas += $totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']);
                $totalEigen += ($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) *
                $totalNilai[$kriteria1['kode']];
            }
            DB::table('hasil_bobot_sub_kriteria')->truncate();
            DB::table('hasil_bobot_sub_kriteria')->insert([
                'sub_kriteria_id' => $request->ids,
                'ci' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1),
                'ri' => $nilai_ri,
                'cr' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1) / $nilai_ri, 
            ]);
    
            // return [
            //     'ci' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1),
            //     'ri' => $nilai_ri,
            //     'cr' => ($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1) / $nilai_ri,
            // ];
    
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
