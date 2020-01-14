<?php

namespace App\Http\Controllers\Author;

use Brian2694\Toastr\Facades\Toastr;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store()
    {
        $comments = Comment::latest()->get();
        return view('author.comments', compact('comments'));
    }
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        toastr::success('Your Comment Successfully Deleted ;)', 'success');
        return redirect()->back();
    }
}
