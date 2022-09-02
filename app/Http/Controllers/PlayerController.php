<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PlayerController extends Controller
{
    /**
     * Show a player profile
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id = null)
    {
        $id = $id ?? 1;

        $player = $this->player($id);

        // split first & last name
        $names = collect(preg_split('/\s+/', $player->get('name')));
        $player->put('last_name', $names->pop());
        $player->put('first_name', $names->join(' '));

        // determine the image filename from the name
        $player->put('image', $this->image($player->get('name')));

        // stats to feature
        $player->put('featured', $this->feature($player));

        return view('player', $player);
    }

    /**
     * Retrieve player data from the API
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    protected function player(int $id): Collection
    {
        // return collect([
        //     "tries" => 21,
        //     "games" => 102,
        //     "number" => 9,
        //     "position" => "Halfback",
        //     "points" => 107,
        //     "name" => "Aaron Smith",
        //     "height" => 173,
        //     "age" => 33,
        //     "conversions" => 1,
        //     "weight" => 83,
        //     "penalties" => 0,
        //     "id" => "1",
        // ]);

        $baseEndpoint = 'https://www.zeald.com/developer-tests-api/x_endpoint/allblacks';

        $json = Http::get("$baseEndpoint/id/$id", [
            'API_KEY' => config('api.key'),
        ])->json();


        return collect(array_shift($json));
    }

    /**
     * Determine the image for the player based off their name
     *
     * @param string $name
     * @return string filename
     */
    protected function image(string $name): string
    {
        return preg_replace('/\W+/', '-', strtolower($name)) . '.png';
    }

    /**
     * Build stats to feature for this player
     *
     * @param \Illuminate\Support\Collection $player
     * @return \Illuminate\Support\Collection features
     */
    protected function feature(Collection $player): Collection
    {
        return collect([
            ['label' => 'Points', 'value' => $player->get('points')],
            ['label' => 'Games', 'value' => $player->get('games')],
            ['label' => 'Tries', 'value' => $player->get('tries')],
        ]);
    }
}
