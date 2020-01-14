<?php

namespace App\Http\Controllers\Admin;
use Brian2694\Toastr\Facades\Toastr;
use App\Tag;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $categories = Category::all();
        $tags =Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $ext = $image->getClientOriginalExtension();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$ext;
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            $imageSize = Image::make($image)->resize(1666, 1060)->stream();
            Storage::disk('public')->put('post/'.$imageName, $imageSize);
        }else{
            $imageName = 'default.png';
        }
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();
        $post->tags()->attach($request->tags);
        $post->categories()->attach($request->categories);
        toastr::success('Your Post Successfully Added', 'success');
        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {   $categories = Category::all();
        $tags = Tag::all();
        return view ('admin.post.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $ext = $image->getClientOriginalExtension();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $ext;
            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            if (Storage::disk('public')->exists('post/'.$post->image)) {
                Storage::disk('public')->delete('post/' . $post->image);
            }
            $imageSize = Image::make($image)->resize(1666, 1060)->stream();
            Storage::disk('public')->put('post/' . $imageName, $imageSize);
        } else {
            $imageName = $post->image;
        }
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);
        toastr::success('Your Post Successfully Updated :)', 'success');
        return redirect()->route('admin.post.index');
    }
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }
    public function pendingPost()
    {
        $posts =  Post::where('is_approved', false)->get();
        return view('admin.post.pending', compact('posts'));
    }
    public function approvePost($id)
    {   
        $post = Post::find($id);
        if ($post->is_approved == false) {
            $post->is_approved = true;
            $post->save();
            toastr::success('Post Successfully Approved :)', 'success');
        }else{
            toastr::info('Post already Approved ;)', 'info');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        toastr::success('Post Successfully Deleted', 'success');
        return redirect()->back();
    }
}
