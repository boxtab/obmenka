<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBox;

use App\Models\Books\Box;
use App\Models\Books\Direction;
use Exception;
use Illuminate\Contracts\View\View;

use App\Traits\ExceptionSQL;

class BoxController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listBox = Box::all();
        return view('books.box.index', compact('listBox'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listDirection = (new Direction)->sorted();

        return view('books.box.show', compact('listDirection',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBox $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBox $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Box::on()->updateOrCreate(['id' => $request->id], [
                'type_box' => $request->type_box,
                'unique_name' => $request->unique_name,
                'direction_id' => $request->direction_id,
            ]);

            return redirect()->route('box.index');

        } catch ( Exception $e ) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Box $box
     * @return View
     */
    public function edit(Box $box): View
    {
        $listDirection = (new Direction)->sorted();

        return view('books.box.show', compact('box', 'listDirection',));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Box $box
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Box $box)
    {
        try {
            $box->delete();
        } catch ( Exception $e ) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('box.index');
    }
}
