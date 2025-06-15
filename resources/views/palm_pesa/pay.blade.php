@extends('layout.student')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-mobile-alt me-2"></i>
                        Student Payment Portal
                    </h3>
                    <p class="mb-0 mt-2 opacity-75">Pay securely via Mobile Money/USSD</p>
                </div>
                
                <div class="card-body p-4">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Payment Form -->
                    <form method="POST" action="/palm-pesa/pay-via-mobile" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Phone Number Field -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                Phone Number
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">+255</span>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="phone" 
                                       name="phone" 
                                       placeholder="7XXXXXXXX" 
                                       pattern="[0-9]{9,10}"
                                       value="{{ old('phone') }}"
                                       required>
                                <div class="invalid-feedback">
                                    Please enter a valid phone number.
                                </div>
                            </div>
                            <small class="text-muted">Enter your mobile money number (e.g., 744123456)</small>
                        </div>

                        <!-- Amount Field -->
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                Amount (TSh)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">TSh</span>
                                <input type="number" 
                                       class="form-control form-control-lg" 
                                       id="amount" 
                                       name="amount" 
                                       placeholder="200"
                                       min="200" 
                                       step="1"
                                       value="{{ old('amount') }}"
                                       required>
                                <div class="invalid-feedback">
                                    Minimum amount is 200 TSh.
                                </div>
                            </div>
                            <small class="text-muted">Minimum payment: 200 TSh</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-credit-card me-2"></i>
                                Pay via Mobile Money
                            </button>
                        </div>
                    </form>

                    <!-- Payment Info -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-info-circle me-2"></i>
                            How it works:
                        </h6>
                        <ul class="small text-muted mb-0">
                            <li>Enter your mobile money number and amount</li>
                            <li>You'll receive a USSD prompt on your phone</li>
                            <li>Enter your PIN to complete the payment</li>
                            <li>Payment confirmation will be sent via SMS</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-footer text-center text-muted py-3">
                    <small>
                        <i class="fas fa-shield-alt me-1"></i>
                        Secure payment powered by Palm Pesa
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control-lg {
    border-radius: 10px;
}

.btn-lg {
    border-radius: 10px;
    font-weight: 600;
}

.input-group-text {
    border-radius: 10px 0 0 10px;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 10px 10px 0;
}

.input-group .form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

.alert {
    border-radius: 10px;
}
</style>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endsection