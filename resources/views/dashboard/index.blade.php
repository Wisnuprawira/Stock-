@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="row small-spacing">
            <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="box-content bg-success text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-th-list"></i>
                        <p class="text text-white">Kriteria</p>
                        <h2 class="counter">{{$data['krit']}}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="box-content bg-info text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-users"></i>
                        <p class="text text-white">User</p>
                        <h2 class="counter">{{$data['user']}}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="box-content bg-danger text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-dropbox"></i>
                        <p class="text text-white">Supplier</p>
                        <h2 class="counter">{{$data['sup']->count()}}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            {{-- <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="box-content bg-warning text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-usd"></i>
                        <p class="text text-white">SALES</p>
                        <h2 class="counter">2,637</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div> --}}
        </div>
        <div class="col-lg-6 col-xs-12">
            <div class="box-content">
                <h4 class="box-title">Ranking Supplier</h4>
               
                {{-- <div class="dropdown js__drop_down">
                    <a href="#" class="dropdown-icon glyphicon glyphicon-option-vertical js__drop_down_button"></a>
                    <ul class="sub-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else there</a></li>
                        <li class="split"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
                --}}
                {{-- <p>Use contextual classes to color table rows or individual cells.</p> --}}
                <table class="table">
                    {{-- <caption>Optional table caption.</caption> --}}
                    <thead>
                        <tr>
                            {{-- <th>#</th> --}}
                            <th class="text-center" width="20%">Rangking</th>
                            <th class="text-center">Nama Supplier</th>
                            {{-- <th>Username</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['sup'] as $key => $value)
                        @php 
                        $key++;
                        @endphp
                        <tr class="@if($key == 1) success @endif">
                            {{-- <th scope="row">1</th> --}}
                            <td class="text-center @if($key == 1) text-white @endif">{{$key}}</td>
                            <td class="text-center @if($key == 1) text-white @endif">{{$value['nama']}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <!-- /.box-content -->
        </div>
    </div>
@endsection
