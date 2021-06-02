<?php

namespace App\Http\Controllers;
use App\Helpers\Tmdb;
use App\Services\MovieService;
use Exception;



class MovieController extends Controller
{
    /**
     * @var movieService
     */

    protected $movieService;
    protected $apiKey;
    protected $apiUrl;

    /**
     * MovieController Constructor
     *
     * @param MovieService $movieService
     *
     */

    public function __construct(MovieService $movieService)
    {   
        // Define service, themoviedb key and url
        $this->movieService = $movieService;
        $this->apiKey = config('services.tmdb.key');
        $this->apiUrl = config('services.tmdb.url');
    }

    /**
     * Return movie view
     */

    public function index()
    {
        //movies
        $movies = $this->store();

        return view('movies', compact('movies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {

        $tmdb = new Tmdb();

        // get movies list
        $movies = $tmdb->getMovies($this->apiKey, $this->apiUrl);

        // sort movies list
        $movies = $tmdb->sortMovies($movies);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->movieService->saveMovieData($movies);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

}
