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

    public function pdfExport($id){

    }
}
