@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Company Invoices</h1>

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
    // Fetch All Data User Invoice
    $(document).ready(function () {
        const baseUrl = '/company-invoices'; 

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
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rows = `<tr><td colspan="7" class="text-center">No data available</td></tr>`;
            }
            $('#invoiceTableBody').html(rows);
        }

        fetchInvoices();
    });
    // end fecth All Data user Invoice
</script>
@endpush
@endsection
