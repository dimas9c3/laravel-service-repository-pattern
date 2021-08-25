<?php

use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

function getDateTimeNow($format = null)
{
    return Carbon::now();
}

function buildParamModel($type = 'array')
{
    switch ($type) {
        case 'array':
            $default = array();
            break;
        case 'string':
            $default = "";
            break;
    }

    $array = array(
        "filter"    => $default,
        "columns"   => $default,
        "limit"     => $default,
        "sort"      => $default,
        "offset"    => $default,
        "group "    => $default
    );

    return $array;
}

function isDataNotEmpty($value)
{
    return (isset($value) && !empty($value));
}

function uploadImage($file, $dest_folder)
{
    if (!file_exists($dest_folder)) {
        mkdir($dest_folder, 0700, true);
    }

    $filename_with_extension = $file->getClientOriginalName();
    $filename = pathinfo($filename_with_extension, PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    $filename_to_store = $filename.'_'.uniqid().'.'.$extension;
    $filepath = $dest_folder.$filename_to_store;

    $image = Image::make($file->getRealPath());
    $image->save($filepath);

    return $filename_to_store;
}
