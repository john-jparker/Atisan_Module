<?php
namespace Rsruman\Category\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(): \Inertia\Response
    {
        return Inertia::render('Category::Category');
    }

    public function store(Request $request){
        dd($request->all());
    }
}
