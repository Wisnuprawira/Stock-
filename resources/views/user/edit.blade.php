@extends('layouts.index')
@section('content')
    <div class="row small-spacing">
        <div class="col-lg-6 col-xs-12">
            <div class="box-content card white">
                <h4 class="box-title">Tambah User</h4>
                <!-- /.box-title -->
                <div class="card-content">
                    <form action="{{ route('user.edit',$data['data']['id']) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input name="username" type="text" class="form-control" id="username" value="{{$data['data']['name']}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email"
                                placeholder="Enter your nama email" value="{{$data['data']['email']}}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password"
                                placeholder="" value="{{$data['data']['password']}}">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Role</label>
                            <select class="form-control" name="jabatan" id="">
                                <option value="" disabled selected>-- Select Role --</option>
                                <option value="admin" @if($data['data']['jabatan'] == 'admin') selected @endif>Admin</option>
                                <option value="user" @if($data['data']['jabatan'] == 'user') selected @endif>User</option>
                            </select>
                        </div>

                        <a href="{{route('user.index')}}" class="btn btn-secondary btn-sm waves-effect waves-light"> <i class="fa fa-arrow-left"></i> Back</a>
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
