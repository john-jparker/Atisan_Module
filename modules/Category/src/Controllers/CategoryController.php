<?php
namespace Rsruman\Category\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Rsruman\Category\Models\Category;
use Rsruman\Category\Models\ChildCategory;
use Rsruman\Category\Models\SubChildCategory;

class CategoryController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(): \Inertia\Response
    {
        $parent_categories = Category::all();
        return Inertia::render('Category::Category', compact('parent_categories'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
           'parent_name' => 'nullable',
           'child_name' => 'nullable',
           'sub_child_name' => 'required|min:3|max:15|unique:categories,slug|unique:child_categories,slug|unique:sub_child_categories,slug'
        ],
        [
            'sub_child_name.required' => 'Category field is required',
            'sub_child_name.min' => 'Category name must be at least 3 characters',
            'sub_child_name.max' => 'Category name must not be greater than 15 characters.',
            'unique'    => 'Category name has already been taken.'
        ]);
        if ($validator->fails()){
            return \redirect()->back()->withErrors($validator->errors()->getMessages());
        }
        try {
            DB::beginTransaction();
            //Three level if inputted all fields
            if ($request->input('parent_name') !== null && $request->input('child_name') !== null){
                $child = ChildCategory::where('slug', $request->input('child_name'))->first();
                $category = SubChildCategory::create([
                    'child_category_id' => $child->id,
                    'name' => $request->input('sub_child_name'),
                    'slug' => Str::slug($request->input('sub_child_name'))
                ]);
                if (!empty($category)){
                    DB::commit();
                    return Redirect::route('category.create')->with('success', 'Category added successfully');
                }
                throw new \Exception('Invalid data');
            }
            //Two level if inputted without child fields
            if ($request->input('parent_name') !== null &&  $request->input('child_name') === null){
                $parent = Category::where('slug', $request->input('parent_name'))->first();
                $category = ChildCategory::create([
                    'category_id' => $parent->id,
                    'name' => $request->input('sub_child_name'),
                    'slug' => Str::slug($request->input('sub_child_name')),
                ]);
                if (!empty($category)){
                    DB::commit();
                    return Redirect::route('category.create')->with('success', 'Category added successfully');
                }
                throw new \Exception('Invalid data');
            }
            //One level if inputted only category
            $category = Category::create([
                'name' => $request->input('sub_child_name'),
                'slug' => Str::slug($request->input('sub_child_name'))
            ]);
            if (!empty($category)){
                DB::commit();
                return Redirect::route('category.create')->with('success', 'Category added successfully');
            }
            throw new \Exception('Invalid data');
        } catch (\Exception $ex){
            DB::rollBack();
            return Redirect::route('category.create')->withErrors($ex->getMessage());
        }
    }

    public function child_category(): \Illuminate\Http\JsonResponse
    {
        $selected_category = Category::where('slug', \request('category'))->with('child_categories')->first();
        if (!empty($selected_category)){
            return response()->json([
               'data' => $selected_category
            ]);
        }
        return response()->json([
            'message' => 'Please select valid data'
        ]);
    }
}
