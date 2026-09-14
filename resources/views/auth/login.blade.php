@extends('layouts.app')

@section('meta_title', 'Login - Welcome Back to ' . config('app.name'))

@section('content')
    <section class="section-padding bg-light min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-dark">Welcome Back</h2>
                                <p class="text-muted">Sign in to manage your laundry services.</p>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-600">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-3"
                                            placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <label class="form-label fw-600 mb-0">Password</label>
                                        <a href="#" class="small text-decoration-none" tabindex="-1">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control bg-light border-0 py-3"
                                            placeholder="••••••••" required>
                                    </div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Remember me for 30
                                        days</label>
                                </div>

                                <button type="submit"
                                    class="btn btn-primary d-block w-100 py-3 fw-bold rounded-pill shadow-sm mb-4">
                                    Sign In <i class="fas fa-sign-in-alt ms-2"></i>
                                </button>

                                <div class="text-center">
                                    <p class="text-muted small mb-0">Don't have an account? <a
                                            href="{{ route('register') }}" class="fw-bold text-decoration-none">Sign Up
                                            Now</a></p>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="text-muted small text-decoration-none"><i
                                class="fas fa-arrow-left me-1"></i> Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection