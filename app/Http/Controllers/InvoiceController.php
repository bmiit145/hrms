<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use PDF;



class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('is_delete', 0)->with(['currency', 'client'])->get(); // Only show non-deleted invoices
        return view('admin_add.invoice.index', compact('invoices'));
    }
    

    public function create(Request $request, $id = null)
    {
        // Validate for unique invoice number, ignoring the current invoice if it's being edited
        $request->validate([
            'invoice_number' => 'unique:invoices,invoice_number,' . $id, // Skip validation if editing
        ]);
    
        // Fetch all currencies and clients
        $currencies = Currency::all();
        $get_client = Client::orderBy('id', 'DESC')->where('is_delete', 0)->get();
    
        // Fetch the latest non-deleted invoice
        $latestInvoice = Invoice::orderBy('invoice_number', 'DESC')->first();
    
        // Calculate the new invoice number
        // If there's a last invoice, increment its number, otherwise start from '001'
        if ($latestInvoice) {
            // Ensure invoice_number is numeric (if it's stored as a string, strip non-numeric characters)
            $lastInvoiceNumber = (int) $latestInvoice->invoice_number;
            $invoiceNumber = str_pad($lastInvoiceNumber + 1, 3, '0', STR_PAD_LEFT); // Increment by 1 and pad with zeros
        } else {
            $invoiceNumber = '001'; // Start from '001' if no invoice exists
        }
    
        // If editing an invoice, fetch the invoice by ID
        $editInvoice = Invoice::find($id);
    
        // Pass the necessary data to the view
        return view('admin_add.invoice.create', compact('currencies', 'get_client', 'invoiceNumber', 'editInvoice'));
    }
    
    
    
    
    public function store(Request $request)
    {
        // Debug to check the incoming request data
        // dd($request->all());
    
        // Check if invoice ID exists for update
        $invoice = $request->invoice_id 
            ? Invoice::find($request->invoice_id)  // Update the existing invoice if ID exists
            : new Invoice(); // Create a new invoice if no ID is provided
    
        // Update or create the invoice
        $invoice->invoice_number = $request->invoice_number;
        $invoice->date_issued = Carbon::parse($request->date_issued)->format('Y-m-d');
        $invoice->due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        $invoice->currency_id = $request->currency_id;
        $invoice->client_id = $request->client_id;
        $invoice->discount_persentage = $request->discount_per;
        $invoice->sgst_persentage = $request->sgst_per;
        $invoice->cgst_persentage = $request->cgst_per;
        $invoice->subtotal = $request->subtotal;
        $invoice->discount = $request->discount;
        $invoice->sgst = $request->sgst;
        $invoice->cgst = $request->cgst;
        $invoice->total = $request->total;
        $invoice->is_delete = 0;  // Default to 0 (not deleted)
        $invoice->save(); // Save the invoice
    
        // Handle invoice items
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                if (isset($item['id']) && !empty($item['id'])) {
                    // Update existing invoice item
                    $invoiceItem = InvoiceItem::find($item['id']);
                    if ($invoiceItem) {
                        $invoiceItem->update([
                            'start_date' => $item['start_date'],
                            'item' => $item['item'],
                            'unit_rate' => $item['unit_rate'],
                            'project_type' => $item['project_type'],
                            'iteam_qty' => $item['iteam_qty'],
                            'iteam_hours' => $item['iteam_hours'],
                            'price' => $item['price'],
                        ]);
                    }
                } else {
                    // Create a new invoice item
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'start_date' => $item['start_date'],
                        'item' => $item['item'],
                        'unit_rate' => $item['unit_rate'],
                        'project_type' => $item['project_type'],
                        'iteam_qty' => $item['iteam_qty'],
                        'iteam_hours' => $item['iteam_hours'],
                        'price' => $item['price'],
                    ]);
                }
            }
        }
    
        // Redirect to preview page
        // return redirect()->route('admin.invoices.preview', ['id' => $invoice->id]);
        return response()->json($invoice);
    }
    
    
    
    
    
    public function update($id)
    {
        $currencies = Currency::all();
        $get_client = Client::orderBy('id', 'DESC')->get();
        $invoiceNumber = Invoice::all(); // Fetch the existing invoice number
        $invoice = InvoiceItem::all();  // Invoice items, assuming you want to show them in the form
        
        // Fetch the invoice you want to edit, make sure to load the related items
        $editInvoice = Invoice::with('items')->find($id); // Load invoice with related items
        
        // Pass the invoice data to the view
        return view('admin_add.invoice.edit', compact('currencies', 'get_client', 'invoiceNumber', 'invoice', 'editInvoice'));
    }
    
    
    public function delete($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->is_delete = 1;  // Mark as deleted
            $invoice->save();  // Save the updated status
            return response()->json(['message' => 'Invoice marked as deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting the invoice.'], 500);
        }
    }

    public function deletedInvoices()
    {
        $deletedInvoices = Invoice::where('is_delete', 1)->with(['currency', 'client'])->get(); // Only show deleted invoices
        return view('admin_add.invoice.deleted', compact('deletedInvoices'));
    }

    public function restore($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
    
            // Restore the invoice by setting is_delete to 0
            $invoice->is_delete = 0;
            $invoice->save();  // Save the updated status
    
            return redirect()->route('admin.invoice.index')->with('success', 'Invoice restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.invoice.index')->with('error', 'Error restoring the invoice.');
        }
    }
    

    public function preview($id)
    {
        // Fetch the invoice along with related items and client using eager loading
        $invoice = Invoice::with('items', 'client')->findOrFail($id);
        
        // Return the preview view with the invoice data
        return view('admin_add.invoice.invoice', compact('invoice'));
    }

    public function downloadInvoice($invoice)
    {   
        $invoice = Invoice::findOrFail($invoice);
        $pdf = PDF::loadView('admin_add.invoice.invoice', compact('invoice'));

        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }

    public function download(Request $request, $id)
    {
        set_time_limit(300);
        $invoice = Invoice::find($id);
        $pdf = Pdf::loadView('admin_add.invoice.download', ['invoice' => $invoice]);

       return $pdf->download();
    }

}
