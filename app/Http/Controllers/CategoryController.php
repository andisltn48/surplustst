<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function findAllCategory()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'data' => count($categories) ? $categories : null
        ],200);
    }

    public function findById($categoryId)
    {
        $categoryData = Category::find($categoryId);
        if ($categoryData) {
            return response()->json([
                'statusCode' => 200,
                'data' => $categoryData
            ], 200);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }

    public function createCategory(Request $request)
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

        $createdData = Category::create($request->all());
        return response()->json([
            'statusCode' => 201,
            'data' => $createdData
        ], 201);
    }

    public function updateCategory(Request $request, $categoryId)
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

        $categoryData = Category::find($categoryId);
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

    public function deleteCategory($categoryId)
    {
        $categoryData = Category::destroy($categoryId);
        if ($categoryData) {
            return response()->json([
                'statusCode' => 201,
                'deletedId' => intval($categoryId)
            ], 201);
        }
        return response()->json([
            'statusCode' => 404,
            'data' => null
        ], 404);
    }
}
