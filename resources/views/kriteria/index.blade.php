@extends('layouts.index')
@section('header')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ asset('assets/plugin/datatables/media/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css') }}">
@endsection
@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">

            <div class="box-content">
                {{-- <h4 class="box-title">Default</h4> --}}
                <!-- /.box-title -->
                <a href="{{ route('kriteria.createPages') }}" class="btn btn-primary mb-2" style="margin-bottom: 10px;">Tambah
                    Kriteria</a>
                {{-- <div class="dropdown js__drop_down">
                <a href="#" class="dropdown-icon glyphicon glyphicon-option-vertical js__drop_down_button"></a>
                <ul class="sub-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else there</a></li>
                    <li class="split"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
                <!-- /.sub-menu -->
            </div> --}}
                <!-- /.dropdown js__dropdown -->
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($data['data'] as $value)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
                            <td class="align-middle" style="vertical-align: middle;">{{$value->kode}}</td>
                            <td style="vertical-align: middle;">{{$value->nama}}</td>
                            <td class="text-center">
                                <a href="{{route('kriteria.editPages',$value->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                <a href="{{route('kriteria.delete',$value->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
    
    @if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif
@endsection

