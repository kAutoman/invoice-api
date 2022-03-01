<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;


class InvoiceController extends Controller
{
    public function insertInvoice(Request $request): \Illuminate\Http\JsonResponse
    {
        $record = $request->get('data',[]);
        $preset1 = $request->file('preset1');
        $preset2 = $request->file('preset2');
        $id = $request->get('id',0);
        $mode = $request->get('mode','add');
        if (!empty($preset1)){
            $now = microtime(true)*10000;
            $record['preset1'] = $now.'_'.auth()->user()->name.'_preset1.'.$preset1->getClientOriginalExtension();
            $preset1->storePubliclyAs('/invoice/',$record['preset1']);
        }
        if (!empty($preset2)){
            $now = microtime(true)*10000;
            $record['preset2'] = $now.'_'.auth()->user()->name.'_preset2.'.$preset2->getClientOriginalExtension();
            $preset2->storePubliclyAs('/invoice/',$record['preset2']);
        }
        if (empty($record)){
            return response()->json('no_data',400);
        }
        if ($mode === 'add'){
            $id = DB::table('invoice')->insertGetId($record);
        }
        else {
            DB::table('invoice')->where('id',$id)->update($record);
        }
        $result = [
            'result'=>$record,
            'id'=>$id
        ];

        return response()->json($result);
    }

    public function pdfInvoiceExport($id)
    {
        $invoiceData = DB::table('invoice')->find($id);

        // usersPdf is the view that includes the downloading content
        $view = \View::make('invoiceTemplate', ['invoiceData'=>$invoiceData]);
        $html_content = $view->render();
        // Set title in the PDF
        PDF::SetTitle("List of users");
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
        // userlist is the name of the PDF downloading
        PDF::Output('invoiceDetail.pdf');

    }

    public function deleteInvoice($id){
        DB::table('invoice')->where('id',$id)->delete();
        return response()->json('success');
    }

    public function getInvoiceList($customer_id){
        $result = DB::table('invoice')->where('customer_id',$customer_id)->get();
        return response()->json($result);
    }
}
