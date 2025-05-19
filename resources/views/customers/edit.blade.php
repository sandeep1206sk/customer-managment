@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-edit"></i> Edit Customer Details</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ $customer->contact_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" class="form-control" required>{{ $customer->address }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Work Details</label>
                            <textarea name="work_details" class="form-control">{{ $customer->work_details }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Total Amount (₹)</label>
                                    <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ $customer->total_amount }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Due Amount (₹)</label>
                                    <input type="number" step="0.01" name="due_amount" class="form-control" value="{{ $customer->due_amount }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
