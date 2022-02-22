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
}
