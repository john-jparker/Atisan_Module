<?php
namespace Rsruman\Category\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Rsruman\Category\Models\Category;

class CategoryController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(){
        return Inertia::render('Category::Category');
    }
}
