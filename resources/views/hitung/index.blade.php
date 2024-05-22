@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-12 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Perbandingan Kriteria</h4>
                <!-- /.box-title -->

                @if (request()->segment(3))
                    <form action="{{ route('sub-hitung.create') }}" method="post">
                    @else
                        <form action="{{ route('hitung.create') }}" method="post">
                @endif
                @csrf
                <div class="card-content">

                    @if ($data['bobot']->count() == 0)
                        @for ($i = 0; $i < count($data['kriteria']); $i++)
                            @for ($j = $i + 1; $j < count($data['kriteria']); $j++)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <input type="text" class="form-control" readonly
                                                id="{{ $data['kriteria'][$i]['kode'] }}_{{ $i }}_{{ $j }}1"
                                                value="{{ $data['kriteria'][$i]['kode'] }} - {{ $data['kriteria'][$i]['nama'] }}"
                                                required>
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <select class="form-control" name="kriteria[]">
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_1">
                                                    1 - Sama Pentingnya</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_2">
                                                    2 - Mendekati Sedikit Lebih Penting</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_3">
                                                    3 - Sedikit lebih penting</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_4">
                                                    4 - Mendekati Cukup Penting</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_5">
                                                    5 - Cukup penting</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_6">
                                                    6 - Mendekati Sangat Penting</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_7">
                                                    7 - Sangat penting </option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_8">
                                                    8 - Mendekati Ekstrim pentingnya</option>
                                                <option
                                                    value="{{ $data['kriteria'][$i]['kode'] }}_{{ $data['kriteria'][$j]['kode'] }}_9">
                                                    9 - Ekstrim pentingnya</option>

                                            </select>
                                        </div>


                                        <div class="form-group col-lg-3">
                                            <input type="text" class="form-control" readonly
                                                id="{{ $data['kriteria'][$j]['kode'] }}{{ $i }}_{{ $j }}2"
                                                value="{{ $data['kriteria'][$j]['kode'] }} - {{ $data['kriteria'][$j]['nama'] }}"
                                                required>
                                        </div>
                                    </div>

                                </div>
                            @endfor
                        @endfor
                    @else
                        @foreach ($data['bobot'] as $value)
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" readonly id=""
                                            value="{{ $value['rel_1']['kode'] }} - {{ $value['rel_1']['nama'] }}"
                                            required>
                                    </div>


                                    <div class="form-group col-lg-8">
                                        <select class="form-control" name="kriteria[]">
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_1"
                                                @if ($value['nilai'] == 1) selected @endif>1 - Sama Pentingnya
                                            </option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_2"
                                                @if ($value['nilai'] == 2) selected @endif>2 - Mendekati Sedikit
                                                Lebih Penting</option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_3"
                                                @if ($value['nilai'] == 3) selected @endif>3 - Sedikit lebih
                                                penting</option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_4"
                                                @if ($value['nilai'] == 4) selected @endif>4 - Mendekati Cukup
                                                Penting</option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_5"
                                                @if ($value['nilai'] == 5) selected @endif>5 - Cukup penting
                                            </option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_6"
                                                @if ($value['nilai'] == 6) selected @endif>6 - Mendekati Sangat
                                                Penting</option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_7"
                                                @if ($value['nilai'] == 7) selected @endif>7 - Sangat penting
                                            </option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_8"
                                                @if ($value['nilai'] == 8) selected @endif>8 - Mendekati Ekstrim
                                                pentingnya</option>
                                            <option value="{{ $value['rel_1']['kode'] }}_{{ $value['rel_2']['kode'] }}_9"
                                                @if ($value['nilai'] == 9) selected @endif>9 - Ekstrim pentingnya
                                            </option>

                                        </select>
                                    </div>


                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" readonly id=""
                                            value="{{ $value['rel_2']['kode'] }} - {{ $value['rel_2']['nama'] }}"
                                            required>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif




                    {{-- <a href="{{ route('sub.kriteria.index') }}"
                            class="btn btn-secondary btn-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i>
                            Back</a> --}}

                    <button type="submit" class=" btn btn-primary btn-sm waves-effect waves-light" name="ids"
                        value="{{ request()->segment(3) ? request()->segment(3) : null }}">Submit</button>

                    @if (request()->segment(3))
                        <a href="{{ route('sub-hitung.reset', request()->segment(3)) }}"
                            class="btn btn-warning btn-sm waves-effect waves-light">
                            Reset </a>
                    @else
                        <a href="{{ route('hitung.reset') }}" class="btn btn-warning btn-sm waves-effect waves-light">
                            Reset</a>
                    @endif

                </div>
                </form>

                <!-- /.card-content -->
            </div>
            <!-- /.box-content -->
        </div>
        <!-- /.col-lg-6 col-xs-12 -->

        <div class="col-lg-12 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Matriks Perbandingan Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <table class="table table-bordered">
                        @if ($data['bobot']->count() == 0)
                            <tbody>
                                <tr class="text-center">
                                    <td width="10%">Kode</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td width="10%">{{ $kriteria['kode'] }}
                                            <small>({{ $kriteria['nama'] }})</small>
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($data['kriteria'] as $kriteria1)
                                    <tr class="text-center">
                                        <td scope="row">{{ $kriteria1['kode'] }}</td>
                                        @foreach ($data['kriteria'] as $kriteria2)
                                            <td>
                                                @if ($kriteria1['kode'] == $kriteria2['kode'])
                                                    1
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <td class="text-center">Total</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td> - </td> {{-- Menampilkan total kolom --}}
                                    @endforeach
                                </tr>
                            </tfoot>
                        @else
                            <tbody>
                                <tr class="text-center">
                                    <td width="10%">Kode</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td width="10%">{{ $kriteria['kode'] }}
                                            <small>({{ $kriteria['nama'] }})</small>
                                        </td>
                                    @endforeach

                                </tr>
                                @foreach ($data['kriteria'] as $kriteria1)
                                    <tr class="text-center">
                                        <td scope="row">{{ $kriteria1['kode'] }}
                                            <small>({{ $kriteria1['nama'] }})</small>
                                        </td>
                                        @foreach ($data['kriteria'] as $kriteria2)
                                            <td>
                                                @if ($kriteria1['kode'] == $kriteria2['kode'])
                                                    1
                                                @else
                                                    @php
                                                        $nilai = ''; // Inisialisasi nilai bobot
                                                    @endphp
                                                    @foreach ($data['bobot'] as $items)
                                                        @if ($kriteria1['kode'] . $kriteria2['kode'] == $items['rel_1']['kode'] . $items['rel_2']['kode'])
                                                            {{ $items['nilai'] }}
                                                            {{-- // Nilai sesuai dengan urutan pasangan kriteria --}}
                                                            @php
                                                                $nilai = $items['nilai']; // Simpan nilai bobot
                                                            @endphp
                                                        @endif
                                                        @if ($kriteria1['kode'] . $kriteria2['kode'] == $items['rel_2']['kode'] . $items['rel_1']['kode'])
                                                            {{ 1 / $items['nilai'] }}
                                                            {{-- // Menggunakan nilai kebalikan --}}
                                                            @php
                                                                $nilai = 1 / $items['nilai']; // Simpan nilai kebalikan
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if ($nilai === '')
                                                        {{-- Jika tidak ada nilai bobot yang ditemukan  --}}
                                                        {{ '-' }}
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="text-center">
                                <tr>
                                    <td class="text-center">Total</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        @php
                                            $total = 0; // Inisialisasi nilai total kolom
                                        @endphp
                                        @foreach ($data['bobot'] as $items)
                                            @if ($kriteria['kode'] == $items['rel_2']['kode'] && $kriteria['kode'] != $items['rel_1']['kode'])
                                                @php
                                                    $total += $items['nilai']; // Tambahkan nilai ke total kolom
                                                @endphp
                                            @endif
                                            @if ($kriteria['kode'] != $items['rel_2']['kode'] && $kriteria['kode'] == $items['rel_1']['kode'])
                                                @php
                                                    $total += 1 / $items['nilai']; // Tambahkan nilai ke total kolom
                                                @endphp
                                            @endif
                                        @endforeach
                                        {{-- Tambahkan nilai 1 pada diagonal utama --}}
                                        @foreach ($data['kriteria'] as $kriteriaDiagonal)
                                            @if ($kriteria['kode'] == $kriteriaDiagonal['kode'])
                                                @php
                                                    $total += 1; // Tambahkan nilai 1 pada diagonal utama
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td>{{ $total }}</td> {{-- Menampilkan total kolom --}}
                                    @endforeach
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                </div>
                <!-- /.card-content -->
            </div>

            <div class="box-content card white">
                <h4 class="box-title">Matriks Nilai Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <table class="table table-bordered">
                        @if ($data['bobot']->count() == 0)
                            <tbody>
                                <tr class="text-center">
                                    <td width="10%">Kode</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td width="10%">{{ $kriteria['kode'] }} <small>({{ $kriteria['nama'] }})
                                            </small></td>
                                    @endforeach
                                    <td>Jumlah</td>
                                    <td>Prioritas</td>
                                    <td>Eigen Value</td>
                                </tr>
                                @foreach ($data['kriteria'] as $kriteria1)
                                    <tr class="text-center">
                                        <td scope="row">{{ $kriteria1['kode'] }}</td>
                                        @foreach ($data['kriteria'] as $kriteria2)
                                            <td>
                                                @if ($kriteria1['kode'] == $kriteria2['kode'])
                                                    1
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                        <td> - </td>
                                        <td> - </td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <td class="text-center">Total</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td> - </td> {{-- Menampilkan total kolom --}}
                                    @endforeach
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tfoot>
                        @else
                            <tbody>
                                <tr class="text-center">
                                    <td width="10%">Kode</td>
                                    @foreach ($data['kriteria'] as $kriteria)
                                        <td width="10%">{{ $kriteria['kode'] }}
                                            <small>({{ $kriteria['nama'] }})</small>
                                        </td>
                                    @endforeach
                                    <td>Jumlah</td>
                                    <td>Prioritas</td>
                                    <td>Eigen Value</td>
                                </tr>
                                @php
                                    $nilais = 0;
                                    $alpa = 'x';
                                @endphp
                                @foreach ($data['kriteria'] as $kriteria1)
                                    <tr class="text-center">
                                        <td scope="row">{{ $kriteria1['kode'] }}
                                            <small>({{ $kriteria1['nama'] }})</small>
                                        </td>
                                        @foreach ($data['kriteria'] as $kriteria2)
                                        
                                            @if ($kriteria1['kode'] == $kriteria2['kode'])
                                         
                                                @php
                                                    $under = 0;
                                                    $nilai = number_format(1 / $kriteria1['total_nilai'], 2);
                                                    $nilais += $nilai;
                                                    $codes = $kriteria1['kode'].$kriteria2['kode'];
                                                   $alpa = $kriteria1['kode'];
                                                @endphp
                                                
                                                <td>{{ $kriteria1['kode'] }}{{ $kriteria2['kode'] }} {{ $nilai }} {{ $codes }} {{  $alpa }}</td>
                                            @else
                                            
                                                @foreach ($data['bobot'] as $bb)
                                                    @if ($kriteria1['kode'] . $kriteria2['kode'] == $bb['kriteria_id'] . $bb['kriteria_id2'])
                                                        @php
                                                            $nilai = number_format(
                                                                $bb['nilai'] / $bb['rel_2']['total_nilai'],
                                                                2,
                                                            );

                                                            $codes = $kriteria1['kode'] . $kriteria2['kode'];
                                                            
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @foreach ($data['bobot'] as $bb)
                                                    @if ($kriteria1['kode'] . $kriteria2['kode'] == $bb['kriteria_id2'] . $bb['kriteria_id'])
                                                        @php
                                                            $nilai = number_format(
                                                                1 / $bb['nilai'] / $bb['rel_1']['total_nilai'],
                                                                2,
                                                            );
                                                            $codes = $kriteria2['kode'].$kriteria1['kode'];
                                                            
                                                            

                                                        @endphp
                                                    @endif
                                                @endforeach
                                                
                                                <td>

                                                    {{ $kriteria1['kode'] }}{{ $kriteria2['kode'] }} {{ $nilai }}
                                                    {{ $codes }} 
                                                </td>
                                                
                                            @endif
                                        @endforeach

                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    @for ($k = 0; $k < $data['kriteria']->count(); $k++)
                                        <td>

                                            {{ $nilais }} 
                                        </td>
                                    @endfor
                                    <td></td>
                                </tr>

                            </tbody>
                        @endif
                    </table>
                </div>
                <!-- /.card-content -->
            </div>

            <div class="box-content card white">
                <h4 class="box-title">Matriks Nilai Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="">
                                <td width="20%">CI (Consistency Index)</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td width="20%">RI (Ratio Index)</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td width="20%">CR (Consistency Ratio)</td>
                                <td>-</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-content -->
            </div>
        </div>
        <!-- /.col-lg-6 col-xs-12 -->



    </div>
@endsection
@section('js')
    <!-- Data Tables -->
    <script src="{{ asset('assets/plugin/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/datatables/extensions/Responsive/js/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/datatables.demo.min.js') }}"></script>

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
@endsection
