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
        if (\request()->has('category')){
            $selected_category = Category::where('slug', \request('category'))->first();
            if (!empty($selected_category)){
                $parent_categories = Category::all();
                $child_categories = ChildCategory::where('category_id', $selected_category->id)->get();
                return Inertia::render('Category::Category', compact('parent_categories', 'child_categories', 'selected_category'));
            }
        }
        $parent_categories = Category::all();
        $child_categories = null;
        $selected_category = null;
        return Inertia::render('Category::Category', compact('parent_categories', 'child_categories','selected_category'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
           'parent_name' => 'nullable',
           'child_name' => 'nullable',
           'sub_child_name' => 'required|min:3|max:15|unique:categories|unique:child_categories|unique:sub_child_categories'
        ],
        [
            'sub_child_name.required' => 'Category field is required',
            'sub_child_name.min' => 'Category name must be at least 3 characters',
            'sub_child_name.max' => 'Category name must not be greater than 15 characters.'
        ]);
        if ($validator->fails()){
            return Redirect::route('category.create')->withErrors($validator->errors()->getMessages());
        }
        try {
            DB::beginTransaction();
            //Three level if inputted all fields
            if ($request->input('parent_name') !== null && $request->input('child_name') !== null){
                $category = SubChildCategory::create([
                    'child_category_id' => $request->input('child_name'),
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
                $category = ChildCategory::create([
                    'category_id' => $request->input('parent_name'),
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
}
