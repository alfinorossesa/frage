<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileService
{
    public function updatingProfile($user, $request)
    {
        $user->update([
            'name' => $request->name,
            'username' => Str::slug($request->name, '-'),
            'email' => $request->email
        ]);

        // update picture            
        if($request->hasFile('picture')){
            if ($user->picture !== null) {
                File::delete('assets/profile-picture/'.$user->picture);
            }
            $picture = $request->file('picture');
            $picture_name = time()."_".$picture->getClientOriginalName();
            $picture->move('assets/profile-picture/',$picture_name);
            $user->picture = $picture_name;
            $user->update();            
        }

        return $user;
    }

    public function reach($user)
    {
        $reach = 0;
        foreach ($user->question as $value) {
            $reach += $value->view_count;
        }

        return $reach;
    }
}