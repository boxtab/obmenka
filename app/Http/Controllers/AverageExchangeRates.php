<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class AverageExchangeRates extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listAverageExchangeRates = DB::table('bid')
            ->leftJoin('exchange_direction', 'bid.exchange_direction_id', '=', 'exchange_direction.id')
            ->where('left_currency_id', '=', 1)
            ->where('right_currency_id', '=', 1)
            ->get();

        return view('average-exchange-rates.index');
    }
}
