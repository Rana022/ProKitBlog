<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        
        $posts = Post::all();
        $popular_posts = Post::withCount('comments')
                  ->withCount('favorite_to_users')
                  ->orderBy('view_count', 'desc')
                  ->orderBy('comments_count', 'desc')
                  ->orderBy('favorite_to_users_count', 'desc')
                  ->take(5)->get();
         $pending_posts = Post::where('is_approved', false)->count();
         $total_views = Post::sum('view_count');
         $authors = User::where('role_id', 2)->count();
        $author_join_today = User::where('role_id',2 )
        ->whereDate('created_at', Carbon::today())->count();
        return view('admin.dashboard');
    }
        
}
