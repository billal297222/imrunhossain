<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AmenitiesCategories;
use Illuminate\Http\Request;

class AppartmentController extends Controller
{
    public function index()
    {

        return view('backend.layouts.Appartment.index');
    }


      public function add()
    {

        $categories=AmenitiesCategories::with('features')->where('status','active')->get();  
        return view('backend.layouts.Appartment.add',compact('categories'));
    }
}
