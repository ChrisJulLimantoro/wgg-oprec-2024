<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function upload($path)
    {
        // dd(Storage::disk('public'));
        if(Storage::disk('public')->exists("uploads/".$path)){
            $content = Storage::disk('public')->get('uploads/'.$path);
            $mime = explode('.',$path)[1];
            $array_mime     = [
                'css'   => 'text/css',
                'sccs'  => 'text/less',
                'json'  => 'application/json',
                'pdf'   => 'application/pdf',
                'png'   => 'image/png',
                'jpg'   => 'image/jpeg',
                'jpeg'  => 'image/jpeg',
                'gif'   => 'image/gif',
                'ico'   => 'image/x-icon',
                'map'   => 'application/octet-stream',
                'eot'   => 'application/vnd.ms-fontobject',
                'svg'   => 'image/svg+xml',
                'svgz'  => 'image/svg+xml',
                'bmp'   => 'image/x-bmp',
                'webp'  => 'image/webp',
                'ttf'   => 'font/ttf',
                'woff'  => 'font/woff',
                'woff2' => 'font/woff2',
                'otf'   => 'font/opentype',
                'avi'   => 'video/avi',
                'mp4'   => 'video/mp4',
                '3gp'   => 'video/3gpp',
                'webm'  => 'video/webm',
                'webmanifest' => 'application/manifest+json',
                'txt' => 'text/plain'
            ];
            if(array_key_exists($mime,$array_mime)){
                $mime = $array_mime[$mime];
            }else{
                $mime = 'text/plain';
            }

            return response($content)->header('Content-Type',$mime);
        }else{
            return abort(404);
        }
    }
}
