<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $productData = Product::find($productId);
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
        return response()->json([
            'statusCode' => 201,
            'data' => $createdData
        ], 201);
    }

    public function updateProduct(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
}
