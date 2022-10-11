<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrency;
use App\Models\Books\Currency;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\ExceptionSQL;

class CurrencyController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listCurrency = Currency::all();
        return view('books.currency.index', compact('listCurrency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.currency.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCurrency $request
     * @return RedirectResponse
     */
    public function store(StoreCurrency $request): RedirectResponse
    {
        try {

            Currency::on()->updateOrCreate(['id' => $request->id], [
                'descr' => $request->descr,
            ]);

            return redirect()->route('currency.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Currency $currency
     * @return View
     */
    public function edit(Currency $currency): View
    {
        return view('books.currency.show', compact('currency'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Currency $currency
     * @return RedirectResponse
     */
    public function destroy(Currency $currency): RedirectResponse
    {
        try {
            $currency->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('currency.index');
    }
}
