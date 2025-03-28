<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query();

        if($keyword = request('search')) {
            $categories->where('name' , 'LIKE' , "%{$keyword}%");
        }

        $categories = $categories->where('parent', 0)->latest()->paginate(20);
        return view('admin.categories.all' , compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if($request->parent) {
            $request->validate([
               'parent' => 'exists:categories,id'
            ]);
        }

        $request->validate([
            'name' => 'required|min:3'
        ]);

        Category::create([
            'name' => $request->name,
            'parent' => $request->parent ?? 0
        ]);

        return redirect(route('admin.categories.index'));
    }
    
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit' , compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        if($request->parent) {
            $request->validate([
                'parent' => 'exists:categories,id'
            ]);
        }

        $request->validate([
            'name' => 'required|min:3'
        ]);


        if($category->parent === 0) {
            $request->parent = 0;
        }

        $category->update([
            'name' => $request->name,
            'parent' => $request->parent
        ]);

        return redirect(route('admin.categories.index'));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back();
    }
}
