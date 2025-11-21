<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController
{

    public function __invoke(Request $request)
    {

        $categories = Category::with('parent')->get();

        return CategoryResource::collection($categories);
    }
}
