@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Company Invoices</h1>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('company-invoices.create') }}" class="btn btn-primary">Add Invoice</a>
        </div>

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
            </tbody>
        </table>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const baseUrl = '/company-invoices';

                function fetchInvoices() {
                    $.ajax({
                        url: baseUrl,
                        method: 'GET',
                        success: function(response) {
                            if (response.status === 200) {
                                renderTable(response.companyInvoices);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching data:', xhr.responseText);
                        }
                    });
                }

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
                            <td>${formatNumber(item.amount)}</td>
                            
                            <td>
                                <a href="${baseUrl}/${item.id}" class="btn btn-secondary btn-sm">Show</a>
                                <a href="${baseUrl}/${item.id}/edit" class="btn btn-warning btn-sm">Edit</a>
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

                function formatNumber(num) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(".", ",");
                } 

                window.deleteUserInvoice = function(id) {
                    if (confirm('Are you sure you want to delete this invoice?')) {
                        $.ajax({
                            url: `${baseUrl}/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                if (response.status === 200) {
                                    fetchInvoices();
                                }
                            },
                            error: function(xhr) {
                                console.error('Error deleting invoice:', xhr.responseText);
                            }
                        });
                    }
                }

                fetchInvoices();
            });
        </script>
    @endpush
@endsection
