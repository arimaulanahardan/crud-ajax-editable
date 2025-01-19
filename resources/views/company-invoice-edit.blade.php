@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4"> Detail Invoice</h1>
       
        <div>
            <h2>Company Invoice</h2>
            <p><strong class="me-4">Invoice Number :</strong> {{ $companyInvoices->invoice_number }}</p>
            <p><strong class="me-4">Company Name :</strong> {{ $companyInvoices->company_name }}</p>
            <p><strong class="me-5">Delivery Date :</strong> {{ $companyInvoices->delivery_date }}</p>
            <p><strong class="me-5">Submit Date :</strong> {{ $companyInvoices->submit_date }}</p>

        </div>

        <h2 class="mt-4">Invoices</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Coil Number</th>
                    <th>Width</th>
                    <th>Length</th>
                    <th>Thickness</th>
                    <th>Weight</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->coil_number }}</td>
                        <td>{{ number_format($invoice->width, 2, '.', ',') }}</td> 
                        <td>{{ number_format($invoice->length, 2, '.', ',') }}</td> 
                        <td>{{ number_format($invoice->thickness, 2, '.', ',') }}</td>
                        <td>{{ number_format($invoice->weight, 2, '.', ',') }}</td> 
                        <td>{{ number_format($invoice->price, 2, '.', ',') }}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="me-5">
            <p class="text-end pe-5"><strong class="me-5">Total Amount :</strong> {{ number_format($companyInvoices->amount, 2, '.', ',') }}</p>
        </div>
        <div class="d-flex justify-content-end mb-3">
             <a href="{{ url('/') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    @push('scripts')
        <script></script>
    @endpush
@endsection
