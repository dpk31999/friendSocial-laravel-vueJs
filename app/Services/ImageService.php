<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

class ImageService
{
    public static function create()
    {
        return new static();
    }

    public function handleUpdateAvatar($request)
    {   
        $image = $request->url_avatar;

        $image_path = '/storage/ImageAvatar/' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/storage/ImageAvatar');
        $image->move($path ,$image_path);

        return $image_path;
    }

    public function handleDeleteAvatar($user)
    {
        if(File::exists(public_path($user->url_avatar))){

            File::delete(public_path($user->url_avatar));
        }
    }
}
