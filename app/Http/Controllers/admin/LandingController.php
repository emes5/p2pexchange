<?php

namespace App\Http\Controllers\admin;

use App\Http\Services\LandingService;
use App\Model\AdminSetting;
use App\Model\Coin;
use App\Model\CustomPage;
use App\Model\Subscriber;
use App\Model\Testimonial;
use App\Repository\LandingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use View;

class LandingController extends Controller
{
    private $landingService;
    public function __construct(LandingService $landingService)
    {
        $this->landingService = $landingService;
        $this->landingRepo = new LandingRepository();
    }
    public function landingSettings(Request $request)
    {
        $data['tab']='home';
        if(isset($_GET['tab'])){
            $data['tab']=$_GET['tab'];
        }
        $data['title'] = __('Landing Settings');
        $data['settings'] = allsetting();
        $data['pexer_features'] = AdminSetting::where('slug', 'LIKE', 'pexer_feature|%')->get();

        return view('admin.settings.landing', $data);
    }

    // admin settings save process
    public function updateLandingSettings(Request $request)
    {
        $rules=[];
//        $messages=[];
        if(!empty($request->landing_banner_img)){
            $rules['landing_banner_img']='image|mimes:jpg,jpeg,png|max:3000';
        }
        if(!empty($request->about_section_img)){
            $rules['about_section_img']='image|mimes:jpg,jpeg,png|max:3000';
        }
        if(!empty($request->feature_section_img)){
            $rules['feature_section_img']='image|mimes:jpg,jpeg,png|max:3000';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;

            return redirect()->route('landingSettings', ['tab' => $request->tab])->with(['dismiss' => $errors[0]]);
        }

        try {
            if ($request->post()) {
                $response = $this->landingRepo->saveLandingSetting($request);
                if ($response['success'] == true) {
                    return redirect()->route('landingSettings', ['tab' =>  $request->tab])->with('success', $response['message']);
                } else {
                    return redirect()->route('landingSettings', ['tab' =>  $request->tab])->withInput()->with('success', $response['message']);
                }
            }
        } catch(\Exception $e) {
            return redirect()->back()->with(['dismiss' => $e->getMessage()]);
        }

    }


