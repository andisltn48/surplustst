<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryProductController extends Controller
{
    public function findAllCategoryProduct()
    {
        $categories = CategoryProduct::with('product','category')->get();
        return response()->json([
            'status' => 200,
            'data' => count($categories) ? $categories : null
        ],200);
    }

    public function findByCategoryProduct($categoryId)
    {
        $data = CategoryProduct::with('product')->wherehas('category', function($q) use($categoryId){
            $q->where('id',$categoryId);
        })
        ->get();
        if ($data) {
            return response()->json([
                'statusCode' => 200,
                'data' => $data
            ], 200);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function createCategoryProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'category_id' => 'required',
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

        $createdData = CategoryProduct::create($request->all());
        return response()->json([
            'statusCode' => 201,
            'data' => $createdData
        ], 201);
    }

    public function updateCategoryProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'category_id' => 'required',
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

        $categoryData = CategoryProduct::find($id);
        if ($categoryData) {
            $categoryData->update($request->all());
            return response()->json([
                'statusCode' => 201,
                'data' => $categoryData
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function deleteCategoryProduct($id)
    {
        $categoryData = CategoryProduct::destroy($id);
        if ($categoryData) {
            return response()->json([
                'statusCode' => 201,
                'deletedId' => intval($id)
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }
}
