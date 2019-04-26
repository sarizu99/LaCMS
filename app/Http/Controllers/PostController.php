<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function homepage()
    {
        $ss = \App\SiteSetting::first();

        $data = [
            'title' => $ss->name,
            'posts' => \App\Post::select('*')
                ->where('published', 1)
                ->addSelect(DB::raw('substring(strip_tags(content), 1, ' . \App\SiteSetting::first()->snippet_length . ') as content'))
                ->orderBy('updated_at', 'desc')
                ->paginate(\App\SiteSetting::first()->show_at_most),
        ];

        return view('home', $data);
    }
    
    public function index()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Posts',
            'user' => $user,
        ];

        return view('admin/post', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'New Post',
            'categories' => \App\Category::all()
        ];

        return view('admin/post-new', $data);
    }

    public function store(Request $request)
    {

        $v = $request->validate([
            'title' => 'required|max:190',
            'content' => 'nullable',
        ]);
        
        $user = Auth::user();
        
        $thumbnail = null;

        if ($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('public/thumbnails');
        }

        $categoriesInput = $request->input('categories') ?: [];

        $slug = Str::slug($request->input('title'));
        
        if (\App\Post::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $new_post = \App\Post::create([
            'title'         => $request->input('title'),
            'slug'          => $slug,
            'author_id'     => $user->id,
            'content'       => $request->input('content'),
            'thumbnail'     => str_replace('public/', 'storage/', $thumbnail),
            'published'     => $request->input('published'),
            'comments_enabled'  => $request->input('comments'),
            'updated_at'    => DB::raw('now()'),
        ]);

        // Add categories
        foreach ($categoriesInput as $c) {
            \App\PostsCategory::create([
                'post_id' => $new_post->id,
                'category_id' => $c
            ]);
        }

        // Add new categories & add to post
        foreach ($request->input('new_categories') as $nc) {
            if (!empty($nc) && !\App\Category::where('name', $nc)->exists()) {
                $newly_added_category = \App\Category::create([
                    'name' => $nc,
                    'slug' => Str::slug($nc),
                ]);

                \App\PostsCategory::create([
                    'post_id' => $new_post->id,
                    'category_id' => $newly_added_category->id,
                ]);
            } else if (
                \App\Category::where('name', $nc)->exists() &&
                !\App\PostsCategory::where([
                    'category_id' => \App\Category::where('name', $nc)->first()->id,
                    'post_id' => $new_post->id,
                ])->exists()
            ) {
                \App\PostsCategory::create([
                    'post_id' => $new_post->id,
                    'category_id' => \App\Category::where('name', $nc)->first()->id,
                ]);
            }
        }

        return redirect('/admin/post/' . $new_post->id . '/edit')->with('msg', 'Success!');
    }

    public function show($slug)
    {
        $post = \App\Post::where([
            'slug' => $slug,
            'published' => 1
        ]);
        
        if (!$post->exists()) {
            return abort(404);
        }

        $data = [
            'title' => $post->first()->title . ' | ' . \App\SiteSetting::first()->name,
            'post' => $post->first(),
        ];
        
        $post->update(['views' => $post->first()->views + 1]);

        return view('post', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Post',
            'post'  => \App\Post::find($id),
            'categories' => \App\Category::select('id', 'name')->get(),
        ];

        return view('admin/post-edit', $data);
    }

    public function update(Request $request, $id)
    {
        $v = $request->validate([
            'title' => 'required|max:190',
            'content' => 'nullable',
        ]);

        $thumbnail = null;

        if ($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('public/thumbnails');
        }

        $categoriesInput = $request->input('categories') ?: [];

        $post = \App\Post::find($id);

        Storage::disk('local')->delete(str_replace('storage/', 'public/', $post->thumbnail));

        $post->update([
            'title'         => $request->input('title'),
            'slug'          => $request->input('slug'),
            'content'       => $request->input('content'),
            'thumbnail'     => str_replace('public/', 'storage/', $thumbnail),
            'published'     => $request->input('published'),
            'comments_enabled'  => $request->input('comments'),
            'updated_at'    => DB::raw('now()'),
        ]);

        // Add categories
        foreach ($categoriesInput as $c) {
            if (!\App\PostsCategory::where([
                'post_id' => $id,
                'category_id' => $c
            ])->exists()) {
                \App\PostsCategory::create([
                    'post_id' => $id,
                    'category_id' => $c
                ]);
            }
        }

        // Delete categories
        $submitted_categories = collect($categoriesInput);
        $post_categories = \App\PostsCategory::where('post_id', $id)->get();

        foreach ($post_categories as $post_category) {
            if (!$submitted_categories->contains($post_category->category_id)) {
                \App\PostsCategory::where([
                    'post_id' => $id,
                    'category_id' => $post_category->category_id
                ])->delete();
            }
        }

        // Add new categories & add to post
        foreach ($request->input('new_categories') as $nc) {
            if (!empty($nc) && !\App\Category::where('name', $nc)->exists()) {
                $newly_added_category = \App\Category::create([
                    'name' => $nc,
                ]);

                \App\PostsCategory::create([
                    'post_id' => $id,
                    'category_id' => $newly_added_category->id,
                ]);
            } else if (
                \App\Category::where('name', $nc)->exists() &&
                !\App\PostsCategory::where([
                    'category_id' => \App\Category::where('name', $nc)->first()->id,
                    'post_id' => $id,
                ])->exists()
            ) {
                \App\PostsCategory::create([
                    'post_id' => $id,
                    'category_id' => \App\Category::where('name', $nc)->first()->id,
                ]);
            }
        }

        return redirect('/admin/post/' . $id . '/edit')->with('msg', 'Update success!');
    }

    public function destroy($id)
    {
        \App\Post::find($id)->delete();

        return redirect(route('post.index'))->with('delete', 'Post deleted!');
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        $data = [
            'title' => 'Search results of ' . $q,
            'posts' => \App\Post::select('*')
                ->where('published', 1)
                ->where('title', 'like', '%' . $q . '%')
                ->addSelect(DB::raw('substring(strip_tags(content), 1, ' . \App\SiteSetting::first()->snippet_length . ') as content'))
                ->orderBy('updated_at', 'desc')
                ->paginate(\App\SiteSetting::first()->show_at_most),
        ];

        return view('search', $data);
    }
   
    public function category($category)
    {
        $cat = \App\Category::where('slug', $category);

        abort_if(!$cat->exists(), 404);

        $data = [
            'title' => $category,
            'category' => $category,
            'posts' => \App\Post::select('*')
                ->addSelect(DB::raw('substring(strip_tags(content), 1, ' . \App\SiteSetting::first()->snippet_length . ') as content'))
                ->where('published', 1)
                ->whereHas('categories', function($query) use ($category) {
                    $query->where('slug', $category);
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(\App\SiteSetting::first()->show_at_most),
        ];

        return view('category', $data);
    }
}
