<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/category",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Category name"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                  property="msg", 
     *                  type="string", 
     *                  example="Category created successfully"
     *             ),
     *             @OA\Property(
     *                 property="category",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Category ID"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Category name"
     *                 ),
     *                 @OA\Property(
     *                     property="subcategories",
     *                     type="array",
     *                     description="Subcategories",
     *                     @OA\Items(
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="Subcategory name"
     *                          ),
     *                          @OA\Property(
     *                              property="category_id",
     *                              type="integer",
     *                              description="Category id"
     *                          )
     *                     )
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="id", 
     *                 type="array",
     *                 @OA\Items(
     *                      type="string",
     *                      example="The name has already been taken."                     
     *                 )
     *             )     
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Show a category or a list of categories",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Category ID",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="categories",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(
     *                          property="category",
     *                          type="object",
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              description="Category ID"
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="Category name"
     *                          ),
     *                          @OA\Property(
     *                              property="subcategories",
     *                              type="array",
     *                              description="Subcategories",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="name",
     *                                      type="string",
     *                                      description="Subcategory name"
     *                                  ),
     *                                  @OA\Property(
     *                                      property="category_id",
     *                                      type="integer",
     *                                      description="Category id"
     *                                  )
     *                              )
     *                          )
     *                      )
     *                 )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/category",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 description="Category ID"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                  property="msg", 
     *                  type="string", 
     *                  example="Category deleted successfully"
     *             ),
     *             @OA\Property(
     *                 property="category",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Category ID"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Category name"
     *                 ),
     *                 @OA\Property(
     *                     property="subcategories",
     *                     type="array",
     *                     description="Subcategories",
     *                     @OA\Items(
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="Subcategory name"
     *                          ),
     *                          @OA\Property(
     *                              property="category_id",
     *                              type="integer",
     *                              description="Category id"
     *                          )
     *                     )
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
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
