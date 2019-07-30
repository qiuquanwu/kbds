<?php

namespace App\Http\Controllers;
use App\AdminUser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function test(){
        $data=['name' => 'Abigail', 'state' => 'CA'];
        return response()->json([
            'code' => 200,
            'data' =>$data,
            'message' => '成功',
        ]);
    }
    /*
        登陆接口
    */
    public function login(Request $request){
        $data=$request->all();
        $password=$data['password'];
        $username=$data['username'];
        $user=AdminUser::where('user_name',$username)->first();
        if(!is_null($user)){
            if($user->user_password ==hash("sha256", $password)){
                 return response()->json([
                    'code'=>200,
                    'data'=>hash("sha256", $password),
                    'message'=>'登录成功'
                 ]);
            }else{
                 return response()->json([
                    'code'=>203,
                    'data'=>'faile',
                    'message'=>'密码或用户名错误'
                 ]);
            }
        }else{
              return response()->json([
                    'code'=>204,
                    'data'=>'faile',
                    'message'=>'用户名不存在'
                 ]);
        }
    }
    public function getIndexData(Request $request){
        return "123";
    }
}