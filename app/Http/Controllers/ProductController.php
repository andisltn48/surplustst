<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function findAllProduct()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'data' => count($products) ? $products : null
        ],200);
    }

    public function findById($productId)
    {
        $productData = Product::with('category_product.category', 'product_image.images')->where('id',$productId)->first();
        if ($productData) {
            return response()->json([
                'statusCode' => 200,
                'data' => $productData
            ], 200);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'enable' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $value) {
                $errors[] = $value;
            }
            return response()->json([
                'statusCode' => 400,
                'message' => 'Bad request',
                'error' => $errors
            ], 400);
        }

        $createdData = Product::create($request->all());
        if ($request->category_id) {
            CategoryProduct::create([
                'product_id' => $createdData->id,
                'category_id' => $request->category_id
            ]);
        }
        return response()->json([
            'statusCode' => 201,
            'data' => $createdData
        ], 201);
    }

    public function updateProduct(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'enable' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $value) {
                $errors[] = $value;
            }
            return response()->json([
                'statusCode' => 400,
                'message' => 'Bad request',
                'error' => $errors
            ], 400);
        }

        $productData = Product::find($productId);
        if ($productData) {
            $productData->update($request->all());
            return response()->json([
                'statusCode' => 201,
                'data' => $productData
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function deleteProduct($productId)
    {
        $productData = Product::destroy($productId);
        if ($productData) {
            return response()->json([
                'statusCode' => 201,
                'deletedId' => intval($productId)
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function addProductPicture(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'max:3072|mimes:jpeg,jpg,png|required',
            'enable' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $key => $value) {
                $errors[] = $value;
            }
            return response()->json([
                'statusCode' => 400,
                'message' => 'Bad request',
                'error' => $errors
            ], 400);
        }

        $host = $request->getSchemeAndHttpHost();
        $image = $request->image;
        $fileName = time() . '_' . $image->getClientOriginalName();
        $file = $host . '/storage/restaurant-logo/' . $fileName;
        $image->move(public_path('storage/restaurant-logo'), $fileName);

        $createdImage = Image::create([
            'name' => $fileName,
            'file' => $file,
            'enable' => $request->enable
        ]);

        ProductImage::create([
            'product_id' => $productId,
            'image_id' => $createdImage->id
        ]);
        return response()->json([
            'statusCode' => 201,
            'data' => $createdImage
        ], 201);
    }

    public function deleteProductPicture($imageId)
    {
        $image = Image::destroy($imageId);

        if ($image) {
            return response()->json([
                'statusCode' => 201,
                'deletedId' => intval($imageId)
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }
}
