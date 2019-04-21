<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index ()
    {
        $data = [
            'title' => 'Categories',
            'categories' => \App\Category::orderBy('id', 'desc')->get(),
        ];

        return view('admin/category', $data);
    }

    public function update(Request $request, $id)
    {
        $slug = $request->input('slug');
        $name = $request->input('name');

        if (\App\Category::where(function($query) use ($id, $slug, $name) {
                $query->where('id', '<>', $id);
                $query->where('slug', $slug);
            })
            ->orWhere(function($query) use ($id, $slug, $name) {
                $query->where('id', '<>', $id);
                $query->where('name', $name);
            })
            ->exists()
        ) {
            return redirect('/admin/category')
                ->with(
                    'danger',
                    'Update failed. Category name and slug must be unique!'
                );
        }
        
        \App\Category::find($id)
            ->update([
                'name' => $name,
                'slug' => $slug,
            ]);
                
        return redirect('/admin/category')->with('success', 'Data updated');
    }
    
    public function store(Request $request)
    {
        $slug = $request->input('slug');
        $name = $request->input('name');

        if (\App\Category::where('slug', $slug)
            ->orWhere('name', $name)->exists()
        ) {
            return redirect('/admin/category')
                ->with(
                    'danger',
                    'Creation failed. Category name or slug is exists.'
                );
        }
        
        \App\Category::create([
                'name' => $name,
                'slug' => $slug,
            ]);
                
        return redirect('/admin/category')->with('success', 'Data added');
    }

    public function destroy($id)
    {
        \App\Category::find($id)->delete();
        
        return redirect('/admin/category')->with('success', 'Data deleted');
    }

}
