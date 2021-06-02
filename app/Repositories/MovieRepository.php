<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class MovieRepository
{
    /**
     * Save movies data in the DB
     *
     * @param $data
     * @return Movie
     */
    public function save($data)
    {
        return DB::table('movies')->upsert($data, ['tmdb_id'], ['vote_count', 'vote_average']);
    }
}
