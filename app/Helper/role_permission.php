<?php

use App\Services\RolePermissionService;

if(!function_exists('getAllMenus')){
    function getAllMenus(){
        return RolePermissionService::getMenu();
    }
}
if(!function_exists('getAllSubMenus')){
    function getAllSubMenus($menu){
        return RolePermissionService::getSubMenu($menu);
    }
}

if(!function_exists('getPermissionField')){
    function getPermissionField(){
        return RolePermissionService::permission(true);
    }
}

include('customView.php');
