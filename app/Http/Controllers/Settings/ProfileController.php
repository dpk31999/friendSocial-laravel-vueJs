<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($request->only('name','username', 'email','country','city','date_of_birth','status','phone','link_fb'));
    }

    public function updateAva(Request $request)
    {
        $this->validate($request,[
            'url_avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $this->deleteAvatarExist($request->user());

        $image = $this->handleUpdateAva($request);

        $request->user()->url_avatar = $image;
        $request->user()->save();

        return response()->json($image, 200);
    }

    public function handleUpdateAva($request)
    {
        $imageService = ImageService::create();

        $image = $imageService->handleUpdateAvatar($request);

        return $image;
    }

    public function deleteAvatarExist($user)
    {
        $imageService = ImageService::create();

        $image = $imageService->handleDeleteAvatar($user);
    }
}
