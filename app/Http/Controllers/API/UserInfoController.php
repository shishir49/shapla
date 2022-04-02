<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function index()
    {
        $users = UserInfo::all();

        return response()->json([
            'success' => true,
            'message' => 'All Users',
            'data' => $users
        ],200);
    }

    public function show_user()
    {
        $user = UserInfo::where('id',Auth::user()->id)->first();

        if($user)
        {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => $user
            ],200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => $user
            ],404);
        }
    }

    public function create(Request $request)
    {
        $user_info = new UserInfo();

        $user_info->user_id=Auth::user()->id;
        $user_info->first_name=$request->first_name;
        $user_info->last_name=$request->last_name;
        $user_info->mobile=$request->mobile;
        $user_info->permanent_address=$request->permanent_address;
        $user_info->present_address=$request->present_address;

        $image=$request->file('photo');
        if($image)
        {
            $image_name=time();
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='photo/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success)
            {
                $user_info->photo=$image_url;
                //DB::table('settings')->insert($setting);
            }
        }

        $user_info->save();
        //DB::table('settings')->insert($setting);

        return response()->json([
            'success' => true,
            'message' => 'User Info Successfully Created',
            'data' => $user_info
        ],201);
    }

    public function update(Request $request, $id)
    {
        $user_info_update = UserInfo::find($id);
        if(!$user_info_update)
        {
            return response()->json([
                'success' => false,
                'message' => 'No data found',
                'data' => $user_info_update
            ],404);
        }

        $user_info_update->first_name=$request->first_name;
        $user_info_update->last_name=$request->last_name;
        $user_info_update->mobile=$request->mobile;
        $user_info_update->permanent_address=$request->permanent_address;
        $user_info_update->present_address=$request->present_address;
        $user_info_update->user_id=Auth::user()->id;

        $image=$request->file('photo');
        if($image)
        {
            $image_name=time();
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='photo/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success)
            {
                $user_info_update->photo=$image_url;
                //DB::table('settings')->insert($setting);
            }
        }

        $user_info_update->update();

        return response()->json([
            'success' => true,
            'message' => 'User Info Successfully Updated',
            'data' => $user_info_update
        ],200);
    }

    public function delete($id)
    {
        $user_info_update_delete = UserInfo::where('id',$id)->first();

        if (!$user_info_update_delete)
        {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => $user_info_update_delete
            ],404);
        }

        $user_info_update_delete->delete();

        return response()->json([
            'success' => true,
            'message' => 'User Info Successfully Deleted',
            'data' => $user_info_update_delete
        ],200);
    }

}
