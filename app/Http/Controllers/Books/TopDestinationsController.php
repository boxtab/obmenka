<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopDestinations;
use App\Models\Books\TopDestinations;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\ExceptionSQL;

class TopDestinationsController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listTopDestinations = TopDestinations::all();
        return view('books.top-destinations.index', compact('listTopDestinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.top-destinations.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopDestinations $request
     * @return RedirectResponse
     */
    public function store(StoreTopDestinations $request): RedirectResponse
    {
        try {
            TopDestinations::on()->updateOrCreate(['id' => $request->id], [
                'descr' => $request->descr,
            ]);

            return redirect()->route('top-destinations.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TopDestinations $topDestinations
     * @return View
     */
    public function edit(TopDestinations $topDestinations): View
    {
        return view('books.top-destinations.show', compact('topDestinations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TopDestinations $topDestinations
     * @return RedirectResponse
     */
    public function destroy(TopDestinations $topDestinations): RedirectResponse
    {
        try {
            $topDestinations->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('top-destinations.index');
    }
}
