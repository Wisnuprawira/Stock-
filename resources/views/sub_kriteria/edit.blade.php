@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Edit Sub Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('sub.kriteria.edit', $data['data']['id']) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Kriteria</label>
                            <select name="kriteria" class="form-control" id="kode"
                                placeholder="Enter your kode kriteria">
                                <option value="" selected disabled>---- Pilih Kriteria ----</option>
                                @foreach ($data['kriteria'] as $value)
                                    <option value="{{ $value['id'] }}" @if ($value['id'] == $data['data']['kriteria_id']) selected @endif>
                                        {{ $value['kode'] }} - {{ $value['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Sub Kriteria</label>
                            <input value="{{ $data['data']['kode'] }}" name="kode" type="text" class="form-control"
                                id="kode" placeholder="Enter your kode kriteria">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Sub Kriteria</label>
                            <input value="{{ $data['data']['nama'] }}" name="nama" type="text" class="form-control"
                                id="nama" placeholder="Enter your nama kriteria">
                        </div>
                        <div class="form-group">
                            <label for="operator">Operator</label>
                            <select name="operator" id="operator" class="form-control">
                                <option value="">---- Pilih Operator ----</option>
                                <option value=">" @if ($data['data']['operator'] == '>')
                                    selected
                                    @endif>Lebih besar (>)</option>
                                <option value="<" @if ($data['data']['operator'] == '<') selected @endif>Lebih kecil (<)<
                                        /option>
                                <option value=">=" @if ($data['data']['operator'] == '>=')
                                    selected
                                    @endif>Lebih besar sama dengan (=>)</option>
                                <option value="<=" @if ($data['data']['operator'] == '<=') selected @endif>Lebih kecil sama
                                    dengan (<=)< /option>
                                <option value="<=>" @if ($data['data']['operator'] == '<=>')
                                    selected
                                    @endif>diantara (<=>)</option>
                            </select>
                        </div>
                        <div class="form-group" id="fixed" @if ($data['data']['operator'] == '<=>') hidden @endif>

                            <label for="nama">Nilai (%)</label>
                            <input name="nilai" type="number" min="0" max="100" class="form-control"
                                id="nilai" placeholder="Enter your nilai kriteria"
                                value="{{ $data['data']['operator_nilai'] }}">
                        </div>

                        <div class="form-group" id="antara" @if ($data['data']['operator'] != '<=>') hidden @endif>
                          
                           

                            <label for="nama">Nilai (%)</label>
                            <div class="row">
                                <div class="col-xs-5 "><input name="nilai_1" type="number" min="0" max="100"
                                        value="{{ $data['data']['exp'] ? $data['data']['exp'][0] : '' }}" class="form-control" id="nilai_1"
                                        placeholder="Enter your nilai kriteria"></div>
                                <div class="col-xs-2 ">
                                    <div class="text-center align-middle form-control" style="border:none">
                                        <=>
                                    </div>
                                </div>
                                <div class="col-xs-5"><input name="nilai_2" value="{{ $data['data']['exp'] ? $data['data']['exp'][1] : '' }}" type="number"
                                        min="0" max="100" class="form-control" id="nilai_2"
                                        placeholder="Enter your nilai kriteria"></div>
                            </div>
                        </div>

                        <a href="{{ route('sub.kriteria.index') }}"
                            class="btn btn-secondary btn-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i>
                            Back</a>
                        <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Submit</button>
                    </form>
                </div>
                <!-- /.card-content -->
            </div>
            <!-- /.box-content -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#operator').on('change', function() {
            if (this.value == "<=>") {
                $('#antara').removeAttr('hidden'); // Menampilkan elemen
                $('#fixed').attr('hidden', true);
            } else {
                $('#antara').attr('hidden', true); // Menyembunyikan elemen jika nilai tidak cocok
                $('#fixed').removeAttr('hidden');
            }
            console.log(this.value);
        });
    </script>
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
