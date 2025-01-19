<?php

namespace App\Http\Controllers;

use App\Models\CompanyInvoice;
use App\Models\Invoice;
use App\Http\Requests\StoreCompanyInvoiceRequest;
use App\Http\Requests\UpdateCompanyInvoiceRequest;

class CompanyInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyInvoices = CompanyInvoice::all();
        return response()->json([
            'status' => 200,
            'companyInvoices' => $companyInvoices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('company-invoice-create');
    }

   public function store(StoreCompanyInvoiceRequest $request)
    {

        $today = date('Ymd');
        $invoiceId = CompanyInvoice::max('id') + 1;
        $invoiceNumber = "INV-{$today}/" . str_pad($invoiceId, 2, '0', STR_PAD_LEFT);

        $amount = 0;

        $dataCompanyInvoice = [
            'invoice_number' => $invoiceNumber,
            'company_name' => $request->company_name,
            'delivery_date' => $request->delivery_date,
            'submit_date' => now(),
            'amount' => $amount,
        ];

        $companyInvoice = CompanyInvoice::create($dataCompanyInvoice);

        $invoicesData = [];
        foreach ($request->invoices as $invoiceData) {
            $invoicesData[] = [
                'coil_number' => $invoiceData['coil_number'],
                'width' => $invoiceData['width'],
                'length' => $invoiceData['length'],
                'thickness' => $invoiceData['thickness'],
                'weight' => $invoiceData['weight'],
                'price' => $invoiceData['price'],
                'company_invoice_id' => $companyInvoice->id, 
            ];

            $amount += $invoiceData['price'];
        }

        Invoice::insert($invoicesData);

        $companyInvoice->update(['amount' => $amount]);

        $companyInvoice->load('invoices');

        return response()->json([
            'status' => 201,
            'message' => 'Company invoice created successfully',
            'companyInvoice' => $companyInvoice,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyInvoice $companyInvoice)
    {
        $companyInvoices = CompanyInvoice::find($companyInvoice->id);
        $invoices = Invoice::where('company_invoice_id', $companyInvoice->id)->get();

        return response()->view('company-invoice-show', compact('companyInvoices', 'invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyInvoice $companyInvoice)
    {
        $companyInvoices = CompanyInvoice::find($companyInvoice->id);
        $invoices = Invoice::where('company_invoice_id', $companyInvoice->id)->get();

        return response()->view('company-invoice-edit', compact('companyInvoices', 'invoices'));      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyInvoiceRequest $request, CompanyInvoice $companyInvoice)
    {
        $dataCompanyInvoice = [
            'company_name' => $request->company_name,
            'delivery_date' => $request->delivery_date,
        ];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyInvoice $companyInvoice)
    {
        $Invoices = Invoice::where('company_invoice_id', $companyInvoice->id)->get();
        foreach ($Invoices as $invoice) {
            $invoice->delete();
        }

        $companyInvoice->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Company invoice deleted successfully'
        ]);
    }
}
