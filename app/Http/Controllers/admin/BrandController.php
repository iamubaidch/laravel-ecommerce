<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('id', 'desc');

        if (!empty($request->get('keyword'))) {
            $brands = $brands->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $brands = $brands->orderBy('id', 'desc')->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);
        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();



            $request->session()->flash('success', 'Brand added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function edit($brandID, Request $request)
    {
        $brand = Brand::find($brandID);
        if (empty($brand)) {
            $request->session()->flash('error', 'Brand not found');
            return redirect()->route('brands.index');
        }
        return view('admin.brands.edit', compact('brand'));
    }

    public function update($brandID, Request $request)
    {

        $brand = Brand::find($brandID);
        if (empty($brand)) {
            $request->session()->flash('error', 'Brand not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Brand not found'
            ]);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $brand->id . ',id',
        ]);
        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();




            $request->session()->flash('success', 'Brand Updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Brand Updated successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function destroy($brandID, Request $request)
    {
        $brand = Brand::find($brandID);
        if (empty($brand)) {
            $request->session()->flash('error', 'Brand not found');
            return response()->json([
                'status' => true,
                'message' => 'Brand not found'
            ]);
        }

        $brand->delete();
        $request->session()->flash('success', 'Brand Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Brand deleted successfully'
        ]);
    }
}
