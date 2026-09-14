@extends('layouts.app')

@section('meta_title', 'Your Basket - ' . config('app.name'))

@section('content')
<section class="section-padding bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold mb-5 text-dark">Your Service Basket</h1>

        @if(count($cart) > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom">
                                    <tr class="text-muted small fw-bold">
                                        <th colspan="2">SERVICE ITEM</th>
                                        <th class="text-center">PRICE</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">SUBTOTAL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr class="border-bottom" data-id="{{ $id }}">
                                            <td style="width: 80px;">
                                                <img src="{{ $item['image'] }}" class="img-fluid rounded-3" alt="{{ $item['name'] }}">
                                            </td>
                                            <td>
                                                <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                                @if($item['option_name'])
                                                    <span class="badge bg-primary-subtle text-primary small">{{ $item['option_name'] }}</span>
                                                @endif
                                                @if($item['remarks'])
                                                    <div class="mt-1 small text-muted italic">Note: {{ $item['remarks'] }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">₹{{ number_format($item['price'], 2) }}</td>
                                            <td class="text-center" style="width: 140px;">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary border update-cart" data-change="-1"><i class="fas fa-minus"></i></button>
                                                    <input type="number" class="form-control text-center cart-qty-input" value="{{ $item['quantity'] }}" min="1" readonly>
                                                    <button class="btn btn-outline-secondary border update-cart" data-change="1"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-danger border-0 remove-from-cart"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-link text-decoration-none text-primary fw-bold p-0">
                                <i class="fas fa-arrow-left me-2"></i> Add more services
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 100px;">
                        <h4 class="fw-bold mb-4">Summary</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Items</span>
                            <span class="fw-bold">{{ count($cart) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Estimated Subtotal</span>
                            <span class="fw-bold h5 mb-0">₹{{ number_format($total, 2) }}</span>
                        </div>
                        <hr>
                        <p class="small text-muted mb-4"><i class="fas fa-info-circle me-1"></i> Taxes and delivery fees (if any) will be calculated at checkout.</p>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary d-block w-100 py-3 fw-bold rounded-pill shadow-sm">
                            Proceed to Checkout <i class="fas fa-credit-card ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm border border-dashed">
                    <i class="fas fa-shopping-basket display-1 text-muted mb-4 opacity-25"></i>
                    <h2 class="fw-bold">Your basket is empty</h2>
                    <p class="text-muted lead mb-4">Looks like you haven't added any services yet. Let's freshen up your wardrobe!</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary px-5 py-3 fw-bold rounded-pill shadow">Explore Services</a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    $('.update-cart').on('click', function() {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let currentQty = parseInt(row.find('.cart-qty-input').val());
        let change = parseInt($(this).data('change'));
        let newQty = currentQty + change;

        if (newQty < 1) return;

        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                quantity: newQty
            },
            success: function(response) {
                location.reload();
            }
        });
    });

    $('.remove-from-cart').on('click', function() {
        if (!confirm('Remove this service from basket?')) return;
        
        let id = $(this).closest('tr').data('id');

        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                location.reload();
            }
        });
    });
</script>
@endpush
