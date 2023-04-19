<?php
function actionButton($title, $imageName ,$route= NULL, $class=NULL, $id=NULL, $type=NULL ){
    $html = '<li>';
    if ($route != NULL){
        $html .= '<a data-toggle="tooltip" title="'.$title.'" href="'.$route.'" class="'.$class.'">
                    <span><img src="'.asset("assets/admin/images/user-management-icons/activity/".$imageName).'" class="img-fluid" alt=""></span>
                </a>';
    }else{
        $html .= '<a data-toggle="tooltip" title="'.$title.'" href="javascript:void(0)" class="'.$class.'" data-id="'.$id.'" data-type="'.$type.'">
                    <span><img src="'.asset("assets/admin/images/user-management-icons/activity/".$imageName).'" class="img-fluid" alt=""></span>
                </a>';
    }
    $html .= '</li>';

    return $html;
}

function dropdownButton($title,$route= NULL, $class=NULL, $id=NULL, $type=NULL ){
    if ($route !== NULL){
        $html = '<a class="dropdown-item '.$class.'" href="'.$route.'">'.$title.'</a>';
    }else{
        $html = '<a class="dropdown-item '.$class.'" href="javascript:void(0);" data-id="'.$id.'" data-type="'.$type.'">'.$title.'</a>';
    }
    return $html;
}


