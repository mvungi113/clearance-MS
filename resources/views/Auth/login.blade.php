@extends('layout.app')

@section('content')
<style>
    .form-control:focus {
        box-shadow: none !important;
        border-color: #86b7fe;
    }
</style>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center">
                <h4>Student Login</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <span>Don't have an account? <a href="{{ route('register') }}">Create new</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection