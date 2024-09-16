@extends('layouts.index')
@section('header')
    <!-- Chartist Chart -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/chart/chartist/chartist.min.css') }}">
@endsection
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
            {{-- <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="box-content bg-danger text-white">
                    <div class="statistics-box with-icon">
                        <i class="ico small fa fa-dropbox"></i>
                        <p class="text text-white">Supplier</p>
                        <h2 class="counter">{{ $data['sup']->count() }}</h2>
                    </div>
                </div>
                <!-- /.box-content -->
            </div> --}}
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
            @foreach ($data['loops'] as $key => $items)
                <div class="col-lg-12 col-xs-12">
                    <div class="box-content">
                        <h4 class="box-title">Tahun {{ $items['tahun'] }}</h4>
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
                                @foreach ($items['data'] as $key => $value)
                                    @php
                                        $key++;
                                    @endphp
                                    <tr
                                        class="@if ($key == 1) success @endif @if ($key == 1) text-white @endif">
                                        {{-- <th scope="row">1</th> --}}

                                        <td class="text-center ">{{ $value['nama'] }}</td>
                                        @foreach ($value['sub_krits'] as $values)
                                            <td class="text-center">{{ number_format($values['prioritas'] * $values['krits']['prioritas'],4) }}</td>
                                        @endforeach
                                        <td class="text-center">{{ number_format($value['total_rangking'], 4) }}</td>
                                        <td class="text-center">
                                            {{ $key }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-content -->
                </div>
                {{-- <div class="col-12">

                    <canvas id="bar-chartjs-chart-{{ $key }}" class="chartjs-chart" height="50"></canvas>
                </div> --}}
            @endforeach
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
                                        {{ number_format($items['prioritas'], 2) }}
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
                                            {{ number_format($items['prioritas'], 2) }}
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

@section('js')
    <script src="{{ asset('assets/plugin/chart/chartjs/Chart.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/scripts/chart.chartjs.init.min.js') }}"></script> --}}


    {{-- <script>
        // Mengambil elemen canvas dengan ID dinamis
        var ctx = document.getElementById('bar-chartjs-chart-1').getContext('2d');

        // Data kustom untuk bar chart dengan beberapa dataset
        var data = {
            labels: ['TEST', 'TEST2', 'TEST3', 'sd', 'asd'], // Label pada sumbu X
            datasets: [{
                    label: 'DER', // Nama dataset pertama
                    data: [10, 15, 20, 25, 30], // Data untuk dataset pertama
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna bar dataset pertama
                    borderColor: 'rgba(255, 99, 132, 1)', // Warna garis bar dataset pertama
                    borderWidth: 1
                },
                {
                    label: 'PER', // Nama dataset kedua
                    data: [5, 10, 15, 20, 25], // Data untuk dataset kedua
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna bar dataset kedua
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna garis bar dataset kedua
                    borderWidth: 1
                },
                {
                    label: 'ROA', // Nama dataset ketiga
                    data: [8, 12, 18, 22, 28], // Data untuk dataset ketiga
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna bar dataset ketiga
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis bar dataset ketiga
                    borderWidth: 1
                }
            ]
        };

        // Opsi kustom untuk chart
        var options = {
            scales: {
                y: {
                    beginAtZero: true, // Mulai dari nol pada sumbu Y
                    ticks: {
                        stepSize: 5 // Jarak antar nilai pada sumbu Y
                    }
                }
            }
        };

        // Membuat bar chart menggunakan data dan opsi kustom
        var barChart = new Chart(ctx, {
            type: 'bar', // Jenis chart
            data: data,
            options: options
        });
    </script> --}}
@endsection
