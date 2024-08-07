<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subCategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->orderBy('id', 'desc')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {
            $subCategories = $subCategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subCategories = $subCategories->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }

        $subCategories = $subCategories->orderBy('id', 'desc')->paginate(10);
        return view('admin.sub_category.list', compact('subCategories'));
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
        ]);

        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();


            $request->session()->flash('success', 'Sub Category Added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category Added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($subCategoryID, Request $request)
    {
        $subCategory = SubCategory::find($subCategoryID);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Sub Category not found');
            return redirect()->route('sub-categories.index');
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit', $data);
    }

    public function update($subCategoryID, Request $request)
    {

        $subCategory = SubCategory::find($subCategoryID);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Sub Category not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Sub Category not found'
            ]);
        }


        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
        ]);
        if ($validator->passes()) {
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success', 'Sub Category Updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Sub Category Updated successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function destroy($subCategoryID, Request $request)
    {
        $subCategory = SubCategory::find($subCategoryID);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Sub Category not found');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category not found'
            ]);
        }

        $subCategory->delete();
        $request->session()->flash('success', 'Sub Category Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Sub Category deleted successfully'
        ]);
    }



}
