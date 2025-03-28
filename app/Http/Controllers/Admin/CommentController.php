<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query();

        if($keyword = request('search')) {
            $comments->where('comment' , 'LIKE' , "%{$keyword}%")->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'Like', "%{$keyword}%");
            });
        }

        $comments = $comments->whereapproved(1)->latest()->paginate(20);
        return view('admin.comments.all' , compact('comments'));
    }

    public function update(Request $request, Comment $comment)
    {
        $comment->update(['approved' => 1]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }

    public function unapproved()
    {
        $comments = Comment::query();

        if($keyword = request('search')) {
            $comments->where('comment' , 'LIKE' , "%{$keyword}%")->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'Like', "%{$keyword}%");
            });
        }

        $comments = $comments->whereapproved(0)->latest()->paginate(20);
        return view('admin.comments.unapprovedcomments' , compact('comments'));
    }
}
