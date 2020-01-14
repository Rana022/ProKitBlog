<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function post($slug){
        $post = Post::where('slug', $slug)->first();
        $randompost = Post::approved()->status()->take(3)->inRandomOrder()->get();
        $postKey = 'blog_'.$post->id;
        if (!Session::has($postKey)) {
            $post->increment('view_count');
            Session::put($postKey,1);
        }
      return view('post', compact('post', 'randompost'));
    }
    public function allPost(){
      $posts = Post::latest()->approved()->status()->paginate(12);
      return view('posts', compact('posts'));
    }
    public function postByCategory($slug){
       $category = Category::where('slug', $slug)->first();
       $posts = $category->posts()->approved()->status()->get();
       return view('category_posts', compact('category','posts'));
    }

  public function postByTag($slug){
    $tag = Tag::where('slug', $slug)->first();
    $posts = $tag->posts()->approved()->status()->get();
    return view('tag_posts', compact('tag', 'posts'));
  }

}
