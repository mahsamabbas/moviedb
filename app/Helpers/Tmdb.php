<?php

namespace App\Helpers;
use Carbon\Carbon;

class Tmdb
{

    /**
     * Get Movies list from api.
     *
     */
    public function getMovies($key, $url)
    {

        $movies = [];
        $client = new \GuzzleHttp\Client();
        foreach (range(1, 5) as $pageNumber) {
            $response = $client->request(
                'GET',
                $url . 'movie/popular',
                [
                    'query' => [
                        'api_key' => $key,
                        'language' => 'en-US',
                        'page' => $pageNumber
                    ]
                ]
            );

            $body = $response->getBody();
            $data = json_decode($body);
            $moviesList = $data->results;
            $movies = array_merge($movies, $moviesList);
        }

        // filter movies.
        return $this->filterMovies($movies);
    }

    /**
     * Filter movies array to get specific fields.
     *
     */
    public function filterMovies($movies)
    {
        $filterMovies = array();
        foreach ($movies as $index => $movie) {
            //TMDB data
            $filterMovies[$index]['tmdb_id'] = $movie->id;
            $filterMovies[$index]['title'] = $movie->title;
            $filterMovies[$index]['vote_average'] = $movie->vote_average;
            $filterMovies[$index]['vote_count'] = $movie->vote_count;
            //Timestamps
            $filterMovies[$index]['created_at'] = Carbon::now();
            $filterMovies[$index]['updated_at'] = Carbon::now();
        }

        return $filterMovies;
    }

     /**
     *  Sort array according to "vote average" and "vote count"
     *
     */
    public function sortMovies($movies)
    {
        $voteAverage = array_column($movies, 'vote_average');
        $voteCount = array_column($movies, 'vote_count');
        //multisort for sorting data
        array_multisort($voteAverage, SORT_DESC, $voteCount, SORT_DESC, $movies);
        return $movies;
    }
}