@extends('layouts.app')

@section('meta_title', 'Success - We have received your order!')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px; font-size: 3rem;">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="display-5 fw-bold text-dark mb-4">Fantastic choice!</h1>
                <h4 class="text-muted mb-5">Your order <span class="text-primary fw-bold">#{{ $order->order_number }}</span> has been successfully placed and was sent to our team.</h4>
                
                <div class="card border-0 shadow-sm p-4 mb-5 rounded-4 text-start">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">What happens next?</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                            <i class="fas fa-1 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0; font-size: 0.75rem;"></i>
                            <span>Our store manager will review your request.</span>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0; font-size: 0.75rem;"></i>
                            <span>We will coordinate a pickup professional to visit your address.</span>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0; font-size: 0.75rem;"></i>
                            <span>You can track the live status from your personalized dashboard.</span>
                        </li>
                    </ul>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow">Track Live Status</a>
                    <a href="{{ url('/') }}" class="btn btn-outline-dark px-5 py-3 fw-bold rounded-pill">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
