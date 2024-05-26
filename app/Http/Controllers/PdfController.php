<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class PdfController extends Controller
{

    public function invoice(Request $request, $tenant, $id)
    {

        $salesOrder = SalesOrder::with(['customer.alamat', 'user', 'customer.contacts', 'team', 'order_details.product'])->findOrFail($id);
        $so_no = $salesOrder->so_no;
        // Kelompokkan orderDetails berdasarkan koli
        $groupedDetails = $salesOrder->order_details->groupBy('koli');
        $so_no = $salesOrder->so_no;

        $pdf = PDF::loadView('pdf', compact('salesOrder', 'groupedDetails', 'so_no'))
            ->setPaper('letter', 'potrait')
            ->setOptions(['dpi' => 300]);
        return $pdf->download("{$so_no}.pdf");
        // return $pdf->stream();
    }
}
