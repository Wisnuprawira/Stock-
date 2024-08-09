@extends('auth.app')

@section('content')
<form action="{{route('register')}}" method="post" class="frm-single">
    @csrf
    <div class="inside">
        {{-- <div class="title"><strong>Ninja</strong>Admin</div> --}}
        <!-- /.title -->
        <div class="frm-title">Register</div>
        <!-- /.frm-title -->
        <div class="frm-input"><input type="email" name="email" placeholder="Email" class="frm-inp"><i class="fa fa-envelope frm-ico"></i></div>
        <!-- /.frm-input -->
        <div class="frm-input"><input type="text" name="username" placeholder="Username" class="frm-inp"><i class="fa fa-user frm-ico"></i></div>
        <!-- /.frm-input -->
        <div class="frm-input"><input type="password" name="password" placeholder="Password" class="frm-inp"><i class="fa fa-lock frm-ico"></i></div>
        <!-- /.frm-input -->
        {{-- <div class="clearfix margin-bottom-20">
            <div class="checkbox primary"><input type="checkbox" id="accept"><label for="accept">I accept Terms and Conditions</label></div>
            <!-- /.checkbox -->
        </div> --}}
        <!-- /.clearfix -->
        <button type="submit" class="frm-submit">Register<i class="fa fa-arrow-circle-right"></i></button>
        {{-- <div class="row small-spacing">
            <div class="col-sm-12">
                <div class="txt-login-with txt-center">or register with</div>
                <!-- /.txt-login-with -->
            </div>
            <!-- /.col-sm-12 -->
            <div class="col-sm-6"><button type="button" class="btn btn-sm btn-icon btn-icon-left btn-social-with-text btn-facebook text-white waves-effect waves-light"><i class="ico fa fa-facebook"></i><span>Facebook</span></button></div>
            <!-- /.col-sm-6 -->
            <div class="col-sm-6"><button type="button" class="btn btn-sm btn-icon btn-icon-left btn-social-with-text btn-google-plus text-white waves-effect waves-light"><i class="ico fa fa-google-plus"></i>Google+</button></div>
            <!-- /.col-sm-6 -->
        </div> --}}
        <!-- /.row -->
        <a href="{{route('loginPage')}}" class="a-link"><i class="fa fa-sign-in"></i>Already have account? Login.</a>
        {{-- <div class="frm-footer">NinjaAdmin © 2016.</div> --}}
        <!-- /.footer -->
    </div>
    <!-- .inside -->
</form>
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