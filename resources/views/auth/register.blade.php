@extends('layouts.app')

@section('meta_title', 'Join ' . config('app.name') . ' - Smart Laundry Solutions')

@section('content')
<section class="section-padding bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-dark">Create Account</h2>
                            <p class="text-muted">Start your journey to effortless laundry care.</p>
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

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-600">Full Name</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-3" placeholder="John Doe" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600">Email Address</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-3" placeholder="john@example.com" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600">Phone Number</label>
                                    <input type="text" name="phone" class="form-control bg-light border-0 py-3" placeholder="+91..." value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600">Password</label>
                                    <input type="password" name="password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-block w-100 py-3 fw-bold rounded-pill shadow-sm mb-4">
                                Create My Account <i class="fas fa-user-plus ms-2"></i>
                            </button>

                            <div class="text-center">
                                <p class="text-muted small mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Sign In Instead</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
