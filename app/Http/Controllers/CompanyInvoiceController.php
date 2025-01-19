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
        // return json woth repose 200 status
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
        $companyInvoices = CompanyInvoice::all();

        dd("company invoice", $companyInvoices);

        // return response view with data
        return response()->view('company-invoice.create', compact( 'companyInvoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyInvoice $companyInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyInvoice $companyInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyInvoiceRequest $request, CompanyInvoice $companyInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyInvoice $companyInvoice)
    {
        // destroy company invoice and the related invoices
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
