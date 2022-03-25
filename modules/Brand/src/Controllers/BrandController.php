<?php

namespace Rsruman\Brand\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Rsruman\Brand\Models\Brand;

class BrandController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(): \Inertia\Response
    {
        return Inertia::render('Brand::Brand');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|min:3|max:15',
           'slug' => 'required|min:3|max:15|unique:brands',
        ]);

        if($validator->fails()){
            return Redirect::route('brand.create')->withErrors($validator->errors()->getMessages());
        }

        try {
            DB::beginTransaction();
            $brand = Brand::create([
               'name' => $request->input('name'),
               'slug' => $request->input('slug'),
            ]);
            if (!empty($brand)){
                DB::commit();
                return Redirect::route('brand.create')->with('success', 'Brand added successfully');
            }
            throw new \Exception('Invalid data');
        } catch (\Exception $ex){
            DB::rollBack();
            return Redirect::route('brand.create')->withErrors($ex->getMessage());
        }
    }
}
