@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary"><i class="fas fa-user-plus"></i> Add Customer</h2>

    <!-- Back Button -->
    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary mb-3 shadow-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    
    <div class="card shadow-lg border-0 p-4">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <!-- Customer Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Customer Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter customer name" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email (optional)">
                </div>

                <!-- Contact Number -->
                <div class="mb-3">
                    <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="Enter contact number" required>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label fw-bold">Address</label>
                    <textarea name="address" class="form-control" id="address" placeholder="Enter customer address" required></textarea>
                </div>

                <!-- Work Details -->
                <div class="mb-3">
                    <label for="work_details" class="form-label fw-bold">Work Details</label>
                    <textarea name="work_details" class="form-control" id="work_details" placeholder="Enter work details (optional)"></textarea>
                </div>

                <!-- Amount Fields in a Row -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="total_amount" class="form-label fw-bold">Total Amount (₹)</label>
                            <input type="number" name="total_amount" class="form-control" id="total_amount" step="0.01" placeholder="Enter total amount" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="advance" class="form-label fw-bold">Advance Amount (₹)</label>
                            <input type="number" class="form-control" id="advance" step="0.01" placeholder="Enter advance amount">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="due_amount" class="form-label fw-bold">Due Amount (₹)</label>
                            <input type="number" name="due_amount" class="form-control" id="due_amount" step="0.01" readonly required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success w-100 shadow">
                    <i class="fas fa-save"></i> Save Customer
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let totalAmountInput = document.getElementById("total_amount");
        let advanceInput = document.getElementById("advance");
        let dueAmountInput = document.getElementById("due_amount");

        function calculateDueAmount() {
            let totalAmount = parseFloat(totalAmountInput.value) || 0;
            let advanceAmount = parseFloat(advanceInput.value) || 0;
            let dueAmount = totalAmount - advanceAmount;

            dueAmountInput.value = dueAmount.toFixed(2);
        }

        totalAmountInput.addEventListener("input", calculateDueAmount);
        advanceInput.addEventListener("input", calculateDueAmount);
    });
</script>

@endsection
