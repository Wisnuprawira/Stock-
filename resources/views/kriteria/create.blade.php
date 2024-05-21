@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Tambah Kriteria</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('kriteria.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Kriteria</label>
                            <input name="kode" type="text" class="form-control" id="kode" placeholder="Enter your kode kriteria">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Kriteria</label>
                            <input name="nama" type="text" class="form-control" id="nama"
                                placeholder="Enter your nama kriteria">
                        </div>

                        <a href="{{route('kriteria.index')}}" class="btn btn-secondary btn-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i> Back</a>
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
