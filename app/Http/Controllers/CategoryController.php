<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    public function postCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);
 
        if ($validator->fails()) {
			return response()->json($validator->errors(), 500);
		}

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json(
			[
				'success' => true,
                'msg' => 'Category created successfully',
				'category' => $category,
			],
			200
		);
    }

    public function getCategories(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|numeric',
        ]);
 
        if ($validator->fails()) {
			return response()->json($validator->errors(), 500);
		}

        $categories = null;
        if (!$request->id) {
            $categories = Category::with('subcategories')->get();
        } else {
            $categories = Category::with('subcategories')->where('id', $request->id)->first();
        }

        return response()->json(
			[
				'success' => true,
				'categories' => $categories,
			],
			200
		);
    }

    public function deleteCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|numeric',
        ]);
 
        if ($validator->fails()) {
			return response()->json($validator->errors(), 500);
		}

        $category = Category::with('subcategories')->where('id', $request->id)->first();
        if (!$category) {
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Category not found',
                ],
                404
            );
        }
        $category->delete();

        return response()->json(
			[
				'success' => true,
                'msg' => 'Category deleted successfully',
				'category' => $category,
			],
			200
		);
    }
}
