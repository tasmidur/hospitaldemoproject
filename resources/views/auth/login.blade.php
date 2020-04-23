@extends('layouts.signin')

@section('content')
<style>
.card {
background:rgba(0,0,40);
min-height: 50px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
position: relative;
margin-bottom: 30px;
text-align: .9;
-moz-border-radius: 2px;
-ms-border-radius: 2px;
border-radius: 2px;
opacity: .9;
color:#fff;
}
.input-group .input-group-addon .material-icons{
    color:#fff;
}

.login-page .login-box .msg {
color: #fff;
margin-bottom: 30px;
text-align: center;
}
#signinbtn{
    margin-left: 117px;
    margin-right: 80px;

}
.card .body {
    font-size: 14px;
    color: 
    #555;
}
strong{
    color: red;
}
</style>
 <div class="login-box">
        <div class="logo">
        {{-- <a href="javascript:void(0);"><img src="{{url('image_icon/logo.png')}}" style="width:232px;height:31px;"></a>
            <small>Admin Panel</small> --}}
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="{{ route('login') }}">
                     @csrf
                    <div class="msg"><img src="{{url('image_icon/logo.png')}}" style="width:232px;height:31px;"></a></div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            
                        </div>
                    </div>
                     <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                           
                        </div>
                    </div>


                    <div class="row text-center">
                        {{-- <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div> --}}
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        <script></script>
                        @enderror
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <br>
                        <div class="col-xs-4 text-center">
                            <button class="btn btn-block bg-pink waves-effect" id="signinbtn" type="submit">SIGN IN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
