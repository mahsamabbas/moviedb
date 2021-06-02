<?php

namespace App\Services;

use App\Models\Movie;
use App\Repositories\MovieRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class MovieService
{
    /**
     * @var $movieRepository
     */
    protected $movieRepository;

    /**
     * MovieService constructor.
     *
     * @param MovieRepository $movieRepository
     */
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * Validate movie data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveMovieData($data)
    {

        $validator = Validator::make($data, [
            '*.tmdb_id' => 'required|integer',
            '*.title' => 'required|string',
            '*.vote_count' => 'required',
            '*.vote_average' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->movieRepository->save($data);

        return $result;
    }
}
