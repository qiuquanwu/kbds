<?php

namespace App\Http\Controllers;
use App\AdminUser;
use App\School;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    protected function throwValidationException(Request $request, $validator)
    {
        $response = [
            'code' => 400,
            'message'  => $validator->errors()->first(),
            'data' => []
        ];
         throw new ValidationException($validator, $response);
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

        /*验证*/
        $this->validate(
            $request,
            ['password' =>'required','username' =>'required'],
            ['password.required' => '请输入密码','username.required' => '请输入账号']
        );
        /*逻辑*/
        $data=$request->all();
        $password=$data['password'];
        $username=$data['username'];

        $user=AdminUser::where('username',$username)->first();
        if(!is_null($user)){
            if($user->password ==hash("sha256", $password)){
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

    /*上传校徽*/
    public function upload(Request $request){
        if ($request->hasFile('smfile') && $request->file('smfile')->isValid()) {
            $file = $request->file('smfile');
            $filename=hash("sha256", time()).'.'.$file->getClientOriginalExtension();
            $path=$file->move('uploads',$filename);
            if($path){
                 return response()->json([
                    'code'=>200,
                    'data'=> $filename,
                    'message'=>'文件上传成功'
                ]);
            }

        }else{
            return response()->json([
                'code'=>204,
                'data'=>'faile',
                'message'=>'文件上传失败！请重试'
            ]);
        }
    }
    /*添加学校*/
    public function addSchool(Request $request){
        $this->validate(
            $request,
            ['name' =>'required','city' =>'required','province' =>'required','imgPath' =>'required'],
            ['name.required' => '请输入名称','city.required' => '请输入城市','province.required' => '请输入省份','imgPath.required' => '请上传校徽']
        );
        $school=new School();
        $data=$request->all();
        $school->name=$data['name'];
        $school->city=$data['city'];
        $school->province=$data['province'];
        $school->imgPath=$data['imgPath'];
        $school->save();
        return response()->json([
            'code'=>200,
            'data'=>$school,
            'message'=>'添加成功！'
        ]);

    }


    /**
     * 获取学校
     */
    public function getSchool(Request $request){

            $schools=School::all();
            return response()->json([
                'code'=>200,
                'data'=>$schools,
                'message'=>'获取成功'
            ]);
    }
    public function getIndexData(Request $request){
        return "123";
    }
}
