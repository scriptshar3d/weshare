<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::sortable(['title' => 'asc']);
        if($request->search) {
            $categories = $categories->where('title', 'like', '%' . $request->search . '%');
        }
        return view('admin.categories.index', ['categories' => $categories->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'icon' => 'required|image'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        // store icon file
        $iconUrl = Storage::url($request->file('icon')->store('uploads'));

        // create category
        $category = new Category();
        $category->title = $request->get('title');
        $category->icon_url = $iconUrl;

        $category->save();

        return redirect()->intended(route('admin.categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'icon' => 'image'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $category->title = $request->get('title');

        if($request->file('icon')) {
            // store icon file
            $iconUrl = Storage::url($request->file('icon')->store('uploads'));
            $category->icon_url = $iconUrl;
        }

        $category->save();

        return redirect()->intended(route('admin.categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('admin.categories'));
    }
}
