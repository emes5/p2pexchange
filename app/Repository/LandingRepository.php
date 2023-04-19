<?php
namespace App\Repository;
use App\Model\Admin\Bank;
use App\Model\AdminSetting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LandingRepository
{

    // save landing setting
    public function saveLandingSetting($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            foreach ($request->except('_token') as $key => $value) {
                if ($request->hasFile($key)) {
                    $image = uploadFile($request->$key, IMG_PATH, isset(allsetting()[$key]) ? allsetting()[$key] : '');
                    AdminSetting::updateOrCreate(['slug' => $key], ['value' => $image]);
                } else {
                    AdminSetting::updateOrCreate(['slug' => $key], ['value' => $value]);
                }
            }

            $response = [
                'success' => true,
                'message' => __('Landing setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

    // save feature for landing page
    public function updatePexerFeature($request)
    {
        $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            if (isset($request->pexer_feature[0])) {
                $count = sizeof($request->pexer_feature);
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($request->pexer_feature[$i]) && (!empty($request->pexer_value[$i]))) {
                        AdminSetting::create(['slug' => 'pexer_feature|'.$request->pexer_feature[$i], 'value' => $request->pexer_value[$i]]);
                    }
                }
            }

            $response = [
                'success' => true,
                'message' => __('Landing setting updated successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
            return $response;
        }
        DB::commit();
        return $response;
    }

}
