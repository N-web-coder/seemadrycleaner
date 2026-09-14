@extends('layouts.admin')

@section('page_title', 'Point of Sale')

@section('content')
<div class="row">
    <!-- Left Pane: Catalog -->
    <div class="col-md-7">
        <div class="card card-primary card-outline shadow-sm h-100">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0"><i class="fas fa-th-large text-primary"></i> Catalog</h3>
                    <select id="category-filter" class="form-select form-select-sm w-auto">
                        <option value="all">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body p-3 bg-light" style="max-height: 70vh; overflow-y: auto;">
                <div class="row g-2" id="product-grid">
                    @forelse($products as $product)
                        <div class="col-sm-4 col-6 product-card" data-category="{{ $product->category_id }}">
                            <div class="card h-100 border-0 shadow-sm custom-hover" 
                                 onclick="openOptionsModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->base_price }}, {{ json_encode($product->options) }})">
                                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                                    <h6 class="mb-1 text-bold">{{ $product->name }}</h6>
                                    <span class="text-success fw-bold">₹{{ number_format($product->base_price, 2) }}</span>
                                    @if($product->options->count() > 0)
                                        <small class="text-muted d-block mt-2"><i class="fas fa-list-ul"></i> {{ $product->options->count() }} Options</small>
                                    @else
                                        <small class="text-muted d-block mt-2">Standard</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-4">No products available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Pane: Cart -->
    <div class="col-md-5">
        <div class="card card-success card-outline shadow-sm h-100 d-flex flex-column">
            <div class="card-header bg-white">
                <h3 class="card-title m-0"><i class="fas fa-shopping-cart text-success"></i> Current Order</h3>
            </div>
            
            <!-- Cart Items -->
            <div class="card-body p-0 flex-grow-1" style="max-height: 40vh; overflow-y: auto;">
                <table class="table table-striped table-hover mb-0" id="cart-table">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Item</th>
                            <th class="text-center" style="width: 80px;">Qty</th>
                            <th class="text-end" style="width: 100px;">Price</th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <tr><td colspan="4" class="text-center text-muted py-3">Cart is empty</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Cart Summary & Actions -->
            <div class="card-footer bg-light border-top">
                
                <div class="row mb-2 g-2">
                    <div class="col-6">
                        <label for="store-select" class="form-label small mb-1 text-muted text-bold">Store</label>
                        <select id="store-select" class="form-select form-select-sm" required>
                            @foreach($stores as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="order-type" class="form-label small mb-1 text-muted text-bold">Order Type</label>
                        <select id="order-type" class="form-select form-select-sm" required>
                            <option value="instore">In-Store Walkin</option>
                            <option value="phone">Phone Order</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-sm mb-1">
                    <input type="text" id="customer-phone" class="form-control" placeholder="Customer Phone (Optional)">
                    <button class="btn btn-outline-secondary" type="button" onclick="findCustomer()"><i class="fas fa-search"></i> Find</button>
                </div>
                <div id="customer-name-wrapper" class="mb-1 d-none">
                    <input type="text" id="customer-name" class="form-control form-control-sm" placeholder="Enter Customer Name">
                </div>
                <div id="customer-info" class="small text-muted mb-3 d-none"></div>

                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Sub Total:</span>
                    <strong id="summary-subtotal">₹0.00</strong>
                </div>

                <label for="coupon-code" class="form-label small mb-1 text-muted text-bold">Coupon Code</label>
                <div class="input-group input-group-sm mb-2">
                    <input type="text" id="coupon-code" class="form-control" placeholder="Enter Coupon Code">
                    <button class="btn btn-primary" type="button" onclick="applyCoupon()"><i class="fas fa-check"></i> Apply</button>
                </div>
                
                <div class="d-flex justify-content-between mb-2 text-danger d-none" id="discount-row">
                    <span>Discount (<span id="discount-label"></span>):</span>
                    <strong>- <span id="summary-discount">₹0.00</span></strong>
                </div>

                <hr class="my-2">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mb-0">Total:</h4>
                    <h4 class="mb-0 text-success fw-bold" id="summary-total">₹0.00</h4>
                </div>

                <button class="btn btn-success btn-lg w-100 fw-bold shadow-sm" onclick="placeOrder()"><i class="fas fa-check-circle"></i> PLACE ORDER</button>
            </div>
        </div>
    </div>
</div>

<!-- Product Options Modal -->
<div class="modal fade" id="optionsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="modalProductName">Select Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="modalProductId">
        <input type="hidden" id="modalBasePrice">
        
        <div class="mb-3">
            <label class="form-label text-muted fw-bold">Variations / Addons</label>
            <select id="modalOptionSelect" class="form-select form-select-lg">
                <!-- injected by JS -->
            </select>
        </div>
        
        <div class="row g-3">
            <div class="col-6">
                <label class="form-label text-muted fw-bold">Quantity</label>
                <div class="input-group">
                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                    <input type="number" id="modalQty" class="form-control text-center fw-bold" value="1" min="1">
                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                </div>
            </div>
            <div class="col-6">
                <label class="form-label text-muted fw-bold">Calculated Price</label>
                <input type="text" id="modalCalcPrice" class="form-control text-end fw-bold text-success" readonly>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label text-muted fw-bold">Remarks (Optional)</label>
            <input type="text" id="modalRemarks" class="form-control" placeholder="e.g. Tough stains, Extra care">
        </div>

      </div>
      <div class="modal-footer bg-light border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary px-4 fw-bold" onclick="addToCart()"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </div>
    </div>
  </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow text-dark">
      <div class="modal-header bg-white border-bottom-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
      </div>
      <div class="modal-body p-4 pt-0" id="receiptContent" style="min-height: 300px;">
          <!-- Receipt content injected by JS -->
      </div>
      <div class="modal-footer bg-light border-0">
        <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal" onclick="location.reload()">Finish</button>
        <button type="button" class="btn btn-primary px-4 fw-bold" onclick="printReceipt()"><i class="fas fa-print"></i> Print Receipt</button>
      </div>
    </div>
  </div>
</div>

<style>
    .custom-hover { cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
    .custom-hover:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; border: 1px solid #007bff !important; }
</style>

<script>
    let cart = [];
    let currentCoupon = null;
    let modalOptionsData = [];

    // Filter Logic
    document.getElementById('category-filter').addEventListener('change', function(e) {
        let catId = e.target.value;
        document.querySelectorAll('.product-card').forEach(el => {
            if(catId === 'all' || el.getAttribute('data-category') === catId) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        });
    });

    function openOptionsModal(id, name, basePrice, options) {
        document.getElementById('modalProductId').value = id;
        document.getElementById('modalProductName').innerText = name;
        document.getElementById('modalBasePrice').value = basePrice;
        document.getElementById('modalQty').value = 1;
        document.getElementById('modalRemarks').value = '';
        
        modalOptionsData = options;
        
        let select = document.getElementById('modalOptionSelect');
        select.innerHTML = '<option value="">Standard (₹' + basePrice.toFixed(2) + ')</option>';
        options.forEach(opt => {
            select.innerHTML += `<option value="${opt.id}" data-price="${opt.price}">${opt.name} (+₹${parseFloat(opt.price).toFixed(2)})</option>`;
        });

        updateModalPrice();
        select.onchange = updateModalPrice;

        var myModal = new bootstrap.Modal(document.getElementById('optionsModal'));
        myModal.show();
    }

    function changeQty(amt) {
        let qty = parseInt(document.getElementById('modalQty').value) || 1;
        qty += amt;
        if(qty < 1) qty = 1;
        document.getElementById('modalQty').value = qty;
        updateModalPrice();
    }

    function updateModalPrice() {
        let basePrice = parseFloat(document.getElementById('modalBasePrice').value);
        let qty = parseInt(document.getElementById('modalQty').value) || 1;
        
        let select = document.getElementById('modalOptionSelect');
        let extraPrice = 0;
        if(select.selectedIndex > 0) {
           extraPrice = parseFloat(select.options[select.selectedIndex].getAttribute('data-price'));
        }
        
        let total = (basePrice + extraPrice) * qty;
        document.getElementById('modalCalcPrice').value = '₹' + total.toFixed(2);
    }

    function addToCart() {
        let pId = document.getElementById('modalProductId').value;
        let pName = document.getElementById('modalProductName').innerText;
        let basePrice = parseFloat(document.getElementById('modalBasePrice').value);
        let qty = parseInt(document.getElementById('modalQty').value);
        let remarks = document.getElementById('modalRemarks').value;
        
        let select = document.getElementById('modalOptionSelect');
        let optId = select.value;
        let optName = optId ? select.options[select.selectedIndex].text.split(' (+')[0] : '';
        let optPrice = optId ? parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) : 0;

        let unitPrice = basePrice + optPrice;

        // Check if identical item exists strictly (same product and option and remarks)
        let existing = cart.find(i => i.pId === pId && i.optId === optId && i.remarks === remarks);
        if(existing) {
            existing.qty += qty;
        } else {
            cart.push({
                cartId: Date.now(),
                pId, pName, optId, optName, unitPrice, qty, remarks
            });
        }
        
        var modal = bootstrap.Modal.getInstance(document.getElementById('optionsModal'));
        modal.hide();

        renderCart();
    }

    function removeCartItem(cartId) {
        cart = cart.filter(i => i.cartId !== cartId);
        // Reset coupon if cart becomes empty or recalculation fails later
        if(cart.length === 0) currentCoupon = null;
        renderCart();
    }

    function renderCart() {
        let tbody = document.getElementById('cart-items');
        tbody.innerHTML = '';
        
        let subtotal = 0;
        
        if(cart.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Cart is empty</td></tr>';
        } else {
            cart.forEach(item => {
                let total = item.qty * item.unitPrice;
                subtotal += total;
                
                let desc = `<div class="fw-bold">${item.pName}</div>`;
                if(item.optName) desc += `<small class="text-muted d-block"><i class="fas fa-caret-right"></i> ${item.optName}</small>`;
                if(item.remarks) desc += `<small class="text-info d-block fst-italic">Note: ${item.remarks}</small>`;

                tbody.innerHTML += `
                    <tr>
                        <td>${desc}</td>
                        <td class="text-center align-middle fw-bold">${item.qty}</td>
                        <td class="text-end align-middle">₹${total.toFixed(2)}</td>
                        <td class="align-middle text-center">
                            <button class="btn btn-sm text-danger" onclick="removeCartItem(${item.cartId})"><i class="fas fa-times-circle"></i></button>
                        </td>
                    </tr>
                `;
            });
        }

        document.getElementById('summary-subtotal').innerText = '₹' + subtotal.toFixed(2);
        
        // Re-validate coupon quietly if exists
        if(currentCoupon && subtotal > 0) {
            recalculateCoupon(subtotal);
        } else {
            document.getElementById('discount-row').classList.add('d-none');
            document.getElementById('summary-total').innerText = '₹' + subtotal.toFixed(2);
        }
    }

    function findCustomer() {
        let phone = document.getElementById('customer-phone').value;
        if(!phone) return alert("Enter phone number");
        
        fetch("{{ route('admin.pos.find-customer') }}?phone=" + encodeURIComponent(phone))
        .then(res => res.json())
        .then(data => {
            let infoDiv = document.getElementById('customer-info');
            let nameWrapper = document.getElementById('customer-name-wrapper');
            if(data.error) {
                infoDiv.innerHTML = `<span class="text-danger">${data.error}. Enter name below to create new customer.</span>`;
                infoDiv.classList.remove('d-none');
                nameWrapper.classList.remove('d-none');
            } else {
                infoDiv.innerHTML = `<span class="text-success"><i class="fas fa-user-check"></i> Found: ${data.name} (${data.email})</span>`;
                infoDiv.classList.remove('d-none');
                nameWrapper.classList.add('d-none');
                document.getElementById('customer-name').value = '';
            }
        });
    }

    function applyCoupon() {
        let code = document.getElementById('coupon-code').value;
        if(!code) return alert('Enter coupon code');
        
        let subtotal = cart.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
        if(subtotal === 0) return alert('Cart is empty');

        fetch("{{ route('admin.pos.validate-coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code, sub_total: subtotal })
        })
        .then(res => res.json())
        .then(data => {
            if(data.error) {
                alert(data.error);
                currentCoupon = null;
                renderCart();
            } else {
                currentCoupon = data;
                renderCart();
            }
        });
    }

    function recalculateCoupon(subtotal) {
        fetch("{{ route('admin.pos.validate-coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: currentCoupon.code, sub_total: subtotal })
        })
        .then(res => res.json())
        .then(data => {
            if(data.error) {
                // Criteria no longer met (e.g. removed items)
                currentCoupon = null;
                document.getElementById('discount-row').classList.add('d-none');
                document.getElementById('summary-total').innerText = '₹' + subtotal.toFixed(2);
                document.getElementById('coupon-code').value = '';
                alert("Coupon removed: " + data.error);
            } else {
                currentCoupon = data;
                document.getElementById('discount-label').innerText = data.label;
                document.getElementById('summary-discount').innerText = '₹' + parseFloat(data.discount_amount).toFixed(2);
                document.getElementById('discount-row').classList.remove('d-none');
                
                let grandTotal = subtotal - parseFloat(data.discount_amount);
                document.getElementById('summary-total').innerText = '₹' + grandTotal.toFixed(2);
            }
        });
    }

    function placeOrder() {
        if(cart.length === 0) return alert('Cart is empty!');
        
        let payload = {
            store_id: document.getElementById('store-select').value,
            order_type: document.getElementById('order-type').value,
            customer_phone: document.getElementById('customer-phone').value,
            customer_name: document.getElementById('customer-name').value,
            coupon_id: currentCoupon ? currentCoupon.coupon_id : null,
            items: cart
        };

        const subtotal = cart.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
        const discount = currentCoupon ? parseFloat(currentCoupon.discount_amount) : 0;
        const total = subtotal - discount;

        fetch("{{ route('admin.pos.store-order') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.error) {
                alert("Error: " + data.error);
            } else {
                fetch(`/admin/orders/` + data.order_id + `/receipt`)
                .then(r => r.text())
                .then(html => {
                    showReceipt(html);
                });

                // Flush cart
                cart = [];
                currentCoupon = null;
                document.getElementById('coupon-code').value = '';
                document.getElementById('customer-phone').value = '';
                document.getElementById('customer-name').value = '';
                document.getElementById('customer-name-wrapper').classList.add('d-none');
                document.getElementById('customer-info').classList.add('d-none');
                renderCart();
            }
        }).catch(err => {
            console.error('Failed to submit order', err);
        });
    }

    function showReceipt(html) {
        document.getElementById('receiptContent').innerHTML = html;
        var rModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        rModal.show();
    }

    function printReceipt() {
        let content = document.getElementById('printableReceipt').innerHTML;
        let printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>body{margin:20px;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }
</script>
@endsection
