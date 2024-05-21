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
                <a href="{{ route('alternatif.createPages') }}" class="btn btn-primary mb-2" style="margin-bottom: 10px;">Tambah
                    alternatif</a>
                
                <!-- /.dropdown js__dropdown -->
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama</th>
                            @foreach($data['kriteria'] as $value)
                                <th>{{$value['nama']}}</th> 
                            @endforeach
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($data['data'] as $value)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
                            <td style="vertical-align: middle;">{{$value['nama']}}</td>
                            @foreach($value['datas'] as $items)
                                <td style="vertical-align: middle;">{{$items->nama}}</td>
                            @endforeach
                           
                            <td class="text-center">
                                {{-- <a href="{{route('alternatif.editPages',$value->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a> --}}
                                <a href="{{route('alternatif.delete',$value->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

