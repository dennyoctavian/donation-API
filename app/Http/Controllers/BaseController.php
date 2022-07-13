<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function index(Request $request)
    {
        $campaign = Category::find(2);
        dd($campaign->campaign);
    }
}
