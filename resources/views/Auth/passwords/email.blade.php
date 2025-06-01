@extends('layout.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center">
                <h4>Reset Password</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control no-outline @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .no-outline:focus, .no-outline:active {
        outline: none !important;
        box-shadow: none !important;
        border-color: #ced4da !important;
    }
</style>
@endsection
