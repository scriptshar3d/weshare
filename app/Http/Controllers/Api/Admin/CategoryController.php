<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereRaw("1=1");

        if ($request->title_like) {
            $categories = Category::where('title', 'like', "%" . $request->title_like . "%");
        }

        return response()->json($categories->orderBy('title', 'asc')->paginate(config('constants.paginate_per_page')));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'icon' => 'required|image'
        ]);

        $category = new Category();
        $category->fill($request->all());
        
        if ($request->icon) {
            $path = $request->file('icon')->store('uploads');
            $category->icon_url = Storage::url($path);
        }

        $category->save();

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }

    public function update(Category $category, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'icon' => 'sometimes|image'
        ]);

        $category->fill($request->all());
        
        if ($request->icon) {
            $path = $request->file('icon')->store('uploads');
            $category->icon_url = Storage::url($path);
        }

        $category->save();

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }
}
