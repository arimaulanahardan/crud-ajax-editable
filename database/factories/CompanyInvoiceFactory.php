<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompanyInvoice;
use App\Models\Invoice;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyInvoice>
 */
class CompanyInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->unique()->numerify('INV-########/##'),
            'company_name' => 'PT. ' . $this->faker->company,
            'delivery_date' => $this->faker->date(),
            'submit_date' => $this->faker->date(),
            'amount' => 0
        ];
    }
    
    public function configure()
    {
        return $this->afterCreating(function (CompanyInvoice $companyInvoice) {
            $invoices = Invoice::factory()->count(2)->create(['company_invoice_id' => $companyInvoice->id]);
            $totalAmount = $invoices->sum('price');
            $companyInvoice->update(['amount' => $totalAmount]);

            Invoice::factory()->count(2)->create(['company_invoice_id' => $companyInvoice->id]);
        });
    }
}
