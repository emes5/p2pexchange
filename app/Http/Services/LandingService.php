<?php
/**
 * Created by PhpStorm.
 * User: bacchu
 * Date: 9/12/19
 * Time: 12:56 PM
 */

namespace App\Http\Services;

use App\Model\AdminSetting;
use App\Model\Coin;
use App\Model\CustomPage;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LandingService
{
    public function getCustomLandingPages(){
        return DB::table('custom_landing_page')
            ->select('custom_landing_page.id','custom_landing_page.page_title','custom_landing_page.page_key','custom_landing_page.resource_path',
                'custom_landing_page.status','custom_landing_page.main_primary_color','custom_landing_page.main_hover_color',
                'custom_landing_page.temp_primary_color','custom_landing_page.temp_hover_color');
    }
    public function allCustomLandingFeatures($landing_page_id){
        return DB::table('custom_landing_feature')
            ->select('*')->where('landing_page_id','=',$landing_page_id);
    }

    public function selectedCustomLandingPages($landing_page_id){
        return DB::table('custom_page_footer_mapping')
            ->select('*')->where('landing_page_id','=',$landing_page_id);
    }

    public function AllCustomPages(){
        return CustomPage::all();
    }
    public function getCustomPages($key){
        return DB::table('custom_pages')
            ->select('*')->where('key','=',$key);
    }
    public function getCustomLandingSections($active_page_id){
        return DB::table('custom_landing_sections_temp')
            ->select('custom_landing_sections_temp.id as section_id','custom_landing_sections_temp.section_name','custom_landing_sections_temp.section_key',
                'custom_landing_sections_temp.related_table','custom_landing_sections_temp.section_title','custom_landing_sections_temp.section_description',
                'custom_landing_sections_temp.status as section_status')
            ->where('custom_landing_sections_temp.landing_page_id','=',$active_page_id);
    }

    public function getActualCustomLandingSections($active_page_id){
        return DB::table('custom_landing_sections')
            ->select('custom_landing_sections.id as section_id','custom_landing_sections.section_name','custom_landing_sections.section_key',
                'custom_landing_sections.related_table','custom_landing_sections.section_title','custom_landing_sections.section_description',
                'custom_landing_sections.status as section_status')
            ->where('custom_landing_sections.landing_page_id','=',$active_page_id);
    }
    public function getSectionData($related_table,$landing_page_id){
        return DB::table(DB::raw($related_table))
            ->select('*')
            ->where($related_table.'.landing_page_id','=',$landing_page_id);
    }

    public function getSectionCoinData($related_table,$landing_page_id){
        return DB::table(DB::raw($related_table))
            ->select("$related_table.*",'coins.name','coins.type','coins.image')
            ->join('coins','coins.id','=',"$related_table.coin_id")
            ->where("$related_table.landing_page_id",'=',$landing_page_id);
    }

    public function saveBanner($request){
        $section_id = $request->section_id;
        $section_detail_id = $request->section_detail_id;
        $banner_info =  DB::table('custom_landing_banner_temp')->select('*')->where('custom_landing_banner_temp.id','=',$request->section_detail_id)->first();
        $data_main['section_title'] = $request->title;
        $data_main['section_description'] = $request->short_description;
        $data_main['status'] = $request->status ?? 0;
        $data['title'] = $request->title;
        $data['short_description'] = $request->short_description;
        if(isset($request->login_button_name)){
            $data['login_button_name'] = $request->login_button_name;
        }
        if(isset($request->register_button_name)){
            $data['register_button_name'] = $request->register_button_name;
        }
        $data['is_filter'] = $request->is_filter ?? 0;
        if(isset($request->image)) {
            if(!empty($banner_info->image)) {
                $this->deleteOldFile($banner_info->image);
            }
            $folder = LANDING_BANNER_FOLDER;
            $data['image'] = $request->image->store($folder);
        }
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        DB::table('custom_landing_banner_temp')->where('id','=',$section_detail_id)->update($data);
        return true;
    }
    public function saveTradeAnywhere($request){
        $section_id = $request->section_id;
        $section_detail_id = $request->section_detail_id;
        $trade_info =  DB::table('custom_landing_trade_temp')->select('*')->where('custom_landing_trade_temp.id','=',$request->section_detail_id)->first();
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        if(isset($request->image_one)) {
            if(!empty($trade_info->image_one)) {
                $this->deleteOldFile($trade_info->image_one);
            }
            $folder = LANDING_TRADE_FOLDER;
            $data['image_one'] = $request->image_one->store($folder);
        }
        if(isset($request->image_two)) {
            if(!empty($trade_info->image_two)) {
                $this->deleteOldFile($trade_info->image_two);
            }
            $folder = LANDING_TRADE_FOLDER;
            $data['image_two'] = $request->image_two->store($folder);
        }
        $data['app_store_link'] = $request->app_store_link;
        $data['play_store_link'] = $request->play_store_link;
        $data['android_apk_link'] = $request->android_apk_link;
        $data['windows_link'] = $request->windows_link;
        $data['linux_link'] = $request->linux_link;
        $data['mac_link'] = $request->mac_link;
        $data['api_link'] = $request->api_link;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        DB::table('custom_landing_trade_temp')->where('id','=',$section_detail_id)->update($data);
        return true;
    }
    public function saveMarketTrend($request){
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        return true;
    }
    public function saveAbout($request){
        $section_id = $request->section_id;
        $section_detail_id = $request->section_detail_id;
        $about_info =  DB::table('custom_landing_about_temp')->select('*')->where('custom_landing_about_temp.id','=',$request->section_detail_id)->first();
        $data_main['section_title'] = $request->title;
        $data_main['section_description'] = $request->short_description;
        $data_main['status'] = $request->status ?? 0;
        $data['title'] = $request->title;
        $data['short_description'] = $request->short_description;
        $data['long_description'] = $request->long_description;
        $data['button_name'] = $request->button_name;
        $data['button_link'] = $request->button_link;
        if(isset($request->image)) {
            if(!empty($about_info->image)) {
                $this->deleteOldFile($about_info->image);
            }
            $folder = LANDING_ABOUT_FOLDER;
            $data['image'] = $request->image->store($folder);
        }
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        DB::table('custom_landing_about_temp')->where('id','=',$section_detail_id)->update($data);
        return true;
    }
    public function saveFeature($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveWork($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveAdvantage($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveProcess($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveCoinBuySell($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title ?? '';
        $data_main['section_description'] = $request->section_description ?? '';
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveTestimonial($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveTeam($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveFaq($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }
    public function saveSubscribe($request){
        try{
        $section_id = $request->section_id;
        $data_main['section_title'] = $request->section_title;
        $data_main['section_description'] = $request->section_description;
        $data_main['status'] = $request->status ?? 0;
        DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->update($data_main);
        }catch (\Exception $exception){
            return false;
        }
        return true;
    }


    public function saveWorkDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $feature_detail_info =  DB::table('custom_landing_p2p_temp')->select('*')->where('custom_landing_p2p_temp.id','=',$request->id)->first();
                $image = $feature_detail_info->image;
            }
            $data['sub_title'] = $request->sub_title;
            $data['type'] = $request->type;
            $data['sub_description'] = $request->sub_description;
            if(isset($request->image)) {
                if(!empty($request->id) && !empty($feature_detail_info->image)) {
                    $this->deleteOldFile($feature_detail_info->image);
                }
                $folder = LANDING_WORK_FOLDER;
                $data['image'] = $request->image->store($folder);
                $image = $data['image'];
            }
            if($request->id){
                DB::table('custom_landing_p2p_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                $data['image']=$image;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_p2p_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['image']=check_storage_image_exists($data['image']);
        $data['new_serial'] = getLastSerialOfFeature('work',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Work Details updated successfully!')];
    }
    public function saveFeatureDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $feature_detail_info =  DB::table('custom_landing_feature_temp')->select('*')->where('custom_landing_feature_temp.id','=',$request->id)->first();
                $icon = $feature_detail_info->icon;
            }
            $data['sub_title'] = $request->sub_title;
            $data['sub_description'] = $request->sub_description;
            if(isset($request->icon)) {
                if(!empty($request->id) && !empty($feature_detail_info->icon)) {
                    $this->deleteOldFile($feature_detail_info->icon);
                }
                $folder = LANDING_FEATURE_FOLDER;
                $data['icon'] = $request->icon->store($folder);
                $icon = $data['icon'];
            }
            if($request->id){
                DB::table('custom_landing_feature_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                if(isset($icon)){
                    $data['icon']=$icon;
                }
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_feature_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        if(isset($data['icon'])){
            $data['icon']=check_storage_image_exists($data['icon']);
        }
        $data['new_serial'] = getLastSerialOfFeature('feature',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Feature Details updated successfully!')];
    }
    public function saveAdvantageDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $feature_detail_info =  DB::table('custom_landing_advantage_temp')->select('*')->where('custom_landing_advantage_temp.id','=',$request->id)->first();
                $image = $feature_detail_info->image;
            }
            $data['sub_title'] = $request->sub_title;
            $data['sub_description'] = $request->sub_description;
            if(isset($request->image)) {
                if(!empty($request->id) && !empty($feature_detail_info->image)) {
                    $this->deleteOldFile($feature_detail_info->image);
                }
                $folder = LANDING_ADVANTAGE_FOLDER;
                $data['image'] = $request->image->store($folder);
                $image = $data['image'];
            }
            if($request->id){
                DB::table('custom_landing_advantage_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                $data['image']=$image;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_advantage_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['image']=check_storage_image_exists($data['image']);
        $data['new_serial'] = getLastSerialOfFeature('advantage',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Advantage Details updated successfully!')];
    }
    public function saveProcessDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $process_detail_info =  DB::table('custom_landing_process_temp')->select('*')->where('custom_landing_process_temp.id','=',$request->id)->first();
                $image = $process_detail_info->image;
            }
            $data['sub_title'] = $request->sub_title;
            $data['sub_description'] = $request->sub_description;
            if(isset($request->image)) {
                if(!empty($request->id) && !empty($process_detail_info->image)) {
                    $this->deleteOldFile($process_detail_info->image);
                }
                $folder = LANDING_PROCESS_FOLDER;
                $data['image'] = $request->image->store($folder);
                $image = $data['image'];
            }
            if($request->id){
                DB::table('custom_landing_process_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                $data['image']=$image;
                $data['serial'] = $request->serial;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_process_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['image']=check_storage_image_exists($data['image']);
        $data['new_serial'] = getLastSerialOfFeature('process',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Process Details updated successfully!')];
    }
    public function saveTestimonialDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $testimonial_detail_info =  DB::table('custom_landing_testimonial_temp')->select('*')->where('custom_landing_testimonial_temp.id','=',$request->id)->first();
                $image = $testimonial_detail_info->image;
            }
            $data['sub_title'] = $request->sub_title;
            $data['sub_description'] = $request->sub_description;
            if(isset($request->image)) {
                if(!empty($request->id) && !empty($testimonial_detail_info->image)) {
                    $this->deleteOldFile($testimonial_detail_info->image);
                }
                $folder = LANDING_TESTIMONIAL_FOLDER;
                $data['image'] = $request->image->store($folder);
                $image = $data['image'];
            }
            if($request->id){
                DB::table('custom_landing_testimonial_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                $data['image']=$image;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_testimonial_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['image']=check_storage_image_exists($data['image']);
        $data['new_serial'] = getLastSerialOfFeature('testimonial',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Testimonial Details updated successfully!')];
    }
    public function saveCoinBuySellDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            $data['coin_id'] = $request->coin_id;
            $data['sub_description'] = $request->sub_description;
            if($request->id){
                DB::table('custom_landing_coins_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_coins_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['new_serial'] = getLastSerialOfFeature('coin',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Coin buy or sell Details updated successfully!')];
    }
    public function saveTeamDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->id){
                $team_detail_info =  DB::table('custom_landing_teams_temp')->select('*')->where('custom_landing_teams_temp.id','=',$request->id)->first();
                $image = $team_detail_info->image;
            }
            $data['sub_title'] = $request->sub_title;
            $data['sub_description'] = $request->sub_description;
            $data['facebook'] = $request->facebook;
            $data['linkedin'] = $request->linkedin;
            $data['twitter'] = $request->twitter;
            if(isset($request->image)) {
                if(!empty($request->id) && !empty($team_detail_info->image)) {
                    $this->deleteOldFile($team_detail_info->image);
                }
                $folder = LANDING_TEAM_FOLDER;
                $data['image'] = $request->image->store($folder);
                $image = $data['image'];
            }
            if($request->id){
                DB::table('custom_landing_teams_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
                $data['image']=$image;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_teams_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['image']=check_storage_image_exists($data['image']);
        $data['new_serial'] = getLastSerialOfFeature('team',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Team Details updated successfully!')];
    }
    public function saveFaqDetails($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            $data['question'] = $request->question;
            $data['answer'] = $request->answer;
            if($request->id){
                DB::table('custom_landing_faqs_temp')->where('id','=',$request->id)->update($data);
                $data['id']=$request->id;
            }
            else{
                $data['landing_page_id'] = $landing_page_id;
                $data['serial'] = $request->serial;
                DB::table('custom_landing_faqs_temp')->insert($data);
                $data['id']=DB::getPdo()->lastInsertId();
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        $data['new_serial'] = getLastSerialOfFeature('faq',$landing_page_id)+1;
        return ['success'=>true,'data'=>$data,'message'=>__('Faq Details updated successfully!')];
    }
    public function deleteOldFile($file_path){
        $folder = '';
        deleteStorageFile($folder,$file_path);
        return true;
    }
    public function savePrimaryColor($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            $data['temp_primary_color'] = $request->color_code;
            DB::table('custom_landing_page')->where('id','=',$landing_page_id)->update($data);
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        return ['success'=>true,'data'=>$data,'message'=>__('Color updated successfully!')];
    }
    public function saveHoverColor($request){
        DB::beginTransaction();
        try{
            $landing_page_id = $request->landing_page_id;
            $data['temp_hover_color'] = $request->color_code;
            DB::table('custom_landing_page')->where('id','=',$landing_page_id)->update($data);
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        return ['success'=>true,'data'=>$data,'message'=>__('Color updated successfully!')];
    }
    public function saveAndPublish($landing_id){
        DB::beginTransaction();
        try{
            //all inactive
            DB::table('custom_landing_page')->update(['status'=>STATUS_DEACTIVE]);
            //page table update
            $page = DB::table('custom_landing_page')->where('id', '=', $landing_id)->first();
            $update_page['main_primary_color'] = $page->temp_primary_color;
            $update_page['main_hover_color'] = $page->temp_hover_color;
            $update_page['status'] = STATUS_ACTIVE;
            DB::table('custom_landing_page')->where('id','=',$landing_id)->update($update_page);
            //section table update
            $page_sections = DB::table('custom_landing_sections')->where('landing_page_id', '=', $landing_id)->get();
            $page_sections_temp = DB::table('custom_landing_sections_temp')->where('landing_page_id', '=', $landing_id)->get();
            foreach ($page_sections as $key=>$section)
            {
                $update_sections['section_title'] = $page_sections_temp[$key]->section_title;
                $update_sections['section_description'] = $page_sections_temp[$key]->section_description;
                $update_sections['status'] = $page_sections_temp[$key]->status;
                DB::table('custom_landing_sections')->where('id','=',$section->id)->update($update_sections);
            }
            //need to transfer all data to real table
            foreach($page_sections_temp as $section_single){
                if(!empty($section_single->related_table)){
                    $table_name = str_replace("_temp","",$section_single->related_table);
                    $single_sections_temp = DB::table(DB::raw($section_single->related_table))->where('landing_page_id', '=', $landing_id)->get();
                    DB::table(DB::raw($table_name))->where('landing_page_id','=',$landing_id)->delete();
                    $insert_array = [];
                    foreach ($single_sections_temp as $parent_key=>$temp_row){
                        foreach ($temp_row as $key=>$value){
                            if($key!='id'){
                                $insert_array[$parent_key][$key] = $value;
                            }
                        }
                    }
                    DB::table(DB::raw($table_name))->insert($insert_array);
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['success'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        return ['success'=>true,'message'=>__('Save and publish completed successfully!')];
    }

    public function customPageSlugCheck($post_data){
        $text_array = explode(' ', $post_data['title']);
        $slug = '';
        foreach ($text_array as $i => $split_text) {
            if(!empty($slug)){
                $slug = $slug .'-'. strtolower(trim($split_text));
            }else{
                $slug = strtolower(trim($split_text));
            }
        }
        if(isset($post_data['id'])){
            $res = CustomPage::where('id','<>',$post_data['id'])->where('key', 'like', '%'.$slug.'%')->get()->count();
        }else{
            $res = CustomPage::where('key', 'like', '%'.$slug.'%')->get()->count();
        }
        if($res){
            $response['slug'] = $slug.'-'.$res;
        }else{
            $response['slug'] = $slug;
        }
        return response()->json($response);
    }

    public function checkKeyCustom($key,$id = null){
        if(isset($id)){
            $res = CustomPage::where('id','<>',$id)->where('key', 'like', '%'.$key.'%')->get()->count();
        }else{
            $res = CustomPage::where('key', 'like', '%'.$key.'%')->get()->count();
        }
        if($res){
            return false;
        }else{
            return true;
        }
    }

    public function saveFooterInfo($request){
        DB::beginTransaction();
        try{
            if (isset($request->footer_description)) {
                AdminSetting::updateOrCreate(['slug' => 'footer_description'], ['value' => $request->footer_description]);
            }
            if (isset($request->newsletter_description)) {
                AdminSetting::updateOrCreate(['slug' => 'newsletter_description'], ['value' => $request->newsletter_description]);
            }
            if (isset($request->facebook_link)) {
                AdminSetting::updateOrCreate(['slug' => 'facebook_link'], ['value' => $request->facebook_link]);
            }
            if (isset($request->twitter_link)) {
                AdminSetting::updateOrCreate(['slug' => 'twitter_link'], ['value' => $request->twitter_link]);
            }
            if (isset($request->linkedin_link)) {
                AdminSetting::updateOrCreate(['slug' => 'linkedin_link'], ['value' => $request->linkedin_link]);
            }
            if (isset($request->instagram_link)) {
                AdminSetting::updateOrCreate(['slug' => 'instagram_link'], ['value' => $request->instagram_link]);
            }
            if (isset($request->contact_address)) {
                AdminSetting::updateOrCreate(['slug' => 'contact_address'], ['value' => $request->contact_address]);
            }
            if (isset($request->site_email)) {
                AdminSetting::updateOrCreate(['slug' => 'site_email'], ['value' => $request->site_email]);
            }
            if (isset($request->site_mobile)) {
                AdminSetting::updateOrCreate(['slug' => 'site_mobile'], ['value' => $request->site_mobile]);
            }
            $landing_page_id = $request->landing_page_id;
            $features = (array)$request->features;
            $pages = (array)$request->pages;
            DB::table('custom_landing_feature')->where('landing_page_id',$landing_page_id)->update(['footer_status'=>0]);
            DB::table('custom_landing_feature')->whereIn('id',$features)->update(['footer_status'=>STATUS_SUCCESS]);
            DB::table('custom_page_footer_mapping')->where('landing_page_id','=',$landing_page_id)->delete();
            $data=[];
            foreach ($pages as $key=>$page){
                $data[$key]['landing_page_id'] = $landing_page_id;
                $data[$key]['custom_page_id'] = $page;
            }
            if($data){
                DB::table('custom_page_footer_mapping')->insert($data);
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return ['status'=>false,'message'=>__($exception->getMessage())];
        }
        DB::commit();
        return ['status'=>true,'message'=>__('Footer Information saved successfully!')];
    }
}
