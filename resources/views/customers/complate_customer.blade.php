@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary"><i class="fas fa-users"></i> Customer List</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-user-plus"></i> Add Customer
    </a>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Work Details</th>
                    <th>Total Amount</th>
                    <th>Due Amount</th>
                    <th>Actions</th>    
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td><strong>{{ $customer->id }}</strong></td>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->contact_number }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->work_details }}</td>
                    <td class="text-success fw-bold">₹{{ number_format($customer->total_amount, 2) }}</td>
                    <td class="text-danger fw-bold">₹{{ number_format($customer->due_amount, 2) }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <!-- Edit Button -->
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>

                            <!-- View Payments Button -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentHistoryModal{{ $customer->id }}">
                                <i class="fas fa-history"></i> Payments
                            </button>
                        </div>

                        <!-- Payment History Modal -->
                        <div class="modal fade" id="paymentHistoryModal{{ $customer->id }}" tabindex="-1" aria-labelledby="paymentHistoryLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Payment History - {{ $customer->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Payment Method</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($customer->payments as $payment)
                                                    <tr>
                                                        <td>{{ $payment->payment_date }}</td>
                                                        <td>{{ $payment->payment_method }}</td>
                                                        <td>₹{{ number_format($payment->received_amount, 2) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @if($customer->payments->isEmpty())
                                            <p class="text-center text-muted">No payment history available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Payment History Modal -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap & FontAwesome Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
