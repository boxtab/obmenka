<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDDS;
use App\Models\Books\DDS;
use App\Models\Books\PaymentSystem;
use App\Models\Books\TopDestinations;
use Exception;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;

class DDSController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listDDS = DDS::on()->orderBy('id')->get();
        return view('books.dds.index', compact('listDDS'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listTopDestinations = TopDestinations::on()->orderBy('id')->get();

        return view('books.dds.show', compact('listTopDestinations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDDS $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( StoreDDS $request ): \Illuminate\Http\RedirectResponse
    {
//        dd( $request->all() );
        try {
            DDS::on()->updateOrCreate(['id' => $request->id], [
                'descr'                 => $request->descr,
                'top_destinations_id'   => $request->top_destinations_id,
            ]);

            return redirect()->route('dds.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DDS $dds
     * @return View
     */
    public function edit(DDS $dds): View
    {
        $listTopDestinations = TopDestinations::on()->orderBy('id')->get();

        return view('books.dds.show', compact('dds', 'listTopDestinations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DDS $dds
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DDS $dds): \Illuminate\Http\RedirectResponse
    {
        try {
            $dds->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('dds.index');
    }
}
