<?php

namespace App\Http\Controllers;

use App\Mail\AdamProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request){
        return view('users',['results'=>User::get()]);
    }

    public function getUserList(Request $request){
        return response()->json(User::get());
    }

    public function updateUser(Request $request)
    {
        $id = $request->get('id',0);
        if (empty($id)){
            return response()->json('no_id',400);
        }
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_data',400);
        }
        User::find($id)->update($record);
        return response()->json(User::all());
    }

    public function deleteUser($id) {
        if (empty($id)){
            return response()->json('no_id',400);
        }
        User::find($id)->delete();
        return response()->json('success');
    }

    public function insertUser(Request $request) {
        $record = $request->get('data',[]);
        if (empty($record)){
            return response()->json('no_record',400);
        }
        User::insert($record);
        return response()->json('success');
    }

    public function recoverPassword($email){
        if (empty($email)){
            return response()->json('Please input email',400);
        }

        $name = 'Cloudways';
        Mail::to('kautoman99923@gmail.com')->send(new AdamProduct($name));

        return 'Email sent Successfully';

    }
}
