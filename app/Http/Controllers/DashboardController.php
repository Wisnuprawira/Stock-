<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use DB;

class DashboardController extends Controller
{
    public function index(){
        $user = User::count();
        $years = DB::table('alternatif')
    ->select('tahun')
    ->groupBy('tahun')
    ->pluck('tahun');

        $loops = [];
        foreach($years as $value){
            $tahun = $value;
            $datas = Alternatif::where('tahun',$value)->get();
            $datas->map(function($x){
                $explode = explode('_',$x->sub_kriteria_ids);
                $x['sub_krits'] = SubKriteria::whereIn('id',$explode)->get();
               
    
                $x['sub_krits']->map(function($y) use ($x){
                    $y['krits'] = Kriteria::where('id',$y->kriteria_id)->first();
                    $x['total_rangking'] += ($y['krits']['prioritas'] * $y['prioritas']);
                    return $y;
                });
                $x['explode'] = $explode;
                return $x;
            });
            $datas = $datas->sortBy('total_rangking')->values();
            // Assign rankings based on sorted order
            $datas->each(function($x, $index) {
                $x->number_rangking = $index + 1;
            });
            $x = [
                'tahun' => $value,
                'data' => $datas
            ];
            array_push($loops, $x);
        }
  
        
        
        // return $loops;
        $krit = Kriteria::orderby('kode','ASC')->get();
        $krit->map(function($x){
            $x['sub'] = SubKriteria::where('kriteria_id',$x->id)->orderby('kode','ASC')->get();
            return $x;
        });
       
        $data = [
            'title' => "Dashboard",
            'user' => $user,
            // 'sup' => $sup,
            'krit' => $krit->count(),
            'list_krit' => $krit,
            'loops' => $loops
        ];
        
        // return $data;
        return view('dashboard.index',compact('data'));
    }
}
