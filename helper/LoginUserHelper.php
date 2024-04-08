<?php
if(!function_exists('isLoginUser')){
    function isLoginUser(){
        $sessionUsername = getSessionUsername();
        $sessionIdUser   = getSessionIdUser();
        // $sessionRoleID = getSessionRoleID();
        if(empty($sessionUsername) || is_null($sessionIdUser)){
            return false;
        }
        return true;
    }
}