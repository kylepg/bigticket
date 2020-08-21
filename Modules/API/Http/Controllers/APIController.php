<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Stats\Entities\Season;
use Modules\Stats\Entities\Game;

class APIController extends Controller
{
    /**
     * Return JSON for playoffs index
     * @return Renderable
     */
    public function getPlayoffsFeed($start_year)
    {
        if(!empty($start_year)){
            $season = Season::where('start_year',$start_year)->with(['games' => function($query){
                // $query->where('season_type','=','post');
                $query->where('gid','=','0021900195');
            }])->first();
            if(!empty($season)){
                $playoffs_json = [
                    'round' => null,
                    'opponent' => null,
                    'content' => null,
                    'games' => $season->games->map(function($game){
                        $game->articles = $game->drupalArticles;
                        $game->videos = $game->drupalVideos;
                        return $game;
                    }),
                ];
                // dd($season->games->first()->drupalVideos);
                // dd($season->games->pluck('gid')->toArray());
                return response()->json($playoffs_json);
            }
        }
        abort(404);
    }
}
