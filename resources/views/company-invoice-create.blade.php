@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Company Invoice</h1>
        <div class="mb-3">
            <p><strong>Invoice Number:</strong> <span id="invoice_number"></span></p>

            <p><strong>Submit Date:</strong> <span id="submit_date"></span></p>
        </div>
        <form id="create-invoice-form">
            @csrf
            <div class="mb-3" style="max-width: 50%">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" required>
            </div>
            <div class="mb-3" style="max-width: 50%">
                <label class="form-label">Delivery Date</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <hr>
            <h3>
                Create Invoice
            </h3>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-warning" id="addInvoice">Add Invoice</button>
            </div>

            <div class="mb-3" id="createInvoice">
                <div class="d-flex justify-content-between gap-4">
                    <div>
                        <label class="form-label">Coil Number</label>
                        <input type="text" class="form-control" name="coil_number[]" required>
                    </div>
                    <div>
                        <label class="form-label">Width</label>
                        <input type="number" class="form-control" name="width[]" required>
                    </div>
                    <div>
                        <label class="form-label">Length</label>
                        <input type="number" class="form-control" name="length[]" required>
                    </div>
                    <div>
                        <label class="form-label">Thickness</label>
                        <input type="number" class="form-control" name="thickness[]" required>
                    </div>
                    <div>
                        <label class="form-label">Weight</label>
                        <input type="number" class="form-control" name="weight[]" required>
                    </div>
                    <div>
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price[]" required>
                    </div>
                </div>
            </div>
            <p class="d-flex justify-content-end me-5"><strong class="pe-5"> Total Amount :</strong> <span
                    id="amount"></span></p>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ url('/') }}" class="btn btn-secondary">Cancel</a>
            <hr>
            <div id="response-message" class="mt-3"></div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#addInvoice').on('click', function() {
                    $('#createInvoice').append(`
                    <div class="d-flex justify-content-between gap-4">
                        <div>
                            <label class="form-label">Coil Number</label>
                            <input type="text" class="form-control" name="coil_number[]" required>
                        </div>
                        <div>
                            <label class="form-label">Width</label>
                            <input type="number" class="form-control" name="width[]" required>
                        </div>
                        <div>
                            <label class="form-label">Length</label>
                            <input type="number" class="form-control" name="length[]" required>
                        </div>
                        <div>
                            <label class="form-label">Thickness</label>
                            <input type="number" class="form-control" name="thickness[]" required>
                        </div>
                        <div>
                            <label class="form-label">Weight</label>
                            <input type="number" class="form-control" name="weight[]" required>
                        </div>
                        <div>
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price[]" required>
                        </div>
                        <button   
                            type="button" 
                            class="btn btn-danger btn-sm" 
                            onclick="$(this).parent().remove();"
                        >
                            Remove
                        </button>
                    </div>
                `);
                });

                $(document).on('input', 'input[name="price[]"]', function() {
                    let totalAmount = 0;
                    $('input[name="price[]"]').each(function() {
                        totalAmount += parseFloat($(this).val()) || 0; 
                    });
                    $('#amount').text(totalAmount);
                });

                $('#create-invoice-form').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('company-invoices.store') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 201) {
                                $('#response-message').html(`
                                <div class="alert alert-success">
                                    ${response.message}
                                </div>
                            `);

                                $('#create-invoice-form')[0].reset();
                            }
                        },
                        error: function(xhr, status, error) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage +=
                                    `<div class="alert alert-danger">${value}</div>`;
                            });
                            $('#response-message').html(errorMessage);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
