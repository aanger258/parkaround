<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Charts\SectorsHistorySearch;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $chart = new SectorsHistorySearch;
        $chart->labels(['Sector 1', 'Sector 2', 'Sector 3', 'Sector 4', 'Sector 5', 'Sector 6']);
        $sectors_searchs = DB::table('sectors')->select('search_count')->get();
        foreach ($sectors_searchs as $sector_search) {
            $data[] = $sector_search->search_count;
        }
        $chart->dataset('Sectors shearch history', 'line', $data);
        return view('home', compact('chart'));
    }
}
