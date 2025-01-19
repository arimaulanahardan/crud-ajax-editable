
# Company Invoice Management

This is a Laravel-based application that allows users to create and manage company invoices and related data using AJAX and dynamic form handling. This README provides detailed instructions for setting up the project, the database schema, relationships, and other relevant information.

## Prerequisites

Before getting started, make sure you have the following installed:

- [PHP](https://www.php.net/downloads.php) (preferably version 8.0+)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/) (preferably version 14+)
- [NPM](https://www.npmjs.com/get-npm)

## Installation

Follow these steps to set up the project:

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install PHP Dependencies

Run the following command to install PHP dependencies using Composer:

```bash
composer install
```

### 3. Install Node.js Dependencies

Run the following command to install JavaScript dependencies:

```bash
npm install
```

### 4. Compile Assets

Compile your assets using NPM:

```bash
npm run dev
```

This command will compile and optimize the assets such as CSS and JavaScript files.

### 5. Generate Application Key

Generate the application key for Laravel:

```bash
php artisan key:generate
```

This will set the `APP_KEY` in your `.env` file, which is required for encryption and security.

### 6. Run Migrations and Seed Data

Run the migrations to create the required tables and seed the initial data (if any):

```bash
php artisan migrate --seed
```

This will set up the database schema and insert any initial data required for the app.

### 7. Serve the Application

Start the development server:

```bash
php artisan serve
```

By default, the application will be accessible at `http://127.0.0.1:8000`.

## Database Schema

This application uses a relational database with the following tables:

1. **CompanyInvoices**: Stores details about company invoices.
    - Columns:
      - `id` (Primary Key)
      - `invoice_number` (String)
      - `company_name` (String)
      - `delivery_date` (Date)
      - `submit_date` (DateTime)
      - `amount` (Decimal)

2. **Invoices**: Stores individual invoices related to company invoices.
    - Columns:
      - `id` (Primary Key)
      - `coil_number` (String)
      - `width` (Integer)
      - `length` (Integer)
      - `thickness` (Integer)
      - `weight` (Decimal)
      - `price` (Decimal)
      - `company_invoice_id` (Foreign Key referencing `company_invoices.id`)

### Table Relationships

1. **CompanyInvoice to Invoice**: One-to-many relationship. A company invoice can have multiple related invoices.
   - In the `CompanyInvoice` model:
     ```php
     public function invoices()
     {
         return $this->hasMany(Invoice::class);
     }
     ```
   - In the `Invoice` model:
     ```php
     public function companyInvoice()
     {
         return $this->belongsTo(CompanyInvoice::class);
     }
     ```

## AJAX Implementation

The application uses AJAX to dynamically add invoices and calculate the total amount in real-time. Here's a breakdown of how it works:

1. **Adding Invoices Dynamically**: 
    - When the "Add Invoice" button is clicked, new input fields for a coil number, width, length, thickness, weight, and price are added to the form dynamically.
    - This is handled by the following jQuery code:
    ```javascript
    $('#addInvoice').on('click', function() {
        $('#createInvoice').append(`
            <div class="d-flex justify-content-between gap-4">
                <!-- New input fields for each invoice -->
            </div>
        `);
    });
    ```

2. **Total Amount Calculation**:
    - The total amount is dynamically calculated by listening for input changes in the `price[]` fields.
    - When the price of any invoice is changed, the `input[name="price[]"]` event triggers, and the total amount is updated:
    ```javascript
    $(document).on('input', 'input[name="price[]"]', function() {
        let totalAmount = 0;
        $('input[name="price[]"]').each(function() {
            totalAmount += parseFloat($(this).val()) || 0; // Avoid NaN
        });
        $('#amount').text(totalAmount);
    });
    ```

3. **Form Submission via AJAX**:
    - When the user submits the form, an AJAX request is sent to the server to save the company invoice and related invoices.
    - The data is collected using `FormData` and sent to the backend using the `POST` method.
    - Example of AJAX request:
    ```javascript
    $.ajax({
        url: "{{ route('company-invoices.store') }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Handle success
        },
        error: function(xhr, status, error) {
            // Handle errors
        }
    });
    ```

### Response Handling

The response from the server contains the `status` and `message`, which are displayed to the user. If there are validation errors, they are displayed in a red error box.

```javascript
success: function(response) {
    if (response.status == 201) {
        // Display success message
    }
},
error: function(xhr, status, error) {
    let errors = xhr.responseJSON.errors;
    let errorMessage = '';
    $.each(errors, function(key, value) {
        errorMessage += `<div class="alert alert-danger">${value}</div>`;
    });
    $('#response-message').html(errorMessage);
}
```

## File Structure

The file structure of this application is organized as follows:

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
├── resources/
│   ├── views/
│   │   ├── company_invoices/
│   │   ├── layouts/
│   │   └── errors/
├── routes/
│   ├── web.php
├── database/
│   ├── migrations/
│   ├── seeders/
├── public/
│   ├── css/
│   ├── js/
├── storage/
│   ├── logs/
├── .env
└── .gitignore
```

## Usage

Once the app is running, users can:

1. Add a new company invoice by filling in the company name, delivery date, and invoice details.
2. Click the "Add Invoice" button to add additional invoice fields.
3. Enter the price for each invoice, and the total amount will be calculated automatically.
4. Submit the form via AJAX to store the company invoice and related invoice details in the database.
5. In case of an error or success, an appropriate message is displayed.

### Routes

- **GET `/company-invoices/create`**: Displays the form for creating a new company invoice.
- **POST `/company-invoices`**: Handles form submission and stores the data in the database.

### Controllers

- **CompanyInvoiceController**: Handles the business logic for creating and storing company invoices.
  
  Example of the `store` method:
  ```php
  public function store(Request $request)
  {
      $data = $request->validate([
          'company_name' => 'required|string',
          'delivery_date' => 'required|date',
          'invoices' => 'required|array',
          'invoices.*.coil_number' => 'required|string',
          'invoices.*.price' => 'required|numeric',
      ]);

      $companyInvoice = CompanyInvoice::create([
          'company_name' => $data['company_name'],
          'delivery_date' => $data['delivery_date'],
          'submit_date' => now(),
      ]);

      foreach ($data['invoices'] as $invoiceData) {
          $companyInvoice->invoices()->create($invoiceData);
      }

      return response()->json([
          'status' => 201,
          'message' => 'Company invoice created successfully!',
      ]);
  }
  ```

## Conclusion

This application allows users to manage company invoices and their related invoices seamlessly using AJAX for dynamic form handling. The server-side functionality uses Laravel to store invoices and ensure proper relationships between models. Make sure to follow the setup instructions and ensure that your environment meets the prerequisites before running the application.

If you encounter any issues, feel free to check the Laravel logs or the browser console for detailed error messages.