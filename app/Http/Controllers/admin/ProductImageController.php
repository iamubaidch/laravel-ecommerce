<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();


        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = "Null";
        $productImage->save();

        $ImageName = $request->product_id . '-' . $productImage->id . '-' . time() . '.' . $ext;
        $productImage->image = $ImageName;
        $productImage->save();

        $destPath = public_path() . '/uploads/product/large/' . $ImageName;
        File::copy($sourcePath, $destPath);


        $thumb_dest_Path = public_path() . '/uploads/product/small/' . $ImageName;
        $manager = new ImageManager(new Driver());

        $image = $manager->read($sourcePath);
        $image->cover(300, 300);
        $image->save($thumb_dest_Path);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'image_path' => asset('/uploads/product/small/' . $ImageName),
            'message' => 'Image uploaded successfully'
        ]);
    }

    public function destroy(Request $request)
    {
        $productImage = ProductImage::find($request->id);


        if (empty($productImage)) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ]);
        }


        File::delete(public_path() . '/uploads/product/large/' . $productImage->image);
        File::delete(public_path() . '/uploads/product/small/' . $productImage->image);

        $productImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
