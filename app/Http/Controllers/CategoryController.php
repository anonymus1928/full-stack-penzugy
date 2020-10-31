<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{   
    /**
     * Get a category.
     * If id is undefined returns every category.
     */
    public function getCategories(Request $request, $id = null) {
        $category = null;
        if(isset($id)) {
            $category = Auth::user()->categories->where('id', '=', $id)->first();
            if(!isset($category)) {
                return response()->json(['status' => 'error', 'error' => 'Category not found'], 404);
            }
            return response()->json(['status' => 'OK', 'category' => $category], 200);
        }

        $category = Auth::user()->categories->all();
        return response()->json(['status' => 'OK', 'category' => $category], 200);
    }

    /**
     * Create a new category.
     */
    public function newCategory(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->getUser()->associate(Auth::user());
        $category->save();

        return response()->json(['status' => 'OK'], 201);
    }

    /**
     * Modify a category.
     */
    public function modifyCategory(Request $request, $id) {
        $category = Auth::user()->categories->find($id);
        if(!isset($category)) {
            return response()->json(['status' => 'error', 'error' => 'Category not found'], 404);
        }
        $category->update($request->all());
        return response()->json(['status' => 'OK', 'category' => $category], 200);
    }

    /**
     * Delete a category (soft delete).
     * If id is undefined, every category is being deleted.
     */
    public function deleteCategory(Request $request, $id = null) {
        $category = null;
        if(isset($id)) {
            // Delete just one.
            $category = Auth::user()->categories->find($id);
            if(!isset($category)) {
                return response()->json(['status' => 'error', 'error' => 'Category not found'], 404);
            }
        } else {
            $category = DB::table('categories')->where('user_id', '=', Auth::user()->id);
        }
        if(!$category->count()) {
            return response()->json(['status' => 'error', 'error' => 'Categories not found'], 404);
        }
        $category = $category->delete();

        return response()->json(['status' => 'OK', 'deleted' => $category], 200);
    }

}
