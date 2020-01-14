<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add($id)
    {
        $user = Auth::user();
        $isFavourite = $user->favorite_posts()->where('post_id', $id)->count();
        if($isFavourite == 0){
            $user->favorite_posts()->attach($id);
            toastr::success('Post Successfully added to Favorite List','success');
            return redirect()->back();
        }else{
            $user->favorite_posts()->detach($id);
            toastr::success('Post Successfully removed to Favorite List', 'success');
            return redirect()->back();
        }
    }
}