function active_offer($route, $id,$type)
{
    $html = '<li class="deleteuser"><a title="'.__('Active').'" href="#active_' . ($id) . '" data-toggle="modal"><span class=""><i class="fa fa-check"></i></span></a> </li>';
    $html .= '<div id="active_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title text-success">' . __('Activate') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Active ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success" href="' . route($route,[$id,$type]) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
function deactive_offer($route, $id,$type)
{
    $html = '<li class="deleteuser"><a title="'.__('Deactive').'" href="#deactive_' . ($id) . '" data-toggle="modal"><span class=""><i class="fa fa-check-circle-o"></i></span></a> </li>';
    $html .= '<div id="deactive_' . ($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title text-danger">' . __('Deactivate') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to deactive ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-warning" href="' . route($route, [$id,$type]) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

if(!function_exists('gauth_html')) {
    function gauth_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Remove gauth') . '" href="#remove_gauth_' . ($id) . '" data-toggle="modal"><span class=""><img src="' . asset("assets/admin/images/user-management-icons/activity/check-square.svg") . '" class="img-fluid" alt=""></span></a> </li>';
        $html .= '<div id="remove_gauth_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Remove Gauth') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to remove gauth ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}


if(!function_exists('getActionHtml')) {
    function getActionHtml($list_type, $user_id, $item)
    {

        $html = '<div class="activity-icon"><ul>';
        if ($list_type == 'active_users') {
            $html .= '
                   <li><a title="' . __('View') . '" href="' . route('adminUserProfile') . '?id=' . ($user_id) . '&type=view" class="user-two"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/view.svg") . '" class="img-fluid" alt=""></span></a></li>
                   <li><a title="' . __('Edit') . '" href="' . route('admin.UserEdit') . '?id=' . ($user_id) . '&type=edit" class="user-two"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/user.svg") . '" class="img-fluid" alt=""></span></a></li>
                   <li>' . suspend_html('admin.user.suspend', ($user_id)) . '</li>';
            if (!empty($item->google2fa_secret)) {
                $html .= '<li>' . gauth_html('admin.user.remove.gauth', ($user_id)) . '</li>';
            }
            $html .= '<li>' . delete_html('admin.user.delete', ($user_id)) . '</li>';

        } elseif ($list_type == 'suspend_user') {
            $html .= '<li><a title="' . __('View') . '" href="' . route('admin.UserEdit') . '?id=' . ($user_id) . '&type=view" class="view"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/view.svg") . '" class="img-fluid" alt=""></span></a></li>
              <li><a data-toggle="tooltip" title="Activate" href="' . route('admin.user.active', ($user_id)) . '" class="check"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/check-square.svg") . '" class="img-fluid" alt=""></span></a></li>
             ';

        } elseif ($list_type == 'deleted_user') {
            $html .= '<li><a title="' . __('View') . '" href="' . route('admin.UserEdit') . '?id=' . ($user_id) . '&type=view" class="view"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/view.svg") . '" class="img-fluid" alt=""></span></a></li>
              <li><a data-toggle="tooltip" title="Activate" href="' . route('admin.user.active', ($user_id)) . '" class="check"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/check-square.svg") . '" class="img-fluid" alt=""></span></a></li>
             ';

        }
        $html .= '</ul></div>';
        return $html;
    }
}

// Html render
/**
 * @param $route
 * @param $id
 * @return string
 */
if(!function_exists('edit_html')) {
    function edit_html($route, $id)
    {
        $html = '<li class="viewuser"><a title="' . __('Edit') . '" href="' . route($route, ($id)) . '"><i class="fa fa-pencil"></i></a></li>';
        return $html;
    }
}


/**
 * @param $route
 * @param $id
 * @return string
 * @throws Exception
 */

if(!function_exists('receipt_view_html')) {
    function receipt_view_html($image_link)
    {
        $num = random_int(1111111111,9999999999999);
        $html = '<div class="deleteuser"><a title="'.__('Bank receipt').'" href="#view_' . $num . '" data-toggle="modal">Bank Deposit</a> </div>';
        $html .= '<div id="view_' . $num . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-lg">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Bank receipt') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><img src="'.$image_link.'" alt=""></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('delete_html')) {
    function delete_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('delete') . '" href="#delete_' . ($id) . '" data-toggle="modal"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/delete-user.svg") . '" class="img-fluid" alt=""></span></a> </li>';
        $html .= '<div id="delete_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to delete ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}
if(!function_exists('delete_html2')) {
    function delete_html2($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('delete') . '" href="#delete_' . ($id) . '" data-toggle="modal"><span><i class="fa fa-trash"></i></span></a> </li>';
        $html .= '<div id="delete_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to delete ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('suspend_html')) {
    function suspend_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Suspend') . '" href="#suspends_' . ($id) . '" data-toggle="modal"><span><img src="' . asset("assets/admin/images/user-management-icons/activity/block-user.svg") . '" class="img-fluid" alt=""></span></a> </li>';
        $html .= '<div id="suspends_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Suspend') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to suspend ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('active_html')) {
    function active_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Active') . '" href="#active_' . ($id) . '" data-toggle="modal"><span class="flaticon-delete"></span></a> </li>';
        $html .= '<div id="active_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Activate') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to Active ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('accept_html')) {
    function accept_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Accept') . '" href="#accept_' . decrypt($id) . '" data-toggle="modal"><span class=""><i class="fa fa-check-circle-o" aria-hidden="true"></i>
    </span></a> </li>';
        $html .= '<div id="accept_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Accept') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to Accept ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('reject_html')) {
    function reject_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Reject') . '" href="#reject_' . decrypt($id) . '" data-toggle="modal"><span class=""><i class="fa fa-minus-square" aria-hidden="true"></i>
    </span></a> </li>';
        $html .= '<div id="reject_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Reject') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to Reject ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}
/**
 * @param $route
 * @param $id
 * @return string
 */
if(!function_exists('ChangeStatus')) {
    function ChangeStatus($route, $id)
    {
        $html = '<li class=""><a href="#status_' . $id . '" data-toggle="modal"><i class="fa fa-ban"></i></a> </li>';
        $html .= '<div id="status_' . $id . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to Block this product ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

/**
 * @param $route
 * @param $id
 * @return string
 */
if(!function_exists('BlockStatusChange')) {
    function BlockStatusChange($route, $id)
    {
        $html = '<ul class="activity-menu">';
        $html .= '<li class=" "><a title="' . __('Status change') . '" href="#blockuser' . $id . '" data-toggle="modal"><i class="fa fa-check"></i></a> </li>';
        $html .= '<div id="blockuser' . $id . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to Unblock this product ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-success"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</ul>';

        return $html;
    }
}

/**
 * @param $route
 * @param $param
 * @return string
 */
if(!function_exists('delete_html')) {
    function cancelSentItem($route, $param)
    {
        $html = '<li class=""><a title="' . __('Cancel') . '" class="delete" href="#blockuser' . $param . '" data-toggle="modal"><i class="fa fa-remove"></i></a> </li>';
        $html .= '<div id="blockuser' . $param . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Cancel') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to cancel this product ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-success"href="' . route($route) . $param . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';


        return $html;
    }
}



if(!function_exists('view_html')) {
    function view_html($route, $id)
    {
//    $img = asset('assets/images/action-icon/details.jpg');
        $html = '<li class="viewuser"><a href="' . route($route, encrypt($id)) . '"><i class="fa fa-eye"></i></a> <span>' . __('View') . '</span></li>';
        return $html;
    }
}

if(!function_exists('clear_html')) {
    function clear_html($route, $id)
    {
        $html = '<li class="deleteuser"><a title="' . __('Clear All') . '" href="' . route($route, $id) . '" ><span>' . __('Clear All') . '</span></a> </li>';
        $html .= '<div id="clear_' . ($id) . '" class="modal fade delete" role="dialog">';
        $html .= '<div class="modal-dialog modal-sm">';
        $html .= '<div class="modal-content">';
        $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Clear All') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
        $html .= '<div class="modal-body"><p>' . __('Do you want to clear all ?') . '</p></div>';
        $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
        $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

if(!function_exists('transaction_url')) {
    function transaction_url($hash, $path)
    {
        $html = '<a class="" target="_blank" href="' . env('TRANSACTION_CHECK_URL') . $path . '/' . $hash . '">' . $hash . '</a>';
        return $html;
    }
}

if(!function_exists('transaction_url_min')) {
    function transaction_url_min($hash, $path, $first, $last)
    {
        $html = '<a class="" title="' . $hash . '" target="_blank" href="' . env('TRANSACTION_CHECK_URL') . $path . '/' . $hash . '">' . $first . '....' . $last . '</a>';
        return $html;
    }
}
