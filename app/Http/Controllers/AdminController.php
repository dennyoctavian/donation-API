<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function listAllCategory()
    {
        $categories = DB::select('select * from categories');
        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
        ]);
        $category = Category::create([
            'category' => $request['category']
        ]);
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ]);
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
        ]);
        $category = Category::where('id', $id);
        $category->category = $request['category'];
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ]);
    }

    public function deleteCategory($id)
    {
        $category = DB::table('categories')->where('id', '=', $id)->delete();
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ]);
    }

    public function acceptCampaign($id)
    {
        $campaign = Campaign::find($id);
        $campaign->status = "approved";
        $campaign->save();
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }

    public function rejectCampaign($id)
    {
        $campaign = Campaign::find($id);
        $campaign->status = "rejected";
        $campaign->save();
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }
}
