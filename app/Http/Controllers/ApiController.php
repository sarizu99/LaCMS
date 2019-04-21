<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function posts(Request $request)
    {
        $user = Auth::user();
        $start = $request->input('start');
        $length = $request->input('length');
        $search = $request->input('search.value');
        $order_column = $request->input('order.0.column');
        $order_dir = $request->input('order.0.dir');

        $posts = new \App\Post();

        $recordsTotal = $posts->count();
        
        if (!$user->is_admin) {
            $posts = $posts::where('author_id', $user->id)->skip($start)->take($length);
        } else {
            $posts = $posts::orderByRaw("author_id = " . $user->id . " DESC");
            // $othersPosts = $posts::where('author_id', '<>', $user->id);
            // $myPosts = \App\Post::where('author_id', $user->id);
            // $posts = $myPosts->union($othersPosts)->skip($start)->take($length);
        }

        switch ($order_column) {
            case 3:
                $posts = $posts->orderBy('updated_at', $order_dir);
                break;
            default:
                $posts = $posts->orderBy('updated_at', 'DESC');
                break;
        }
        
        // Search
        if ($search) {
            $posts = $posts->where('title', 'like', '%' . $search . '%');
        }
        
        $posts = $posts->skip($start)->take($length);

        $data = [];
        foreach ($posts->get() as $post) {
            $html_title = '';

            if ($post->author_id == $user->id && $user->is_admin) {
                $html_title .= '<span title="Your post" class="badge badge-warning text-white d-inline-block mr-2"><i class="fas fa-star"></i></span>';
            }

            if (!$post->published) {
                $html_title .= '<span class="badge badge-secondary d-inline-block mr-2">Draft</span>';
            }

            $html_title .= '<span class="post-title-list">'.$post->title.'</span>';
            $html_title .= '<div class="show-hover post-actions">
                    <a class="btn btn-sm btn-outline-secondary" href="' . url('/admin/post/' . $post->id . '/edit') . '">Edit</a>
                    <a class="btn btn-sm btn-outline-info"  target="_blank" href="'.url('/' . $post->slug).'">Preview</a>
                    <button class="btn btn-sm btn-danger delete-post" onclick="deletePost(this)" data-id="'.$post->id.'">Delete</button>
                </div>';
            $push = [
                $html_title,
                $post->author->name,
            ];

            $categories = [];
            foreach ($post->categories as $category) {
                array_push($categories, $category->name);
            }

            array_push($push, implode(', ', $categories));
            array_push($push, $post->updated_at->isoFormat('DD-MM-YYYY'));
            array_push($data, $push);
        }

        return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $data,
        ];

        // $user = Auth::user();
        // $start = $request->input('start');
        // $length = $request->input('length');
        // $search = $request->input('search.value');
        // $order_dir = $request->input('order.0.dir');

        // $posts = new \App\Post();
        // $recordsTotal = $posts->count();
        
        // if (!$user->is_admin) {
        //     $posts = $posts::where('author_id', $user->id)->skip($start)->take($length);
        // } else {
        //     $posts = $posts::skip($start)->take($length);
        // }
        
        // // Filter
        // if ($search) {
        //     $posts = $posts->where('title', 'like', '%' . $search . '%');
        // }
        // // End-Filter

        // $posts = $posts->orderBy('updated_at', $order_dir);

        // $data = [];
        // foreach ($posts->get() as $post) {
        //     $html_title = '
        //         <span class="post-title-list">'.$post->title.'</span>
        //         <div class="show-hover post-actions">
        //             <a href="' . url('/admin/post/' . $post->id . '/edit') . '">Edit</a>
        //             <a target="_blank" href="'.url('/' . $post->slug).'">Preview</a>
        //             <button class="delete-post" onclick="deletePost(this)" data-id="'.$post->id.'">Delete</button>
        //         </div>';
        //     $push = [
        //         $html_title,
        //         $post->author->name,
        //     ];

        //     $categories = [];
        //     foreach ($post->categories as $category) {
        //         array_push($categories, $category->name);
        //     }

        //     array_push($push, implode(', ', $categories));
        //     array_push($push, $post->updated_at);
        //     array_push($data, $push);
        // }

        // return [
        //     'draw' => $request->input('draw'),
        //     'recordsTotal' => $recordsTotal,
        //     'recordsFiltered' => $recordsTotal,
        //     'data' => $data,
        // ];
    }

    public function makePermalink(Request $request)
    {
        $permalink = $request->input('value');

        if (!\App\Post::where('slug', $permalink)->exists()) {
            return Str::slug($permalink);
        } else {
            return Str::slug($permalink . '-' . now());
        }
    }
}
