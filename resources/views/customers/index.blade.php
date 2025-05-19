@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@section('content')

<div class="">
    <h2 class="mb-4 text-primary"><i class="fas fa-users"></i> Customer List</h2>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="start_date" class="form-label fw-bold">Start Date:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label fw-bold">End Date:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button id="filterBtn" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Apply Filter</button>
        </div>
    </div>
    {{-- <div class="alert alert-info">
        <h5><strong>Total Amount:</strong> ₹{{ number_format($totalAmountSum, 2) }}</h5>
        <h5><strong>Total Due Amount:</strong> ₹{{ number_format($dueAmountSum, 2) }}</h5>
    </div> --}}
    <a href="{{ route('customers.create') }}" class="btn btn-success mb-3"><i class="fas fa-user-plus"></i> Add Customer</a>

    <table class="table  table-hover table-border table-striped" id="yourDataTableId">
        <thead class="table-dark mt-1" >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Work Details</th>
                <th>Total Amount</th>
                <th>Due Amount</th>
                <th>Start Date</th>
                <th>Actions</th>    
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>{{-- Serial Number --}}
                <td><strong>{{ $customer->name }}</strong></td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->contact_number }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->work_details }}</td>
                <td class="text-success fw-bold">₹{{ number_format($customer->total_amount, 2) }}</td>
                <td class="text-danger fw-bold">₹{{ number_format($customer->due_amount, 2) }}</td>
                <td class="created_at">{{ \Carbon\Carbon::parse($customer->created_at)->format('Y-m-d') }}</td> <!-- Format Date -->
                <td>
                    <!-- Edit Button -->
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                    <!-- View Payments Button -->
                    <button type="button" class="btn btn-info btn-sm m-1" data-bs-toggle="modal" data-bs-target="#paymentHistoryModal{{ $customer->id }}">
                        <i class="fas fa-history"></i> View Payments
                    </button>

                    <!-- Button to Open Update Payment Modal -->
                    <button type="button" class="btn btn-primary btn-sm m-1" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $customer->id }}">
                        <i class="fas fa-money-bill-wave"></i> Update Payment
                    </button>

                    <!-- Payment History Modal -->
                    <div class="modal fade" id="paymentHistoryModal{{ $customer->id }}" tabindex="-1" aria-labelledby="paymentHistoryLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Payment History - {{ $customer->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered" >
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

                                    @if($customer->payments->isEmpty())
                                        <p class="text-center text-muted">No payment history available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Payment History Modal -->

                    <!-- Update Payment Modal -->
                    <div class="modal fade" id="paymentModal{{ $customer->id }}" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel">Update Payment - {{ $customer->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('customers.updatePayment', $customer->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="received_amount" class="form-label">Received Amount</label>
                                            <input type="number" name="received_amount" class="form-control" placeholder="Enter amount" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="payment_method" class="form-label">Transaction ID / Cheque No.</label>
                                            <input type="text" name="payment_method" class="form-control" placeholder="Enter Transaction ID / Reference">
                                        </div>

                                        <div class="mb-3">
                                            <label for="payment_date" class="form-label">Payment Date</label>
                                            <input type="date" name="payment_date" class="form-control" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Submit Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Update Payment Modal -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
    $totalSum = 0;
    $totalDueSum = 0;
@endphp

@foreach($customers as $customer)
    @php
        $totalSum += $customer->total_amount;
        $totalDueSum += $customer->due_amount;
    @endphp
@endforeach

<div class="row mt-1">
    <div class="col-md-6">
        <div class="alert alert-success text-center fw-bold">
            <h5><i class="fas fa-wallet"></i> Total Amount</h5>
            <h3 class="text-success" id="totalAmountDisplay">₹{{ number_format($totalSum, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-danger text-center fw-bold">
            <h5><i class="fas fa-exclamation-triangle"></i> Total Due Amount</h5>
            <h3 class="text-danger" id="totalDueAmountDisplay">₹{{ number_format($totalDueSum, 2) }}</h3>
        </div>
    </div>
</div>

</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- DataTables Export Buttons -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


{{-- <script>
    $(document).ready(function () {
        $('#yourDataTableId').DataTable({
            "responsive": true,
            "dom": 'Bfrtip', // Buttons enable
            "buttons": [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: { columns: ':not(:last-child)' } // Last column (Actions) hide
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-primary btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                }
            ]
        });
    });
</script> --}}

<script>
    $(document).ready(function () {
        var table = $('#yourDataTableId').DataTable({
            "responsive": true,
            "lengthMenu": [[10, 25, 50, -1], ["All", 10, 25, 50]],
            "dom": 'lBfrtip',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-primary btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                }
            ]
        });
    
        // Custom Date Filter for Created At
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var createdAt = data[8].trim(); // Ensure this is the correct index for created_at column
    
            if (startDate === '' && endDate === '') {
                return true;
            }
    
            if (createdAt) {
                var createdAtObj = new Date(createdAt);
                var startDateObj = startDate ? new Date(startDate) : null;
                var endDateObj = endDate ? new Date(endDate) : null;
    
                if ((startDateObj === null || createdAtObj >= startDateObj) &&
                    (endDateObj === null || createdAtObj <= endDateObj)) {
                    return true;
                }
            }
            return false;
        });
    
        function updateTotalAmount() {
            var totalAmount = 0;
            var totalDueAmount = 0;
    
            table.rows({ search: 'applied' }).every(function () {
                var rowData = this.data();
                totalAmount += parseFloat(rowData[6].replace('₹', '').replace(',', '')) || 0;
                totalDueAmount += parseFloat(rowData[7].replace('₹', '').replace(',', '')) || 0;
            });
    
            $('#totalAmountDisplay').text('₹' + totalAmount.toFixed(2));
            $('#totalDueAmountDisplay').text('₹' + totalDueAmount.toFixed(2));
        }
    
        // Filter button click event
        $('#filterBtn').on('click', function () {
            table.draw();
            updateTotalAmount();
        });
    });
    </script>
    




@endsection
