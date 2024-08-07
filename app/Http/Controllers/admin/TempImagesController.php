<?php

namespace App\Http\Controllers\admin;

use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// class TempImagesController extends Controller
// {
//     public function create(Request $request)
//     {

//         if (!empty($image)) {

//             $image = $request->image;
//             $ext = $image->getClientOriginalExtension();
//             $newName = time() . '.' . $ext;

//             $tempImage = new TempImage();
//             $tempImage->name = $newName;
//             $tempImage->save();

//             $image->move(public_path() . '/temp', $newName);

//             $manager = new ImageManager(new Driver());
//             $sourcePath = public_path() . '/temp/' . $newName;
//             $destinationPath = public_path() . '/temp/thumb/' . $newName;
//             $image = $manager->read($sourcePath);
//             $image->cover(300, 275);
//             $image->save($destinationPath);

//             return response()->json([
//                 'status' => true,
//                 'image_id' => $tempImage->id,
//                 'image_path' => asset('/temp/thumb/' . $newName),
//                 'message' => 'Image uploaded successfully'
//             ]);
//         }
//     }
// }


class TempImagesController extends Controller
{
    public function create(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Corrected how the image is accessed
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '.' . $ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path('/temp'), $newName);

            $manager = new ImageManager(new Driver());
            $sourcePath = public_path('/temp/' . $newName);
            $destinationPath = public_path('/temp/thumb/' . $newName);
            $image = $manager->read($sourcePath)->cover(300, 275);
            $image->save($destinationPath);

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'image_path' => asset('/temp/thumb/' . $newName),
                'message' => 'Image uploaded successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No image uploaded'
            ]);
        }
    }
}

