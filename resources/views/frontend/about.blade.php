@extends('layouts.app')

@section('meta_title', 'Our Story - About ' . config('app.name'))
@section('meta_description', 'Learn about our passion for professional garment care. We combine traditional cleaning values with modern technology.')

@section('content')
<!-- Page Header -->
<section class="section-padding bg-light border-bottom">
    <div class="container text-center">
        <h5 class="text-primary fw-bold text-uppercase ls-1">Company Journey</h5>
        <h1 class="display-4 fw-bold">Preserving Your Wardrobe,<br><span class="text-primary">One Stitch at a Time.</span></h1>
    </div>
</section>

<!-- Content Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="pe-lg-5">
                    <h2 class="fw-bold mb-4">A Legacy of Quality</h2>
                    <p class="text-muted mb-4 lead">Founded with a simple mission: to provide the community with a laundry service that prioritizes quality above all else. We understand that your clothes are an investment and a reflection of your personality.</p>
                    <p class="text-muted mb-5">At {{ config('app.name') }}, we use a combination of time-tested dry cleaning techniques and advanced modern technology. Every garment that enters our facility undergoes a rigorous 5-step inspection process to ensure it returns to you in pristine condition.</p>
                    
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h2 class="fw-bold text-primary mb-0 me-3">15+</h2>
                                <span class="small text-muted fw-bold text-uppercase ls-1">Years of<br>Experience</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <h2 class="fw-bold text-primary mb-0 me-3">10k+</h2>
                                <span class="small text-muted fw-bold text-uppercase ls-1">Happy<br>Customers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('images/site/about.png') }}" alt="Our Team" class="img-fluid rounded-5 shadow-lg">
                    <div class="position-absolute bg-primary p-4 rounded-4 shadow-lg text-white d-none d-md-block" style="bottom: -30px; left: -30px; max-width: 250px;">
                        <i class="fa-solid fa-quote-left mb-3 opacity-50" style="font-size: 2rem;"></i>
                        <p class="mb-0 italic small">"Our focus isn't just on cleaning; it's on giving you back your time and confidence."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="section-padding bg-dark text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="text-primary fw-bold text-uppercase mb-3">Our Core Values</h5>
            <h2 class="fw-bold">The Pillars of {{ config('app.name') }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-5 bg-white bg-opacity-10 rounded-4 border border-secondary shadow-sm text-center">
                    <i class="fas fa-microscope text-info fa-fw mb-4" style="font-size: 3.5rem; font-weight: 900;"></i>
                    <h4 class="fw-bold text-white">Precision</h4>
                    <p class="text-white">We obsess over the details, from complex stain removal to perfect crease alignment.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-5 bg-white bg-opacity-10 rounded-4 border border-secondary shadow-sm text-center">
                    <i class="fas fa-hand-holding-heart text-info fa-fw mb-4" style="font-size: 3.5rem; font-weight: 900;"></i>
                    <h4 class="fw-bold text-white">Care</h4>
                    <p class="text-white">Treating every item as if it were our own, using gentle bionic detergents.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-5 bg-white bg-opacity-10 rounded-4 border border-secondary shadow-sm text-center">
                    <i class="fas fa-bolt text-warning fa-fw mb-4" style="font-size: 3.5rem; font-weight: 900;"></i>
                    <h4 class="fw-bold text-white">Speed</h4>
                    <p class="text-white">Premium service shouldn't take forever. We promise timely turnaround every time.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
