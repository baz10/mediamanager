<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Media;


class CategoryController extends Controller
{
    public function index($id)
    {
        $data['media'] = $med= Media::join('categories', 'category_id', '=', 'media.fk_category_id')
               ->where('fk_category_id', '=' , $id)
               ->get(['media.*', 'categories.category_name']);
        return view('category.index', $data);
    }
}
