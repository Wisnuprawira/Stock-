@extends('layouts.index')
@section('content')
    <div class="row small-spacing" style="margin:10px;">
        <div class="row small-spacing">
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="box-content bg-success text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-th-list"></i>
                        <p class="text text-white">Kriteria</p>
                        <h2 class="counter">{{ $data['krit'] }}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="box-content bg-info text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-users"></i>
                        <p class="text text-white">User</p>
                        <h2 class="counter">{{ $data['user'] }}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="box-content bg-danger text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-dropbox"></i>
                        <p class="text text-white">Supplier</p>
                        <h2 class="counter">{{ $data['sup']->count() }}</h2>
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
        <div class="row small-spacing">
            <div class="col-lg-12 col-xs-12">
                <div class="box-content">
                    <h4 class="box-title">Ranking Supplier</h4>
                    {{-- <p>Use contextual classes to color table rows or individual cells.</p> --}}
                    <table class="table">
                        {{-- <caption>Optional table caption.</caption> --}}
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                
                                <th class="text-center">Nama Supplier</th>
                                @foreach ($data['list_krit'] as $value)
                                    <th class="text-center">{{ $value['nama'] }}</th>
                                @endforeach
                                <th class="text-center">Total</th>
                                <th class="text-center" width="20%">Rangking</th>
                                {{-- <th>Username</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['sup'] as $key => $value)
                                @php
                                    $key++;
                                @endphp
                                <tr class="@if ($key == 1) success @endif @if ($key == 1) text-white @endif">
                                    {{-- <th scope="row">1</th> --}}
                                   
                                    <td class="text-center ">{{ $value['nama'] }}</td>
                                        @foreach ($value['sub_krits'] as $values)
                                            <td class="text-center">{{ $values['nama'] }}</td>
                                        @endforeach
                                        <td class="text-center">{{ number_format($value['total_rangking'],2) }}</td>
                                        <td class="text-center">
                                            {{ $key }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-content -->
            </div>
            <div class="col-lg-3 col-xs-12">
                <div class="box-content">
                    {{-- <p>Use contextual classes to color table rows or individual cells.</p> --}}
                    <table class="table">
                        <caption>Kriteria</caption>
                        <tbody>
                            @foreach ($data['list_krit'] as $items)
                                <tr>
                                    <td>
                                        {{ $items['nama'] }}
                                    </td>
                                    <td>
                                        {{ number_format($items['prioritas'],2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-content -->
            </div>
            @foreach ($data['list_krit'] as $value)
                <div class="col-lg-3 col-xs-12">
                    <div class="box-content">
                        {{-- <p>Use contextual classes to color table rows or individual cells.</p> --}}
                        <table class="table">
                            <caption>({{ $value['kode'] }}) {{ $value['nama'] }}</caption>
                            <tbody>
                                @foreach ($value['sub'] as $items)
                                    <tr>
                                        <td>
                                            {{ $items['nama'] }}
                                        </td>
                                        <td>
                                            {{ number_format($items['prioritas'],2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-content -->
                </div>
            @endforeach
            
        </div>
    </div>
@endsection
