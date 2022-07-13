<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role == "user") {
            $campaigns = Campaign::where('user_id', $user->id)->get();
        } elseif ($user->role == "admin") {
            $campaigns = Campaign::all();
        }
        return response()->json([
            'status' => 'success',
            'data' => $campaigns,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'target_funds' => 'required|integer',
            'total_donation' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|integer',
        ]);

        $user = Auth::user();
        if ($user->role == "user") {
            $request['status'] = "waiting";
        } elseif ($user->role == "admin") {
            $request['status'] = "approved";
        }

        $campaign = Campaign::create([
            'title' => $request['title'],
            'target_funds' => $request['target_funds'],
            'total_donation' => $request['total_donation'],
            'description' => $request['description'],
            'user_id' => $user->id,
            'category_id' => $request['category_id'],
            'status' => $request['status']
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);

            Picture::create(
                [
                    'photo' => $filename,
                    'campaign_id' => $campaign->id,
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'target_funds' => 'required|integer',
            'total_donation' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|integer',
        ]);

        $campaign = Campaign::find($id);

        $campaign->title = $request['title'];
        $campaign->target_funds = $request['target_funds'];
        $campaign->total_donation = $request['total_donation'];
        $campaign->description = $request['description'];
        $campaign->category_id = $request['category_id'];
        $campaign->save();

        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }

    public function destroy($id)
    {
        $campaign = Campaign::find($id);
        $campaign->delete();
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ]);
    }
}
