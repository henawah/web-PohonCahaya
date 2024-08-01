<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function checkSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories,slug|max:255',
            'image' => 'image|file|max:1024',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($request->name);
        }
        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images', 'public');
        }

        Category::create($validatedData);

        return redirect('/dashboard/categories')->with('success', 'New category has been added');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024',
        ]);

        $category->update([
            'name' => $request->name,
        ]);
        if ($request->file('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-images', 'public');
        }
        $category->update($validatedData);

        return redirect('/dashboard/categories')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::delete($category->image);
        }
        $category->delete();

        return redirect('/dashboard/categories')->with('success', 'Category deleted successfully');
    }
}