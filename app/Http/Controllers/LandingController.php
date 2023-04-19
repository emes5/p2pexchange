<?php

namespace App\Http\Controllers;

use App\Http\Services\LandingService;
use App\Model\AdminSetting;
use App\Model\Coin;
use App\Model\Faq;
use App\Model\PaymentMethod;
use App\Model\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

class LandingController extends Controller
{
    // landing page
    public function home(LandingService $landingService)
    {
        $data['settings'] = allsetting();
        $myIp = Location::get(request()->ip());
        if ($myIp == false) {
            $data['country'] = 'any';
        } else {
            $data['country'] = $myIp->countryCode;
        }
        $data['coins_type'] = 'BTC';
        $data['pmethod'] = 'any';
        $data['countries'] = countrylist();
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->orderBy('id', 'ASC')->get();
        $data['payment_methods'] = PaymentMethod::where('status', STATUS_ACTIVE)->orderBy('id','Desc')->get();
        $data['custom_pages'] = $landingService->AllCustomPages();
        $pages = $landingService->getCustomLandingPages()->get();
        foreach($pages as $page){
            if($page->status){
                $data['element_prefix'] = element_prefix($page->id);
                $data['title']=$page->page_title;
                $data['active_page_id']=$page->id;
                $data['active_page_key']=$page->page_key;
                $data['resource_path']=$page->resource_path;
                $data['main_primary_color']=$page->main_primary_color;
                $data['main_hover_color']=$page->main_hover_color;
                $data['temp_primary_color']=$page->temp_primary_color;
                $data['temp_hover_color']=$page->temp_hover_color;
                $data['footer_features'] = $landingService->allCustomLandingFeatures($page->id)->get();
                $selected = $landingService->selectedCustomLandingPages($page->id)->get();
                $data['selected_custom_pages']=[];
                foreach ($selected as $key=>$select){
                    $data['selected_custom_pages'][$key] = $select->custom_page_id;
                }
            }
        }
        $data['sections'] = $landingService->getActualCustomLandingSections($data['active_page_id'])->get();
        foreach($data['sections'] as $section){
            $data['section_data'][$section->section_key]='';
            if(!empty($section->related_table)){
                if($section->section_key=='coin_buy_sell'){
                    $data['coins'] = Coin::where('status',STATUS_ACCEPTED)->get();
                    $data['section_data'][$section->section_key] = $landingService->getSectionCoinData($section->related_table,$data['active_page_id'])->get();
                }else{
                    $data['section_data'][$section->section_key] = $landingService->getSectionData($section->related_table,$data['active_page_id'])->get();
                }
            }
        }
        return view($data['resource_path'], $data);
    }

    public function seeDetails(LandingService $landingService,$key){
        $data['blog'] = true;
        $data['settings'] = allsetting();
        $data['content'] = $landingService->getCustomPages($key)->first();
        $data['custom_pages'] = $landingService->AllCustomPages();
        $pages = $landingService->getCustomLandingPages()->get();
        foreach($pages as $page){
            if($page->status){
                $data['element_prefix'] = element_prefix($page->id);
                $data['title']=$page->page_title;
                $data['active_page_id']=$page->id;
                $data['active_page_key']=$page->page_key;
                $data['resource_path']=$page->resource_path;
                $data['main_primary_color']=$page->main_primary_color;
                $data['main_hover_color']=$page->main_hover_color;
                $data['temp_primary_color']=$page->temp_primary_color;
                $data['temp_hover_color']=$page->temp_hover_color;
                $data['footer_features'] = $landingService->allCustomLandingFeatures($page->id)->get();
                $selected = $landingService->selectedCustomLandingPages($page->id)->get();
                $data['selected_custom_pages']=[];
                foreach ($selected as $key=>$select){
                    $data['selected_custom_pages'][$key] = $select->custom_page_id;
                }
            }
        }
        return view($data['resource_path'], $data);
    }
}
