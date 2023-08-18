<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        Category::create($data);
        return redirect(route('admin.setting.index'))->with('success', true);
    }

    public function edit(Category $category)
    {
        return view('admin.setting.index', [
            'lists' => Category::with('admin')->paginate(env('PER_PAGE')),
            'data' => $category
        ]);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        $category->update($data);
        return redirect(route('admin.setting.index'))->with('success', true);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Throwable $th) {
            if($th instanceof QueryException) {
                return to_route('admin.setting.index')->withErrors([
                    'delete-failed' => __("Category already in use")
                ]);
            }
        }
        return to_route('admin.setting.index');
    }
}
