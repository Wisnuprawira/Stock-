@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Tambah Sub Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('sub.kriteria.edit',$data['data']['id']) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Kriteria</label>
                            <select name="kriteria" class="form-control" id="kode" placeholder="Enter your kode kriteria">
                                <option value="" selected disabled>---- Pilih Kriteria ----</option>
                                @foreach($data['kriteria'] as $value)
                                <option value="{{$value['id']}}" @if($value['id'] == $data['data']['kriteria_id']) selected @endif>{{$value['kode']}} - {{$value['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Sub Kriteria</label>
                            <input value="{{$data['data']['kode']}}" name="kode" type="text" class="form-control" id="kode" placeholder="Enter your kode kriteria">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Sub Kriteria</label>
                            <input value="{{$data['data']['nama']}}" name="nama" type="text" class="form-control" id="nama"
                                placeholder="Enter your nama kriteria">
                        </div>

                        <a href="{{route('sub.kriteria.index')}}" class="btn btn-secondary btn-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i> Back</a>
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
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    
    @if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif
@endsection
