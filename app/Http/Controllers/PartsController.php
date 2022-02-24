<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\PartsModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartsController extends Controller
{
    /**
     * @param $type
     * @param $is_shopList
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index($type, $is_shopList){
        $results = PartsModel::where('type',$type)->where('is_shopping',$is_shopList)->get();
        return view('parts',[
            'results'=>$results,
            'type'=>$type,
            'is_shop'=>$is_shopList
        ]);
    }

    public function getItemList($type,$is_shopList){
        $results = PartsModel::where('type',$type)->where('is_shopping',$is_shopList)->get();
        return response()->json($results);
    }

    public function updatePart(Request $request)
    {
        $id = $request->get('id',0);
        if (empty($id)){
            return response()->json('no_id',400);
        }
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_data',400);
        }
        PartsModel::find($id)->update($record);
        return response()->json(PartsModel::all());
    }

    public function deletePart($id) {
        if (empty($id)){
            return response()->json('no_id',400);
        }
        PartsModel::find($id)->delete();
        return response()->json('success');
    }

    public function createPart(Request $request) {
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_record',400);
        }
        PartsModel::insert($record);
        return response()->json('success');
    }


    public function exportParts(){
        $parts = DB::table('parts')->get()->toArray();
        $delimiter = ",";
        $filename = "parts_" . date('Y-m-d') . ".csv";

        // Create a file pointer
        $f = fopen('php://memory', 'w');
        // Set column headers
        $fields = array(
            'Q',
            'MQ',
            'DESCRIPTION',
            'PNQ',
            'IS_SHOPPING',
            'TYPE',
            'CREATED_AT',
            'UPDATED_AT',
        );
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        foreach ($parts as $part){
            $lineData = array(
                $part->q,
                $part->mq,
                $part->description,
                $part->pnq,
                $part->is_shopping,
                $part->type,
                $part->created_at,
                $part->updated_at,
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

    public function importParts(Request $request)
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
            $temp['q'] = $line[0];
            $temp['mq'] = $line[1];
            $temp['description'] = $line[2];
            $temp['pnq'] = $line[3];
            $temp['is_shopping'] = $line[4];
            $temp['type'] = $line[5];
            DB::table('parts')->insert($temp);
        }

        // Close opened CSV file
        fclose($csvFile);

        return redirect()->to(request()->headers->get('referer'));

    }
}
