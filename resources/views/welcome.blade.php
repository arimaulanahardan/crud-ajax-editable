@extends('layouts.app')

@section('content')
    <div class="container mb-5">
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
                            <td class="text-center">
                                <button class="btn btn-danger delete-btn" data-id="{{ $product->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script>
        // sumbit button function with ajax
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
                        fetchProducts(); // Memanggil fungsi untuk memperbarui daftar produk
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
        // end submit function

        // Fungsi untuk mengambil dan memperbarui daftar produk
        function fetchProducts() {
            fetch('{{ route('products.index') }}') // Ganti dengan route yang sesuai untuk mengambil daftar produk
                .then(response => response.json())
                .then(data => {
                    const productTable = document.getElementById('productTable').querySelector('tbody');
                    productTable.innerHTML = ''; // Kosongkan tabel sebelum menambahkan data baru
                    data.forEach(product => {
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-id', product.id);
                        newRow.innerHTML = `
                            <td>${product.name}</td>
                            <td>${product.description}</td>
                            <td>${product.price}</td>
                            <td>${product.quantity}</td>
                            <td>${product.price * product.quantity}</td>
                            <td>${product.updated_at}</td>
                            <td class="text-center">
                                <button class="btn btn-danger delete-btn" data-id="${product.id}">Delete</button>
                            </td>`;
                        productTable.appendChild(newRow);
                    });
                    // Tambahkan event listener untuk tombol delete
                    const deleteButtons = document.querySelectorAll('.delete-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', handleDelete);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Panggil fetchProducts saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchProducts);
        // end delete function

        // Delete Button function with ajax
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');

                    if (confirm('Are you sure you want to delete this product?')) {
                        fetch(`/${productId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    this.closest('tr').remove();
                                } else {
                                    alert('Failed to delete the product.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
        // end delete function 
    </script>
@endsection
