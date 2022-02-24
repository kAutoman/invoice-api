<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\CustomersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request){
        $search = $request->get('search',[]);
        $categories = CategoriesModel::get();
        $results = DB::table('customers');
        if (!empty($search['email'])){
            $results = $results->where('email','like',"%{$search['email']}%");
        }
        if (!empty($search['state'])){
            $results = $results->where('state',"{$search['state']}");
        }
        $results = $results->get();
        return view('dashboard',['results'=>$results,'categories'=>$categories,'search'=>$search]);
    }

    public function getCustomerList(Request $request){
        $search = $request->get('search',[]);
        $categories = CategoriesModel::get();
        $results = DB::table('customers');
        if (!empty($search['email'])){
            $results = $results->where('email','like',"%{$search['email']}%");
        }
        if (!empty($search['state'])){
            $results = $results->where('state',"{$search['state']}");
        }
        return response()->json(['results'=>$results,'categories'=>$categories,'search'=>$search]);
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

    public function exportCustomers(Request $request){
        $customers = DB::table('customers')->get()->toArray();
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

        $insertData = [];
        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){

            // Get row data
            $temp = [];
            $temp['title'] = $line[1];
            $temp['mobile_phone'] = $line[2];
            $temp['email']  = $line[3];
            $temp['name'] = $line[4];
            $temp['address'] = $line[5];
            $temp['town'] = $line[6];
            $temp['postal_code'] = $line[7];
            $temp['further_note'] = $line[8];
            $temp['state'] = $line[9];
            $temp['remind_date'] = $line[10];
            $temp['category_id'] = $line[11];
            $temp['attached_files'] = $line[12];
            $temp['created_at'] = $line[13];
            $temp['updated_at'] = $line[14];
            DB::table('customers')->insert($temp);
        }

        // Close opened CSV file
        fclose($csvFile);

        return redirect()->to('/dashboard');

    }

    public function exportInvoices(Request $request){

        $invoices = DB::table('invoice')->get()->toArray();
        $delimiter = ",";
        $filename = "invoice_" . date('Y-m-d') . ".csv";

        // Create a file pointer
        $f = fopen('php://memory', 'w');
        // Set column headers
        $fields = array(
            'INVOICE_ID',
            'INVOICE_NO',
            'EMAIL',
            'INVOICE_DATE',
            'MOBILE_NUM',
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
            'CREATED_AT',
            'UPDATED_AT'
        );
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        foreach ($invoices as $invoice){
            $lineData = array(
                $invoice->id,
                $invoice->invoice_no,
                $invoice->email,
                $invoice->invoice_date,
                $invoice->mobile_num,
                $invoice->to,
                $invoice->from_address,
                $invoice->items,
                $invoice->excluding_vat,
                $invoice->vat_amount,
                $invoice->invoice_total,
                $invoice->payed_amount,
                $invoice->due_total,
                $invoice->comment,
                $invoice->customer_id,
                $invoice->created_at,
                $invoice->updated_at,
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

    public function importInvoices(Request $request)
    {
        $csv = $request->file('file');
        $realPath = $csv->getRealPath();
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($realPath, 'r');

        // Skip the first line
        fgetcsv($csvFile);

        $insertData = [];
        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){

            // Get row data
            $temp = [];
            $temp['invoice_no'] = $line[1];
            $temp['email']  = $line[2];
            $temp['invoice_date'] = $line[3];
            $temp['mobile_num'] = $line[4];
            $temp['to'] = $line[5];
            $temp['from_address'] = $line[6];
            $temp['items'] = $line[7];
            $temp['excluding_vat'] = $line[8];
            $temp['vat_amount'] = $line[9];
            $temp['invoice_total'] = $line[10];
            $temp['payed_amount'] = $line[11];
            $temp['due_total'] = $line[12];
            $temp['comment'] = $line[13];
            $temp['customer_id'] = $line[14];
            if (!empty($line[15])){
                $temp['created_at'] = $line[15];
            }
            if (!empty($line[16])){
                $temp['updated_at'] = $line[16];
            }
            DB::table('invoice')->insert($temp);
        }

        // Close opened CSV file
        fclose($csvFile);

        return redirect()->to('/dashboard');

    }
}
