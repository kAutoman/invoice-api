<?php

namespace App\Http\Controllers;

use App\Models\CategoriesModel;
use App\Models\PartsModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    /**
     * @param $type
     * @param $is_shopList
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index($type, $is_shopList, Request $request){
        $results = PartsModel::get();
        return view('parts',[
            'results'=>$results,
            'type'=>$type,
            'is_shop'=>$is_shopList
        ]);
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
