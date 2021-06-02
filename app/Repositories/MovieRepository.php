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
        //insert unique records (according to tmdb_id, incase a duplicate record is inserted
        // it will only update vote_count & vote_average)
        return DB::table('movies')->upsert($data, ['tmdb_id'], ['vote_count', 'vote_average']);
    }
}
