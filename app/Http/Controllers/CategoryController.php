<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request){
        $results = CategoriesModel::get();
        return view('categories',['results'=>$results]);
    }

    public function getItemList(Request $request){
        return response()->json(CategoriesModel::get());
    }

    public function updateItem(Request $request)
    {
        $id = $request->get('id',0);
        if (empty($id)){
            return response()->json('no_id',400);
        }
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_data',400);
        }
        CategoriesModel::find($id)->update($record);
        return response()->json(CategoriesModel::all());
    }

    public function deleteCategory($id) {
        if (empty($id)){
            return response()->json('no_id',400);
        }
        CategoriesModel::find($id)->delete();
        return response()->json('success');
    }

    public function createCategory(Request $request) {
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_record',400);
        }
        CategoriesModel::insert($record);
        return response()->json('success');
    }

    public function exportCategories(){

        $categories = DB::table('categories')->get()->toArray();
        $delimiter = ",";
        $filename = "category_" . date('Y-m-d') . ".csv";

        // Create a file pointer
        $f = fopen('php://memory', 'w');
        // Set column headers
        $fields = array(
            'NAME'
        );
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer
        foreach ($categories as $category){
            $lineData = array(
                $category->name,
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

    public function importCategories(Request $request)
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
            $temp['name'] = $line[0];
            DB::table('invoice')->insert($temp);
        }

        // Close opened CSV file
        fclose($csvFile);

        return redirect()->to('/categories');

    }
}
