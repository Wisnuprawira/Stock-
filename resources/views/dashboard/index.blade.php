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
            @php
                $numbering = 0;
            @endphp
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
                                            <td class="text-center">
                                                {{ number_format($values['prioritas'] * $values['krits']['prioritas'], 4) }}
                                            </td>
                                        @endforeach
                                        <td class="text-center">{{ number_format($value['total_rangking'], 4) }}</td>
                                        <td class="text-center">
                                            {{ $key }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <canvas id="bar-chartjs-chart-{{ $numbering }}" class="chartjs-chart" height="50"></canvas>
                    </div>
                    <!-- /.box-content -->
                </div>
                @php
                    $numbering++;
                @endphp
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
    <script>
        var number = 0;
        var dataTable = {!! json_encode($data['loops'] ?? []) !!};
        // Fungsi untuk menghasilkan warna pastel acak

        dataTable.forEach((element, index) => {
            function getRandomPastelColor() {
                const r = Math.floor(Math.random() * 128 + 100); // Nilai RGB antara 128 dan 100
                const g = Math.floor(Math.random() * 128 + 100);
                const b = Math.floor(Math.random() * 128 + 100);

                const backgroundColor =
                `rgba(${r}, ${g}, ${b})`; // Warna dengan transparansi 0.5 untuk background
                const borderColor = `rgba(${r}, ${g}, ${b}, 1)`; // Warna solid untuk border

                return {
                    backgroundColor,
                    borderColor
                };
            }
            var dataSetting = [];
            var fileNames = [];
            var labelSetting = [];
            var dataSubkrit = [];
            var ctx = document.getElementById('bar-chartjs-chart-' + index).getContext('2d');
            element.data.forEach(dataItem => {
                var filName = dataItem.nama;
                var dataSe = [];
                fileNames.push(filName);

                dataItem.sub_krits.forEach(sub => {
                    labelSetting.push(sub.krits.nama);
                    dataSe.push((sub.prioritas * sub.krits.prioritas).toFixed(4))
                });
                var color = getRandomPastelColor();
                dataSetting.push({
                    label: dataItem.nama,
                    data: dataSe,
                    backgroundColor: color.backgroundColor, // Warna bar dataset pertama
                    borderColor: color.borderColor, // Warna garis bar dataset pertama
                    borderWidth: 1
                })

            });
            const seenKode = {};
            const uniqueLabelSetting = labelSetting.filter(lab => {
                const kode = lab;

                if (!seenKode[kode]) {
                    seenKode[kode] = true;
                    return true;
                }

                // Jika kode sudah ada, jangan masukkan item
                return false;
            });
            // console.log(uniqueLabelSetting);
            console.log(dataSetting);
            var data = {
                labels: uniqueLabelSetting, // Label pada sumbu X
                datasets: dataSetting
            };

            // Opsi kustom untuk chart
            var options = {
                scales: {
                    y: {
                        beginAtZero: true, // Mulai dari nol pada sumbu Y
                        ticks: {
                            stepSize: 2 // Jarak antar nilai pada sumbu Y
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
        });
    </script>
@endsection
