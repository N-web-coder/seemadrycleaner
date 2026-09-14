@extends('layouts.app')

@section('meta_title', $category->name . ' Services - ' . config('app.name'))
@section('meta_description', 'Browe our premium ' . $category->name . ' products. Get the best rates for high-quality laundry care.')

@section('content')
<section class="section-padding bg-light">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-pill shadow-sm d-inline-flex px-4 border">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">Services</a></li>
                <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h1 class="display-5 fw-bold m-0 text-dark">{{ $category->name }}</h1>
                <p class="text-muted mt-2">Discover our specialized care for your {{ strtolower($category->name) }}.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm product-card-hover overflow-hidden">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&q=80&w=600" alt="{{ $product->name }}" class="card-img-top overflow-hidden" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-white text-primary shadow-sm rounded-pill fw-bold px-3">₹{{ number_format($product->base_price, 2) }}</span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold text-dark mb-2">{{ $product->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 70) }}</p>
                            
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary d-block w-100 mt-3 rounded-pill fw-bold shadow-sm">
                                View Options
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white p-5 rounded-4 shadow-sm border border-dashed">
                        <i class="fas fa-box-open display-2 text-muted mb-4"></i>
                        <h3>No products found in this category.</h3>
                        <p class="text-muted">Stay tuned! We're adding new services soon.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3 px-4 rounded-pill">Explore Other Services</a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .product-card-hover {
        transition: all 0.3s ease;
    }
    .product-card-hover:hover {
        transform: scale(1.03);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
