@extends('layouts.app')

@section('content')
<div class="login-page">

    <div class="left-side">

        <div class="logo">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>সাজ-পাৰ</span>
        </div>

        <h1>
            Shop Smart.<br>
            <span>Live Beautiful.</span>
        </h1>

        <p class="subtitle">
            Your favorite products,<br>
            just a click away.
        </p>

        <div class="feature">
            <i class="fa-solid fa-tag"></i>
            <div>
                <h5>Top Quality Products</h5>
                <small>Handpicked just for you</small>
            </div>
        </div>

        <div class="feature">
            <i class="fa-solid fa-lock"></i>
            <div>
                <h5>Secure Shopping</h5>
                <small>100% Safe & Trusted</small>
            </div>
        </div>

        <div class="feature">
            <i class="fa-solid fa-truck"></i>
            <div>
                <h5>Fast Delivery</h5>
                <small>At your doorstep</small>
            </div>
        </div>

        <div class="shopping-img">
            <img src="{{ asset('assets/img/shopping-bag.png') }}" alt="">
        </div>

    </div>

    <div class="right-side">

        <div class="login-card">

            <div class="icon-box">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>

            <h2>Welcome Back! 👋</h2>
            <p>Login to continue shopping</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email Address</label>

                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        required>

                    @error('email')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required>

                    @error('password')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mb-4">

                    <div>
                        <input type="checkbox"
                               name="remember"
                               id="remember">

                        <label for="remember">
                            Remember me
                        </label>
                    </div>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif

                </div>

                <button class="btn login-btn w-100">
                    Login
                </button>

            </form>

            <div class="signup">
                Don't have an account?
                <a href="{{ route('register') }}">
                    Sign Up →
                </a>
            </div>

        </div>

    </div>

</div>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f7f5ff;
    font-family:'Poppins',sans-serif;
}

.login-page{
    min-height:100vh;
    display:flex;
    background:#f7f5ff;
}

/* LEFT SECTION */

.left-side{
    width:55%;
    padding:60px;
    background:#f5f2ff;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:30px;
    font-weight:700;
}

.logo i{
    color:#7c3aed;
}

.left-side h1{
    margin-top:60px;
    font-size:70px;
    font-weight:800;
    line-height:1.1;
}

.left-side h1 span{
    color:#6d4cff;
}

.subtitle{
    margin-top:25px;
    color:#64748b;
    font-size:22px;
}

.feature{
    display:flex;
    align-items:center;
    gap:15px;
    background:#fff;
    padding:18px;
    border-radius:18px;
    margin-top:18px;
    width:350px;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.feature i{
    width:50px;
    height:50px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    background:#f3eeff;
    color:#7c3aed;
    font-size:20px;
}

.feature h5{
    margin-bottom:3px;
}

.feature small{
    color:#64748b;
}

.shopping-img{
    text-align:center;
    margin-top:40px;
}

.shopping-img img{
    width:400px;
    max-width:100%;
}

/* RIGHT SECTION */

.right-side{
    width:45%;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

.login-card{
    width:100%;
    max-width:550px;
    background:#fff;
    border-radius:30px;
    padding:50px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.icon-box{
    width:80px;
    height:80px;
    border-radius:50%;
    background:#f3eeff;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0 auto 20px;
}

.icon-box i{
    color:#7c3aed;
    font-size:30px;
}

.login-card h2{
    text-align:center;
    font-size:40px;
    margin-bottom:10px;
}

.login-card p{
    text-align:center;
    color:#64748b;
    margin-bottom:30px;
}

.form-control{
    height:55px;
    border-radius:12px;
    margin-top:8px;
}

.login-btn{
    height:55px;
    border:none;
    border-radius:12px;
    background:linear-gradient(
        90deg,
        #8b5cf6,
        #6d28d9
    );
    color:white;
    font-size:18px;
    font-weight:600;
}

.login-btn:hover{
    opacity:.95;
}

.signup{
    text-align:center;
    margin-top:25px;
}

.signup a{
    color:#7c3aed;
    text-decoration:none;
    font-weight:600;
}

.text-danger{
    font-size:14px;
}

/* RESPONSIVE */

@media(max-width:992px){

    .left-side{
        display:none;
    }

    .right-side{
        width:100%;
    }

    .login-card{
        padding:30px;
    }
}
</style>
@endsection
