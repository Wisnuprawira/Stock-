<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alternatif;
use App\Models\Kriteria;

class DashboardController extends Controller
{
    public function index(){
        $user = User::count();
        $sup = Alternatif::orderby('nama','ASC')->get();
        $krit = Kriteria::count();
        $data = [
            'title' => "Dashboard",
            'user' => $user,
            'sup' => $sup,
            'krit' => $krit
        ];
        return view('dashboard.index',compact('data'));
    }
}
