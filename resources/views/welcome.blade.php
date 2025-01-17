@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        {{-- Create --}}
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form id="productForm">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Price</label>
                                <input type="number" class="form-control" name="price" id="price">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity">
                            </div>
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" id="submitProduct">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end Create --}}

        {{-- Data Table --}}
        <div class="container">
            <h1>Product List</h1>
            <table class="table" id="productTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                        <tr data-id="{{ $product->id }}">
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->price * $product->quantity }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <button class="btn btn-primary edit-btn" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-description="{{ $product->description }}"
                                    data-price="{{ $product->price }}"
                                    data-quantity="{{ $product->quantity }}">Edit</button>
                                <button class="btn btn-danger delete-btn" data-id="{{ $product->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- End Data Table --}}

        {{-- Modal --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
            data-toggle="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            @csrf
                            <input type="hidden" id="editProductId">
                            <div class="form-group">
                                <label class="font-weight-bold">Name</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" id="editDescription" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Price</label>
                                <input type="number" class="form-control" id="editPrice">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Quantity</label>
                                <input type="number" class="form-control" id="editQuantity">
                            </div>
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" id="updateProduct">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}

    </div>

    <script>
        // Submit button function with AJAX (Create)
        document.getElementById('submitProduct').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('productForm'));

            fetch('{{ route('products.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        document.getElementById('productForm').reset();

                        // Add new row to the table dynamically with the returned product data
                        const productTable = document.getElementById('productTable').querySelector('tbody');
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-id', data.product.id);
                        newRow.innerHTML = `
                    <td>${data.product.name}</td>
                    <td>${data.product.description}</td>
                    <td>${data.product.price}</td>
                    <td>${data.product.quantity}</td>
                    <td>${data.product.price * data.product.quantity}</td>
                    <td>${data.product.updated_at}</td>
                    <td>
                        <button class="btn btn-primary edit-btn" data-id="${data.product.id}" data-name="${data.product.name}" data-description="${data.product.description}" data-price="${data.product.price}" data-quantity="${data.product.quantity}">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="${data.product.id}">Delete</button>
                    </td>`;
                        productTable.appendChild(newRow);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Edit button click function to populate modal fields
        document.querySelector('#productTable tbody').addEventListener('click', function(event) {
            if (event.target.classList.contains('edit-btn')) {
                const button = event.target;
                document.getElementById('editProductId').value = button.getAttribute('data-id');
                document.getElementById('editName').value = button.getAttribute('data-name');
                document.getElementById('editDescription').value = button.getAttribute('data-description');
                document.getElementById('editPrice').value = button.getAttribute('data-price');
                document.getElementById('editQuantity').value = button.getAttribute('data-quantity');

                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            }

            // Delete button function with AJAX
            if (event.target.classList.contains('delete-btn')) {
                const productId = event.target.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this product?')) {
                    fetch(`/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                alert(data.message);
                                // Remove the deleted row from the table
                                const row = event.target.closest('tr');
                                row.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Delete failed: ' + error.message);
                        });
                }
            }
        });

        // Update product function with AJAX
        document.getElementById('updateProduct').addEventListener('click', function() {
            const productId = document.getElementById('editProductId').value;
            const formData = new FormData();
            formData.append('name', document.getElementById('editName').value);
            formData.append('description', document.getElementById('editDescription').value);
            formData.append('price', document.getElementById('editPrice').value);
            formData.append('quantity', document.getElementById('editQuantity').value);

            fetch(`/${productId}`, {
                    method: 'PUT',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update product.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        alert(data.message);

                        // Update the table row dynamically with the new product data
                        const row = document.querySelector(`tr[data-id="${productId}"]`);
                        row.querySelector('td:nth-child(1)').textContent = data.product.name;
                        row.querySelector('td:nth-child(2)').textContent = data.product.description;
                        row.querySelector('td:nth-child(3)').textContent = data.product.price;
                        row.querySelector('td:nth-child(4)').textContent = data.product.quantity;
                        row.querySelector('td:nth-child(5)').textContent = data.product.price * data.product
                            .quantity;
                        row.querySelector('td:nth-child(6)').textContent = data.product.updated_at;

                        // Close the modal
                        var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                        editModal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Update failed: ' + error.message);
                });
        });
    </script>
@endsection