    // update landing pexer feature
    public function updatePexerFeature(Request $request)
    {
        try {
            $response = $this->landingRepo->updatePexerFeature($request);
            if ($response['success'] == true) {
                return redirect()->route('landingSettings', ['tab' =>  $request->tab])->with('success', $response['message']);
            } else {
                return redirect()->route('landingSettings', ['tab' =>  $request->tab])->withInput()->with('success', $response['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['dismiss' => $e->getMessage()]);
        }
    }

    // delete pexer feature
    public function pexerFeatureDelete(Request $request)
    {
        try {
            AdminSetting::where('id',$request->feature_id)->delete();

            return response()->json(['success'=>true, 'message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'message' => 'failed']);
        }

    }

    // subscribers List
    public function subscribers(Request $request)
    {
        $data['title'] = __('Subscribers');
        if ($request->ajax()) {
            $data['items'] = Subscriber::orderBy('id', 'desc');
            return datatables()->of($data['items'])
                ->make(true);
        }

        return view('admin.settings.subscriber_list', $data);
    }

    // adminTestimonialList List
    public function adminTestimonialList(Request $request)
    {
        $data['title'] = __('Testimonial');
        if ($request->ajax()) {
            $data['items'] = Testimonial::orderBy('id', 'desc');
            return datatables()->of($data['items'])
                ->addColumn('image', function ($item) {
                    return '<img src="'.$item->image.'" width="50">';
                })
                ->addColumn('status', function ($item) {
                    return status($item->status);
                })
                ->addColumn('actions', function ($item) {
                    return '<ul class="d-flex activity-menu">
                        <li class="viewuser"><a href="' . route('adminTestimonialEdit', $item->unique_code) . '"><i class="fa fa-pencil"></i></a> </li>
                        <li class="deleteuser"><a href="' . route('adminTestimonialDelete', $item->id) . '"><i class="fa fa-trash"></i></a></li>
                        </ul>';
                })
                ->rawColumns(['actions','image'])
                ->make(true);
        }

        return view('admin.settings.testimonial.list', $data);
    }

    // View Add new faq page
    public function adminTestimonialAdd(){
        $data['title']=__('Add Testimonial');
        return view('admin.settings.testimonial.addEdit',$data);
    }

    // Create New faq
    public function adminTestimonialSave(Request $request){
        $rules = [
            'name'=>'required',
            'designation'=>'required',
            'company_name'=>'required',
            'messages'=>'required',
            'status'=>'required',
        ];
        if(!empty($request->landing_banner_img)){
            $rules['image']='image|mimes:jpg,jpeg,png|max:3000';
        }
        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            return redirect()->back()->withInput()->with(['dismiss' => $errors[0]]);
        }
        try {
            $data=[
                'designation'=>$request->designation
                ,'name'=>$request->name
                ,'company_name'=>$request->company_name
                ,'messages'=>$request->messages
                ,'status'=>$request->status
            ];
            if(empty($request->edit_id)) {
                $data['unique_code'] = uniqid().date('').time();
            }
            if(!empty($request->edit_id)) {
                $testimonial = Testimonial::where(['id' => $request->edit_id])->first();
            }
            $old_img = '';
            if(isset($request->image)) {
                if(isset($testimonial) && (!empty($testimonial->image))) {
                    $old_img = ($testimonial->image);
                }

                $data['image'] = uploadFile($request->image,path_image(),$old_img);
            }

            if(!empty($request->edit_id)){
                Testimonial::where(['id'=>$request->edit_id])->update($data);
                return redirect()->route('adminTestimonialList')->with(['success'=>__('Testimonial Updated Successfully!')]);
            }else{
                Testimonial::create($data);
                return redirect()->route('adminTestimonialList')->with(['success'=>__('Testimonial Added Successfully!')]);
            }
        } catch (\Exception $e) {
            return redirect()->route('adminTestimonialList')->with(['false'=>__('Something went wrong')]);

        }
    }

    // Edit Faqs
    public function adminTestimonialEdit($id){
        $data['title']=__('Update Testimonial');
        $data['item']=Testimonial::where('unique_code', $id)->first();

        return view('admin.settings.testimonial.addEdit',$data);
    }

    // Delete Faqs
    public function adminTestimonialDelete($id){
        if(isset($id)){
            $item = Testimonial::where(['id'=>$id])->first();
            if (!empty($item->image)) {
                $img = get_image_name($item->image);
                removeImage(path_image(),$img);
            }
            Testimonial::where(['id'=>$id])->delete();
        }

        return redirect()->back()->with(['success'=>__('Deleted Successfully!')]);
    }
    public function landingPageSettings(LandingService $landingService,Request $request){
        $page_id = $request->page_id ?? null;
        $pages = $landingService->getCustomLandingPages()->get();
        $data['settings'] = allsetting();
        $data['custom_pages'] = $this->landingService->AllCustomPages();
        foreach($pages as $page){
            if($page_id){
                if($page->id==$page_id){
                    $data['element_prefix'] = element_prefix($page->id);
                    $data['title']=$page->page_title;
                    $data['active_page_id']=$page->id;
                    $data['active_page_key']=$page->page_key;
                    $data['resource_path']=$page->resource_path;
                    $data['main_primary_color']=$page->main_primary_color;
                    $data['main_hover_color']=$page->main_hover_color;
                    $data['temp_primary_color']=$page->temp_primary_color;
                    $data['temp_hover_color']=$page->temp_hover_color;
                    $data['footer_features'] = $this->landingService->allCustomLandingFeatures($page->id)->get();
                    $selected = $this->landingService->selectedCustomLandingPages($page->id)->get();
                    $data['selected_custom_pages']=[];
                    foreach ($selected as $key=>$select){
                        $data['selected_custom_pages'][$key] = $select->custom_page_id;
                    }
                }
            }else{
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
                    $data['footer_features'] = $this->landingService->allCustomLandingFeatures($page->id)->get();
                    $selected = $this->landingService->selectedCustomLandingPages($page->id)->get();
                    $data['selected_custom_pages']=[];
                    foreach ($selected as $key=>$select){
                        $data['selected_custom_pages'][$key] = $select->custom_page_id;
                    }
                }
            }
            $data['pages'][$page->id]['page_title'] = $page->page_title;
            $data['pages'][$page->id]['page_key'] = $page->page_key;
            $data['pages'][$page->id]['resource_path'] = $page->resource_path;
        }
        $data['sections'] = $landingService->getCustomLandingSections($data['active_page_id'])->get();
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
        return view('admin.landing.landing_page_setting',$data);
    }
    public function saveAndPublish(LandingService $landingService, Request $request){
        $landing_page_id = $request->landing_page_id;
        $response = $landingService->saveAndPublish($landing_page_id);
        return response()->json($response);
    }
    public function saveSection(LandingService $landingService, Request $request){
        DB::beginTransaction();
        try{
            $sections = $landingService->getCustomLandingSections($request->landing_page_id)->get();
            foreach($sections as $section){
                if(isset($request[$section->section_key])){
                    if($section->section_key=='banner'){
                        $this->saveBanner((object)$request[$section->section_key]);
                    }elseif($section->section_key=='trade_anywhere'){
                        $this->saveTradeAnywhere((object)$request[$section->section_key]);
                    }elseif($section->section_key=='market_trend'){
                        $this->saveMarketTrend((object)$request[$section->section_key]);
                    }elseif($section->section_key=='about'){
                        $this->saveAbout((object)$request[$section->section_key]);
                    }elseif($section->section_key=='feature'){
                        $this->saveFeature((object)$request[$section->section_key]);
                    }elseif($section->section_key=='advantage'){
                        $this->saveAdvantage((object)$request[$section->section_key]);
                    }elseif($section->section_key=='process'){
                        $this->saveProcess((object)$request[$section->section_key]);
                    }elseif($section->section_key=='coin_buy_sell'){
                        $this->saveCoinBuySell((object)$request[$section->section_key]);
                    }elseif($section->section_key=='testimonial'){
                        $this->saveTestimonial((object)$request[$section->section_key]);
                    }elseif($section->section_key=='how_to_work'){
                        $this->saveWork((object)$request[$section->section_key]);
                    }elseif($section->section_key=='team'){
                        $this->saveTeam((object)$request[$section->section_key]);
                    }elseif($section->section_key=='faq'){
                        $this->saveFaq((object)$request[$section->section_key]);
                    }elseif($section->section_key=='subscribe'){
                        $this->saveSubscribe((object)$request[$section->section_key]);
                    }
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            $response = ['success'=>false,'message'=>__($exception->getMessage())];
            return response()->json($response);
        }
        DB::commit();
        $response = ['success'=>true,'message'=>__('Sections updated successfully!')];
        return response()->json($response);
    }
    public function saveBanner($request){
        return $this->landingService->saveBanner($request);
    }
    public function saveTradeAnywhere($request){
        return $this->landingService->saveTradeAnywhere($request);
    }
    public function saveMarketTrend($request){
        return $this->landingService->saveMarketTrend($request);
    }
    public function saveAbout($request){
        return $this->landingService->saveAbout($request);
    }
    public function saveFeature($request){
        return $this->landingService->saveFeature($request);
    }
    public function saveAdvantage($request){
        return $this->landingService->saveAdvantage($request);
    }
    public function saveProcess($request){
        return $this->landingService->saveProcess($request);
    }
    public function saveCoinBuySell($request){
        return $this->landingService->saveCoinBuySell($request);
    }
    public function saveTestimonial($request){
        return $this->landingService->saveTestimonial($request);
    }
    public function saveWork($request){
        return $this->landingService->saveWork($request);
    }
    public function saveTeam($request){
        return $this->landingService->saveTeam($request);
    }
    public function saveFaq($request){
        return $this->landingService->saveFaq($request);
    }
    public function saveSubscribe($request){
        return $this->landingService->saveSubscribe($request);
    }



    public function getFeatureData(Request $request){
        if($request->type=='feature'){
            $table = 'custom_landing_feature_temp';
        }elseif($request->type=='coin'){
            $table = 'custom_landing_coins_temp';
        }elseif($request->type=='team'){
            $table = 'custom_landing_teams_temp';
        }elseif($request->type=='testimonial'){
            $table = 'custom_landing_testimonial_temp';
        }elseif($request->type=='faq'){
            $table = 'custom_landing_faqs_temp';
        }elseif($request->type=='advantage'){
            $table = 'custom_landing_advantage_temp';
        }elseif($request->type=='work'){
            $table = 'custom_landing_p2p_temp';
        }else{
            $table = 'custom_landing_process_temp';
        }
        $data['detail'] = DB::table(DB::raw($table))->where('id','=',$request->id)->first();
        if(isset($data['detail']->icon)){
            $data['detail']->icon = check_storage_image_exists($data['detail']->icon);
        }else{
            $data['detail']->icon = check_storage_image_exists();
        }
        if(isset($data['detail']->image)){
            $data['detail']->image = check_storage_image_exists($data['detail']->image);
        }else{
            $data['detail']->image = check_storage_image_exists();
        }
        return response()->json($data);
    }
    public function deleteFeatureData(Request $request){
        try{
            $landing_page_id = $request->landing_page_id;
            if($request->type=='feature'){
                $table = 'custom_landing_feature_temp';
            }elseif($request->type=='coin'){
                $table = 'custom_landing_coins_temp';
            }elseif($request->type=='team'){
                $table = 'custom_landing_teams_temp';
            }elseif($request->type=='testimonial'){
                $table = 'custom_landing_testimonial_temp';
            }elseif($request->type=='faq'){
                $table = 'custom_landing_faqs_temp';
            }elseif($request->type=='advantage'){
                $table = 'custom_landing_advantage_temp';
            }elseif($request->type=='work'){
                $table = 'custom_landing_p2p_temp';
            }else{
                $table = 'custom_landing_process_temp';
            }
            DB::table(DB::raw($table))->where('id','=',$request->id)->delete();
            $data['success']=true;
            $data['new_serial'] = getLastSerialOfFeature($request->type,$landing_page_id)+1;
            $data['message']='Delete Successfully';
        }catch (\Exception $exception){
            $data['success']=false;
            $data['message']='Something went wrong!';
        }
        return response()->json($data);
    }
    public function savePrimaryColor(LandingService $landingService, Request $request){
        $response = $landingService->savePrimaryColor($request);
        $response['element_prefix'] = element_prefix($request->landing_page_id);
        return response()->json($response);
    }
    public function saveHoverColor(LandingService $landingService, Request $request){
        $response = $landingService->saveHoverColor($request);
        $response['element_prefix'] = element_prefix($request->landing_page_id);
        return response()->json($response);
    }
    public function saveFeatureDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->icon) && ($request->page_key!='custom_three')) {
            $response['success']=false;
            $response['message']='Icon missing!';
        }else{
            $response = $landingService->saveFeatureDetails($request);
            if($response['success']){
                $section_id = $request->section_id;
                $landing_page_id = $request->landing_page_id;
                $data['element_prefix'] = element_prefix($landing_page_id);
                $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                $response['show'] = $data['section_parent']->status;
            }
        }
        return response()->json($response);
    }
    public function saveProcessDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->image)) {
            $response['success']=false;
            $response['message']='Image missing!';
        }else{
            $response = $landingService->saveProcessDetails($request);
            if($response['success']){
                $section_id = $request->section_id;
                $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                $response['show'] = $data['section_parent']->status;
            }
        }
        return response()->json($response);
    }
    public function saveCoinBuySellDetails(LandingService $landingService, Request $request){
        $response = $landingService->saveCoinBuySellDetails($request);
        if($response['success']){
            $section_id = $request->section_id;
            $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
            $response['show'] = $data['section_parent']->status;
            $coin_info = Coin::find($request->coin_id);
            $response['coin_name'] = $coin_info->name;
            $response['coin_type'] = $coin_info->type;
            $response['coin_image'] = show_image_path($coin_info->image,'');
        }
        return response()->json($response);
    }
    public function saveTestimonialDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->image)) {
            $response['success']=false;
            $response['message']='Image missing!';
        }else{
            $response = $landingService->saveTestimonialDetails($request);
            if($response['success']){
                $section_id = $request->section_id;
                $landing_page_id = $request->landing_page_id;
                $response['element_prefix'] = element_prefix($landing_page_id);
                $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                $response['show'] = $data['section_parent']->status;
            }
        }
        return response()->json($response);
    }
    public function saveTeamDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->image)) {
            $response['success']=false;
            $response['message']='Image missing!';
        }else{
            $response = $landingService->saveTeamDetails($request);
            if($response['success']){
                $section_id = $request->section_id;
                $landing_page_id = $request->landing_page_id;
                $response['element_prefix'] = element_prefix($landing_page_id);
                $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                $response['show'] = $data['section_parent']->status;
            }
        }
        return response()->json($response);
    }
    public function saveWorkDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->image)) {
            $response['success']=false;
            $response['message']='Image missing!';
        }else{
            if(!$request->type){
                $response['success']=false;
                $response['message']='Type field missing!';
            }else{
                $response = $landingService->saveWorkDetails($request);
                if($response['success']){
                    $section_id = $request->section_id;
                    $landing_page_id = $request->landing_page_id;
                    $data['element_prefix'] = element_prefix($landing_page_id);
                    $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                    $response['show'] = $data['section_parent']->status;
                }
            }
        }
        return response()->json($response);
    }
    public function saveAdvantageDetails(LandingService $landingService, Request $request){
        if(!($request->id) && !isset($request->image)) {
            $response['success']=false;
            $response['message']='Image missing!';
        }else{
            $response = $landingService->saveAdvantageDetails($request);
            if($response['success']){
                $section_id = $request->section_id;
                $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
                $response['show'] = $data['section_parent']->status;
            }
        }
        return response()->json($response);
    }
    public function saveFaqDetails(LandingService $landingService, Request $request){
        $response = $landingService->saveFaqDetails($request);
        if($response['success']){
            $section_id = $request->section_id;
            $data['section_parent'] = DB::table('custom_landing_sections_temp')->where('id','=',$section_id)->first();
            $response['show'] = $data['section_parent']->status;
        }
        return response()->json($response);
    }
    public function adminCustomPageList(Request $request)
    {
        $data['title'] = __("Custom Page List");
        if ($request->ajax()) {
            $cp = CustomPage::select('id', 'title', 'key', 'description', 'status', 'created_at')->orderBy('id','ASC');
            return datatables($cp)
                ->addColumn('actions', function ($item) {
                    $html = '<input type="hidden" value="'.$item->id.'" class="shortable_data">';
                    $html .= '<ul class="d-flex">';
                    $html .= ' <li class="viewuser"><a title="Edit" href="' . route('adminCustomPageEdit', $item->id) . '"><i class="fa fa-pencil"></i></a> <span></span></li>';
                    $html .=' </ul>';
                    return $html;
                })
                ->rawColumns(['actions'])->make(true);
        }

        return view('admin.custom-page.custom-pages-list', $data);
    }

    // custom page add
    public function adminCustomPageAdd()
    {
        $data['title'] = __("Add Page");
        return view('admin.custom-page.custom-pages', $data);
    }

    // edit the custom page
    public function adminCustomPageEdit($id)
    {
        $data['title'] = __("Update Page");
        $data['cp'] = CustomPage::findOrFail($id);

        return view('admin.custom-page.custom-pages', $data);
    }

    // custom page save setting
    public function adminCustomPageSave(Request $request)
    {
        $check = $this->landingService->checkKeyCustom($request->key,$request->edit_id);
        if(!$check){
            return redirect()->back()->withInput()->with(['dismiss' => 'Duplicate Key found!']);
        }
        $rules = [
            'title' => 'required',
            'key' => 'required',
            'description' => 'required'
        ];
        $messages = [
            'title.required' => __("Title Can\'t be empty!"),
            'description.required' => __("Description Can\'t be empty!"),
            'key.required' => __("Slug Can\'t be empty!")
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors[0];

            return redirect()->back()->withInput()->with(['dismiss' => $data['message']]);
        }

        $custom_page = [
            'title' => $request->title
            , 'key' => $request->key
            , 'description' => $request->description
            , 'status' => STATUS_SUCCESS
        ];

        CustomPage::updateOrCreate(['id' => $request->edit_id], $custom_page);

        if ($request->edit_id) {
            $message = __('Custom page updated successfully');
        } else {
            $message = __('Custom Page created successfully');
        }

        return redirect()->route('adminCustomPageList')->with(['success' => $message]);
    }

    public function customPageSlugCheck(Request $request){
        return $this->landingService->customPageSlugCheck($request->except('_token'));
    }
    public function landingPageFooterSettings(){
        $data['title'] = __("Add Info.");
        $data['settings'] = allsetting();
        $data['pages'] = $this->landingService->getCustomLandingPages()->get();
        $data['custom_pages'] = $this->landingService->AllCustomPages();
        foreach($data['pages'] as $page){
            if($page->status){
                $data['features'] = $this->landingService->allCustomLandingFeatures($page->id)->get();
                $html = '';
                $html .= \Illuminate\Support\Facades\View::make('admin.settings.landing.footer_setting.feature',$data);
                $data['feature_html'] = $html;
                $selected = $this->landingService->selectedCustomLandingPages($page->id)->get();
                $data['selected_custom_pages']=[];
                foreach ($selected as $key=>$select){
                    $data['selected_custom_pages'][$key] = $select->custom_page_id;
                }
                $html = '';
                $html .= \Illuminate\Support\Facades\View::make('admin.settings.landing.footer_setting.custom_page',$data);
                $data['custom_page_html'] = $html;
            }
        }
        return view('admin.settings.landing.footer_settings', $data);
    }

    public function landingPageFooterSave(Request $request){
        $response = $this->landingService->saveFooterInfo($request);
        if($response['status']){
            return redirect()->route('landingPageFooterSettings')->with(['success' => $response['message']]);
        }
        return redirect()->route('landingPageFooterSettings')->with(['dismiss' => $response['message']]);
    }

    public function getlandingFooterInfo(Request $request){
        $data['custom_pages'] = $this->landingService->AllCustomPages();
        $data['features'] = $this->landingService->allCustomLandingFeatures($request->id)->get();
        $html = '';
        $html .= \Illuminate\Support\Facades\View::make('admin.settings.landing.footer_setting.feature',$data);
        $data['feature_html'] = $html;
        $selected = $this->landingService->selectedCustomLandingPages($request->id)->get();
        $data['selected_custom_pages']=[];
        foreach ($selected as $key=>$select){
            $data['selected_custom_pages'][$key] = $select->custom_page_id;
        }
        $html = '';
        $html .= \Illuminate\Support\Facades\View::make('admin.settings.landing.footer_setting.custom_page',$data);
        $data['custom_page_html'] = $html;
        return response()->json($data);
    }

}
