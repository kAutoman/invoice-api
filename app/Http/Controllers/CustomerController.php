<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\CustomersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request){
        $categories = CategoriesModel::get();
        $results = CustomersModel::all();
        return view('dashboard',['results'=>$results,'categories'=>$categories]);
    }

    public function insertCustomer(Request $request)
    {
        $record = $request->get('data',[]);
        $invoiceIds = $record['invoiceIds'];
        unset($record['invoiceIds']);
        $resultId = DB::table('customers')->insertGetId($record);
        DB::table('invoice')->whereIn('id',$invoiceIds)->update(['customer_id'=>$resultId]);
        return response()->json('success');
    }

    public function deleteCustomer($id)
    {
        DB::table('invoice')->where('customer_id',$id)->delete();
        DB::table('customers')->find($id)->delete();
        return response()->json('success');
    }

    public function pdfExport($id)
    {

    }

    public function exportCustomers(Request $request){
        $customers = DB::table('customers')->join('invoice','customers.id','invoice.customer_id')->get()->toArray();
        $delimiter = ",";
        $filename = "customers_" . date('Y-m-d') . ".csv";

        // Create a file pointer
        $f = fopen('php://memory', 'w');
        // Set column headers
        $fields = array(
            'CUSTOMER_ID',
            'TITLE',
            'MOBILE PHONE',
            'EMAIL',
            'NAME',
            'ADDRESS',
            'TOWN',
            'POSTAL_CODE',
            'FURTHER_NOTE',
            'STATE',
            'REMIND_DATE',
            'CATEGORY_ID',
            'ATTACH_FILES',
            'CREATED_AT',
            'UPDATED_AT',
            'INVOICE_NO',
            'INVOICE_DATE',
            'TO',
            'FROM_ADDRESS',
            'ITEMS',
            'EXCLUDING_VAT',
            'VAT_AMOUNT',
            'INVOICE_TOTAL',
            'PAYED_AMOUNT',
            'DUE_TOTAL',
            'COMMENT',
            'CUSTOMER_ID',
        );
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        foreach ($customers as $customer){
            $lineData = array(
                $customer->id,
                $customer->title,
                $customer->mobile_phone,
                $customer->email,
                $customer->name,
                $customer->address,
                $customer->town,
                $customer->postal_code,
                $customer->further_note,
                $customer->state,
                $customer->remind_date,
                $customer->category_id,
                $customer->attached_files,
                $customer->created_at,
                $customer->updated_at,
                $customer->invoice_no,
                $customer->invoice_date,
                $customer->to,
                $customer->from_address,
                $customer->items,
                $customer->excluding_vat,
                $customer->vat_amount,
                $customer->invoice_total,
                $customer->payed_amount,
                $customer->due_total,
                $customer->comment,
                $customer->customer_id,
            );
            fputcsv($f, $lineData, $delimiter);
        }

        // Move back to beginning of file
        fseek($f, 0);

        // Set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        //output all remaining data on a file pointer
        fpassthru($f);
    }

    public function importCustomers(Request $request)
    {
        $csv = $request->file('file');
        $realPath = $csv->getRealPath();
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($realPath, 'r');

        // Skip the first line
        fgetcsv($csvFile);

        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){
            // Get row data
            $name   = $line[0];
            $email  = $line[1];
            $phone  = $line[2];
            $status = $line[3];
        }

        // Close opened CSV file
        fclose($csvFile);
    }
}
