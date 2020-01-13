<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('id','DESC')->get();

        $id = Category::latest()->first();
        if (isset($id)){
            $code = $id->id + 1;
        return view('categories.index',compact('category', 'code'));
        }
        return view('categories.index',compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:category,code',
            'name' => 'required|unique:category,name',
        ]);
        $category = Category::create(['code' => $request->input('code'),'name' => $request->input('name')]);
        return redirect()->route('category')
            ->with('success','Category created successfully');
    }

    public function edit($id)
    {
        $cate_id = Category::findOrFail($id);
        $category = Category::orderBy('id','DESC')->get();
        return view('categories.edit', compact('cate_id', 'category'));
    }

    public function update(Request $request, $id)
    {
        $update_category = Category::find($id);
        $update_category->code = $request->input('code');
        $update_category->name = $request->input('name');
        $update_category->save();

        return redirect()->route('category')
            ->with('success','Category updated successfully');
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('category')
            ->with('success','Category deleted successfully');
    }
    
}
