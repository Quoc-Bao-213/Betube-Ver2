<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoType;
use App\Models\Vote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $videos = Video::where('percentage', 100)->get();
        $videoTypes = VideoType::all();

        return View('home', compact('videos', 'videoTypes'));
    }

    public static function getTotalLike($VideoID)
    {
        $getVotes = Vote::where('type', 'up')->where('voteable_id', $VideoID)->get();

        return count($getVotes);
    }
}
