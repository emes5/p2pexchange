<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FontSettingController extends Controller
{
    public function downloadAndStoreFontFile(Request $request){
        try {
            $file_path = $request->file_path;
            $file_name = basename($request->file_path);
            $file = file_get_contents($file_path);
            file_put_contents(public_path('assets/landing/custom/assets/fonts/'.$file_name), $file);
            $data['status']=true;
            $data['data']['file_name']=$file_name;
            $data['message']='Font Selected Successfully';
        }catch (\Exception $exception){
            $data['status']=false;
            $data['message']='Font file not found!';
        }
        return response()->json($data);
    }
}
