<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\TempImage;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('id', 'desc')->with('product_images');

        if (!empty($request->get('keyword'))) {
            $products = $products->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        $products = $products->orderBy('id', 'desc')->paginate(10);

        return view('admin.products.list', compact('products'));
    }

    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.products.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
            $product->save();

            // Save product images
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {

                    $tempImage = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = "Null";
                    $productImage->save();

                    $newImageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                    $productImage->image = $newImageName;
                    $productImage->save();

                    $sourcePath = public_path() . '/temp/' . $tempImage->name;
                    $destPath = public_path() . '/uploads/product/large/' . $newImageName;
                    File::copy($sourcePath, $destPath);


                    $thumb_dest_Path = public_path() . '/uploads/product/small/' . $newImageName;
                    $manager = new ImageManager(new Driver());

                    $image = $manager->read($sourcePath);
                    $image->cover(300, 300);
                    $image->save($thumb_dest_Path);

                }
            }

            $request->session()->flash('success', 'Product added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }

    }

    public function edit($productID, Request $request)
    {
        $product = Product::find($productID);
        if (empty($product)) {
            // $request->session()->flash('error', 'Product not found');
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $productImages = ProductImage::where('product_id', $product->id)->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subCategories = SubCategory::where('category_id', $product->category_id)
            ->orderBy('name', 'ASC')
            ->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        $relatedProducts = [];
        if ($product->related_products != '') {
            $prodctArray = explode(',', $product->related_products);

            $relatedProducts = Product::whereIn('id', $prodctArray)->get();
        }

        $data = [];
        $data['productImages'] = $productImages;
        $data['categories'] = $categories;
        $data['subCategories'] = $subCategories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        return view('admin.products.edit', $data);
    }


    public function update($productID, Request $request)
    {
        $product = Product::find($productID);
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug, ' . $product->id . ',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku, ' . $product->id . ',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';

            $product->save();

            $request->session()->flash('success', 'Product Updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Product Updated successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }

    }

    public function destroy($id, Request $request)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Product not found');
            return response()->json([
                'status' => true,
                'notFound' => true,
                'message' => 'Product not found'
            ]);
        }


        $productImages = ProductImage::where('product_id', $id)->get();
        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete(public_path() . '/uploads/product/large/' . $productImage->image);
                File::delete(public_path() . '/uploads/product/small/' . $productImage->image);
            }


            ProductImage::where('product_id', $id)->delete();
        }


        $product->delete();

        $request->session()->flash('success', 'Product Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);

    }

    public function relatedProducts(Request $request)
    {
        $tempProduct = [];
        if ($request->term != "") {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();

            if ($products != null) {
                foreach ($products as $product) {
                    $tempProduct[] = array('id' => $product->id, 'text' => $product->title);
                }

            }
        }

        return response()->json([
            'tags' => $tempProduct,
            'status' => true


        ]);
    }


}
