<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function insertInvoice(Request $request): \Illuminate\Http\JsonResponse
    {
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_data',400);
        }

        DB::table('invoice')->insert($record);
        return response()->json(DB::table('invoice')->get());
    }
}
