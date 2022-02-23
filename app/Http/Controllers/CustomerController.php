<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\CustomersModel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $categories = CategoriesModel::get();
        $results = CustomersModel::all();
        return view('dashboard',['results'=>$results,'categories'=>$categories]);
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
}
