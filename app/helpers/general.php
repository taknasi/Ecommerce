<?php

use Illuminate\Support\Facades\File;

function getFolder()
{
    return app()->getLocale() === "ar" ? "css-rtl" : "css";
}

define('pagination_count', 15);

function uploadPhoto($dossier, $photo)
{
    $photo->store('/', $dossier);
    $fileName = $photo->hashName();
    return $fileName;
}

function getPhoto($dossier,$val){
    return $val!==null ? asset('assets/images/'.$dossier.'/'.$val): "";
}

function deletePhoto($dossier,$val){
    if(File::exists('assets/images/'.$dossier.'/'.$val)) {
        File::delete('assets/images/'.$dossier.'/'.$val);
    }
}

function isActive($bol)
{
    return $bol == true ? 'مفعل'  : 'غير مفعل';
}
