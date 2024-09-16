@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Tambah Sub Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('sub.kriteria.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Kriteria</label>
                            <select name="kriteria" class="form-control" id="kode"
                                placeholder="Enter your kode kriteria" required>
                                <option value="" selected disabled>---- Pilih Kriteria ----</option>
                                @foreach ($data['data'] as $value)
                                    <option value="{{ $value['id'] }}">{{ $value['kode'] }} - {{ $value['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Sub Kriteria</label>
                            <input name="kode" type="text" class="form-control" id="kode"
                                placeholder="Enter your kode kriteria" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Sub Kriteria</label>
                            <input name="nama" type="text" class="form-control" id="nama"
                                placeholder="Enter your nama kriteria" required>
                        </div>
                        <div class="form-group">
                            <label for="operator">Operator</label>
                            <select name="operator" id="operator" class="form-control" >
                                <option value="" selected>---- Pilih Operator ----</option>
                                <option value=">">Lebih besar (>)</option>
                                <option value="<">Lebih kecil (<)</option>
                                <option value=">=">Lebih besar sama dengan (=>)</option>
                                <option value="<=">Lebih kecil sama dengan (<=)</option>
                                <option value="<=>">diantara (<=>)</option>
                            </select>
                        </div>
                        <div class="form-group" id="fixed" hidden>
                            <label for="nama">Nilai (%)</label>
                            <input name="nilai" type="text"  class="form-control"
                                id="nilai" placeholder="Enter your nilai kriteria">
                        </div>

                        <div class="form-group" id="antara" hidden>
                            <label for="nama">Nilai (%)</label>
                            <div class="row">
                                <div class="col-xs-5 "><input name="nilai_1" type="text" max="100"
                                        class="form-control" id="nilai_1" placeholder="Enter your nilai kriteria"></div>
                                <div class="col-xs-2 ">
                                    <div class="text-center align-middle form-control" style="border:none">
                                        <=>
                                    </div>
                                </div>
                                <div class="col-xs-5"><input name="nilai_2" type="text" max="100"
                                        class="form-control" id="nilai_2" placeholder="Enter your nilai kriteria"></div>
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
