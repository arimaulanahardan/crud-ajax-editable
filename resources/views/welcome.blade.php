@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Company Invoices</h1>

    <!-- Add Invoice Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('company-invoices.create') }}" class="btn btn-primary">Add Invoice</a>
    </div>

    <!-- User Invoice Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Company Name</th>
                <th>Delivery Date</th>
                <th>Submit Date</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="invoiceTableBody">
            {{-- data here with ajax --}}
        </tbody>
    </table>
    {{-- end User Invoice table --}}

</div>

@push('scripts')
<script>
    // Fetch All Data Company Invoice
    $(document).ready(function () {

        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // API base URL for company-invoice
        const baseUrl = '/company-invoices'; 

        // Function to fetch all company-invoices
        function fetchInvoices() {
            $.ajax({
                url: baseUrl,
                method: 'GET',
                success: function (response) {
                    if (response.status === 200) {
                        renderTable(response.companyInvoices); 
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        }

        // Function to render table rows
        function renderTable(data) {
            let rows = '';
            if (data.length > 0) {
                data.forEach(item => {
                    rows += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.invoice_number}</td>
                            <td>${item.company_name}</td>
                            <td>${item.delivery_date}</td>
                            <td>${item.submit_date}</td>
                            <td>${item.amount}</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUserInvoice(${item.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rows = `<tr><td colspan="7" class="text-center">No data available</td></tr>`;
            }
            $('#invoiceTableBody').html(rows);
        }

        // Function to delete company invoice
        window.deleteUserInvoice = function (id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                $.ajax({
                    url: `${baseUrl}/${id}`,
                    method: 'DELETE',
                    success: function (response) {
                        if (response.status === 200) {
                            fetchInvoices();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error deleting invoice:', xhr.responseText);
                    }
                });
            }
        }

        fetchInvoices();
    });
    // end fecth All Data company Invoice
</script>
@endpush
@endsection
