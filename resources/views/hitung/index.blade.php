@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-12 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Perbandingan Kriteria</h4>
                @php
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
                @endphp
    
                @if (request()->segment(3))
                    <form action="{{ route('sub-hitung.create') }}" method="post">
                    @else
                        <form action="{{ route('hitung.create') }}" method="post">
                @endif
                @csrf
                <div class="card-content">

                    @if ($data['bobot']->count() == 0)
                        @for ($i = 0; $i < count($data['kriteria']); $i++)
                            @for ($j = $i; $j < count($data['kriteria']); $j++)
                                @if ($data['kriteria'][$i]['kode'] == $data['kriteria'][$j]['kode'])
                                    <div class="col-12" hidden>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <input type="hidden" class="form-control" readonly id=""
                                                    name="rel_1[]" value="{{ $data['kriteria'][$i]['kode'] }}" required>
                                                <input type="text" class="form-control" readonly id=""
                                                    name=""
                                                    value="{{ $data['kriteria'][$i]['kode'] }} - {{ $data['kriteria'][$i]['nama'] }}"
                                                    required>
                                            </div>


                                            <div class="form-group col-lg-6">
                                                <select class="form-control" name="kriteria[]">
                                                    <option value="1">
                                                        1 - Sama Pentingnya</option>
                                                    <option value="2">
                                                        2 - Mendekati Sedikit Lebih Penting</option>
                                                    <option value="3">
                                                        3 - Sedikit lebih penting</option>
                                                    <option value="4">
                                                        4 - Mendekati Cukup Penting</option>
                                                    <option value="5">
                                                        5 - Cukup penting</option>
                                                    <option value="6">
                                                        6 - Mendekati Sangat Penting</option>
                                                    <option value="7">
                                                        7 - Sangat penting </option>
                                                    <option value="8">
                                                        8 - Mendekati Ekstrim pentingnya</option>
                                                    <option value="9">
                                                        9 - Ekstrim pentingnya</option>

                                                </select>
                                            </div>


                                            <div class="form-group col-lg-3">
                                                <input type="hidden" class="form-control" readonly
                                                    id="{{ $data['kriteria'][$j]['kode'] }}{{ $i }}_{{ $j }}2"
                                                    name="rel_2[]" value="{{ $data['kriteria'][$j]['kode'] }}" required>
                                                <input type="text" class="form-control" readonly
                                                    id="{{ $data['kriteria'][$j]['kode'] }}{{ $i }}_{{ $j }}2"
                                                    name=""
                                                    value="{{ $data['kriteria'][$j]['kode'] }} - {{ $data['kriteria'][$j]['nama'] }}"
                                                    required>
                                            </div>

                                        </div>

                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <input type="hidden" class="form-control" readonly id=""
                                                    name="rel_1[]" value="{{ $data['kriteria'][$i]['kode'] }}" required>
                                                <input type="text" class="form-control" readonly id=""
                                                    name=""
                                                    value="{{ $data['kriteria'][$i]['kode'] }}  - {{ $data['kriteria'][$i]['nama'] }}"
                                                    required>
                                            </div>


                                            <div class="form-group col-lg-6">
                                                <select class="form-control" name="kriteria[]">
                                                    <option value="1">
                                                        1 - Sama Pentingnya</option>
                                                    <option value="2">
                                                        2 - Mendekati Sedikit Lebih Penting</option>
                                                    <option value="3">
                                                        3 - Sedikit lebih penting</option>
                                                    <option value="4">
                                                        4 - Mendekati Cukup Penting</option>
                                                    <option value="5">
                                                        5 - Cukup penting</option>
                                                    <option value="6">
                                                        6 - Mendekati Sangat Penting</option>
                                                    <option value="7">
                                                        7 - Sangat penting </option>
                                                    <option value="8">
                                                        8 - Mendekati Ekstrim pentingnya</option>
                                                    <option value="9">
                                                        9 - Ekstrim pentingnya</option>

                                                </select>
                                            </div>


                                            <div class="form-group col-lg-3">
                                                <input type="hidden" class="form-control" readonly
                                                    id="{{ $data['kriteria'][$j]['kode'] }}{{ $i }}_{{ $j }}2"
                                                    name="rel_2[]" value="{{ $data['kriteria'][$j]['kode'] }}" required>
                                                <input type="text" class="form-control" readonly
                                                    id="{{ $data['kriteria'][$j]['kode'] }}{{ $i }}_{{ $j }}2"
                                                    name=""
                                                    value="{{ $data['kriteria'][$j]['kode'] }} - {{ $data['kriteria'][$j]['nama'] }}"
                                                    required>
                                            </div>

                                        </div>

                                    </div>
                                @endif
                            @endfor
                        @endfor
                    @else
                        @php
                            // Array untuk melacak pasangan yang sudah ditampilkan
                            $displayedPairs = [];
                        @endphp
                        @foreach ($data['bobot'] as $value)
                            @php
                                // Membuat kunci untuk pasangan kriteria saat ini dan pasangan terbaliknya
                                $pair = $value['kriteria_id'] . '-' . $value['kriteria_id2'];
                                $reversePair = $value['kriteria_id2'] . '-' . $value['kriteria_id'];

                                // Cek apakah pasangan atau pasangan terbaliknya sudah ditampilkan
                                $isDisplayed =
                                    in_array($pair, $displayedPairs) || in_array($reversePair, $displayedPairs);
                            @endphp
                            @if ($value['kriteria_id'] == $value['kriteria_id2'])
                                <div class="col-12" hidden>
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <input type="hidden" class="form-control" readonly id=""
                                                name="rel_1[]" value="{{ $value['kriteria_id'] }}" required>
                                            <input type="text" class="form-control" readonly id=""
                                                name="" value="{{ $value['kriteria_id'] }}" required>
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <select class="form-control" name="kriteria[]">
                                                <option value="1" @if ($value['nilai'] == 1) selected @endif>
                                                    1 - Sama Pentingnya</option>
                                                <option value="2" @if ($value['nilai'] == 2) selected @endif>
                                                    2 - Mendekati Sedikit Lebih Penting</option>
                                                <option value="3" @if ($value['nilai'] == 3) selected @endif>
                                                    3 - Sedikit lebih penting</option>
                                                <option value="4" @if ($value['nilai'] == 4) selected @endif>
                                                    4 - Mendekati Cukup Penting</option>
                                                <option value="5" @if ($value['nilai'] == 5) selected @endif>
                                                    5 - Cukup penting</option>
                                                <option value="6" @if ($value['nilai'] == 6) selected @endif>
                                                    6 - Mendekati Sangat Penting</option>
                                                <option value="7" @if ($value['nilai'] == 7) selected @endif>
                                                    7 - Sangat penting </option>
                                                <option value="8" @if ($value['nilai'] == 8) selected @endif>
                                                    8 - Mendekati Ekstrim pentingnya</option>
                                                <option value="9" @if ($value['nilai'] == 9) selected @endif>
                                                    9 - Ekstrim pentingnya</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-lg-3">
                                            <input type="hidden" class="form-control" readonly name="rel_2[]"
                                                value="{{ $value['kriteria_id2'] }}" required>
                                            <input type="text" class="form-control" readonly name=""
                                                value="{{ $value['kriteria_id2'] }}" required>
                                        </div>

                                    </div>

                                </div>
                            @endif
                            @if ($value['kriteria_id'] != $value['kriteria_id2'] && !$isDisplayed)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <input type="hidden" class="form-control" readonly id=""
                                                name="rel_1[]" value="{{ $value['kriteria_id'] }}" required>
                                            <input type="text" class="form-control" readonly id=""
                                                name=""
                                                value="{{ $value['kriteria_id'] }} - {{ $value['rel_1']['nama'] }}"
                                                required>
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <select class="form-control" name="kriteria[]">
                                                <option value="1" @if ($value['nilai'] == 1) selected @endif>
                                                    1 - Sama Pentingnya</option>
                                                <option value="2" @if ($value['nilai'] == 2) selected @endif>
                                                    2 - Mendekati Sedikit Lebih Penting</option>
                                                <option value="3" @if ($value['nilai'] == 3) selected @endif>
                                                    3 - Sedikit lebih penting</option>
                                                <option value="4" @if ($value['nilai'] == 4) selected @endif>
                                                    4 - Mendekati Cukup Penting</option>
                                                <option value="5" @if ($value['nilai'] == 5) selected @endif>
                                                    5 - Cukup penting</option>
                                                <option value="6" @if ($value['nilai'] == 6) selected @endif>
                                                    6 - Mendekati Sangat Penting</option>
                                                <option value="7" @if ($value['nilai'] == 7) selected @endif>
                                                    7 - Sangat penting </option>
                                                <option value="8" @if ($value['nilai'] == 8) selected @endif>
                                                    8 - Mendekati Ekstrim pentingnya</option>
                                                <option value="9" @if ($value['nilai'] == 9) selected @endif>
                                                    9 - Ekstrim pentingnya</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-lg-3">
                                            <input type="hidden" class="form-control" readonly name="rel_2[]"
                                                value="{{ $value['kriteria_id2'] }}" required>
                                            <input type="text" class="form-control" readonly name=""
                                                value="{{ $value['kriteria_id2'] }} - {{ $value['rel_2']['nama'] }}"
                                                required>
                                        </div>

                                    </div>

                                </div>
                                @php
                                    // Tandai pasangan ini sebagai sudah ditampilkan
                                    $displayedPairs[] = $pair;
                                @endphp
                            @endif
                        @endforeach
                    @endif

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
                            @php
                                // Menghitung total nilai untuk setiap kriteria
                                $totalNilai = [];
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
                                }
                            @endphp
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
                                                @foreach ($data['bobot'] as $b)
                                                    @if ($kriteria1['kode'] . $kriteria2['kode'] == $b['kriteria_id'] . $b['kriteria_id2'])
                                                        {{ number_format($b['nilai'],2) }}
                                                        {{-- <br>
                                                        {{ $kriteria1['kode'] . $kriteria2['kode'] }} - row
                                                        <br> --}}

                                                        {{-- {{ $kriteria2['kode'] . $kriteria1['kode'] }} - kolom --}}
                                                    @endif
                                                @endforeach

                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr class="text-center">
                                    <td>Total</td>

                                    @foreach ($data['kriteria'] as $kriteria1)
                                        <td>{{ number_format($totalNilai[$kriteria1['kode']],2) }}</td>
                                    @endforeach

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
                            @php
                                // Menghitung total nilai untuk setiap kriteria
                                $totalNilais = [];
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
                                }

                                $totalNilaiJumlah = [];
                                // $totalNilaiJumlahTotal = 0;
                                foreach ($data['kriteria'] as $kriteria1) {
                                    $totalNilaiJumlah[$kriteria1['kode']] = 0;
                                    // foreach ($data['kriteria'] as $kriteria2) {
                                    foreach ($data['bobot'] as $b) {
                                        if ($kriteria1['kode'] == $b['kriteria_id']) {
                                            $o = $b['nilai'] / $totalNilai[$b['kriteria_id2']];
                                            $totalNilaiJumlah[$kriteria1['kode']] += $o;
                                        }
                                    }

                                    // }
                                }

                                $totalJumlah = 0;
                                $totalPrioritas = 0;
                                $totalEigen = 0;

                                // dd($totalNilaiJumlah)

                            @endphp
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
                                @foreach ($data['kriteria'] as $kriteria1)
                                    <tr class="text-center">
                                        <td scope="row">{{ $kriteria1['kode'] }}
                                            <small>({{ $kriteria1['nama'] }})</small>
                                        </td>
                                        @foreach ($data['kriteria'] as $kriteria2)
                                            <td class="text-center">
                                                @foreach ($data['bobot'] as $b)
                                                    @if ($kriteria1['kode'] . $kriteria2['kode'] == $b['kriteria_id'] . $b['kriteria_id2'])
                                                        {{ number_format($b['nilai'] / $totalNilai[$kriteria2['kode']], 2) }}
                                                        <br>
                                                        {{-- {{ $kriteria1['kode'] . $kriteria2['kode'] }} --}}
                                                        {{-- {{ $b['kriteria_id'] . $b['kriteria_id2'] }} - row
                                                        <br>

                                                        {{ $kriteria2['kode'] . $kriteria1['kode'] }} - kolom --}}
                                                    @endif
                                                @endforeach

                                            </td>
                                        @endforeach
                                        <td>
                                            {{ number_format($totalNilaiJumlah[$kriteria1['kode']], 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']), 2) }}
                                        </td>
                                        <td> {{ number_format(($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) * $totalNilai[$kriteria1['kode']], 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="text-center">
                                    <td>Total</td>

                                    @foreach ($data['kriteria'] as $kriteria1)
                                        <td>{{ number_format($totalNilais[$kriteria1['kode']], 2) }}</td>
                                        @php
                                            $totalJumlah += $totalNilaiJumlah[$kriteria1['kode']];
                                            $totalPrioritas +=
                                                $totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria']);
                                            $totalEigen +=
                                                ($totalNilaiJumlah[$kriteria1['kode']] / count($data['kriteria'])) *
                                                $totalNilai[$kriteria1['kode']];
                                        @endphp
                                    @endforeach
                                    <td>
                                        {{ number_format($totalJumlah, 2) }}</td>
                                    <td>{{ number_format($totalPrioritas, 2) }}</td>
                                    <td>{{ number_format($totalEigen, 2) }}</td>

                                </tr>
                            </tbody>
                        @endif

                    </table>
                </div>
                <!-- /.card-content -->
            </div>

            <div class="box-content card white">

                <h4 class="box-title">Matriks Random Consistency Index</h4>
                <div class="card-content">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="text-center">
                                <td width="20%">Matrik Size</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                            </tr>
                            <tr class="text-center">
                                <td width="20%">Random Consistency Index (RI)</td>
                                <td>0.00</td>
                                <td>0.00</td>
                                <td>0.58</td>
                                <td>0.90</td>
                                <td>1.12</td>
                                <td>1.24</td>
                                <td>1.32</td>
                                <td>1.41</td>
                                <td>1.45</td>
                                <td>1.49</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-content card white">

                <h4 class="box-title">Matriks Nilai Kriteria</h4>


                <!-- /.box-title -->
                @if ($data['bobot']->count() > 0)
                    <div class="card-content">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="">
                                    <td width="20%">CI (Consistency Index)</td>
                                    <td>{{ number_format(($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">RI (Ratio Index)</td>
                                    <td>{{$nilai_ri}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">CR (Consistency Ratio)</td>
                                    <td>{{ number_format(($totalEigen - count($data['kriteria'])) / (count($data['kriteria']) - 1) / $nilai_ri, 2) }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                @else
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
                @endif
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
