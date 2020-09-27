<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

class PostService
{
    public static function create()
    {
        return new static();
    }

    public function handleUploadImagePost($request)
    {   
        $image = $request->url_image;

        $image_path = '/storage/ImagePost/' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/storage/ImagePost');
        $image->move($path ,$image_path);

        return $image_path;
    }

    public function handleDeleteImagePost($post)
    {
        if(File::exists(public_path('storage/' . $post->url_image))){

            File::delete(public_path('storage/' . $post->url_image));
        }
    }
}
