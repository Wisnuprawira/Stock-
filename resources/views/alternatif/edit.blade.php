@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Tambah Alternatif</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('alternatif.create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Nama Supplier</label>
                            <input name="nama" type="text" class="form-control" placeholder="Enter your name supplier"
                                value="{{ $data['data']['nama'] }}">
                        </div>
                        @foreach ($data['krit'] as $value)
                            <input type="hidden" name="krit[]" id="" value="{{ $value['id'] }}">
                            <div class="form-group">
                                <label for="kode">{{ $value['nama'] }}</label>
                                <select class="form-control" name="sub_krit[]" id="">
                                    @foreach ($value['sub'] as $items)
                                        
                                        <option value="{{ $items['id'] }}">{{ $items['nama'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        <a href="{{ route('alternatif.index') }}" class="btn btn-secondary btn-sm waves-effect waves-light">
                            <i class="fa fa-arrow-left"></i> Back</a>
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

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
@endsection
