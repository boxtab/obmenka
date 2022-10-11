<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreDirection;
use App\Models\Books\Currency;
use App\Models\Books\Partners;
use App\Models\Books\PaymentSystem;
use App\Models\Books\Direction;
use Exception;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;

class DirectionController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listDirection = Direction::all();

        return view('books.direction.index', compact('listDirection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listPaymentSystem = PaymentSystem::on()->orderBy('descr')->get();
        $listCurrency = Currency::on()->orderBy('descr')->get();

        return view('books.direction.show', compact(
            'listPaymentSystem',
            'listCurrency',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDirection $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDirection $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Direction::on()->updateOrCreate(['id' => $request->id], [
                'payment_system_id' => $request->payment_system_id,
                'currency_id' => $request->currency_id,
            ]);

            return redirect()->route('direction.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Direction $direction
     * @return View
     */
    public function edit(Direction $direction): View
    {
        $listPaymentSystem = PaymentSystem::on()->orderBy('descr')->get();
        $listCurrency = Currency::on()->orderBy('descr')->get();

        return view('books.direction.show', compact(
            'direction',
            'listPaymentSystem',
            'listCurrency',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Direction $direction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Direction $direction): \Illuminate\Http\RedirectResponse
    {
        try {
            $direction->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('direction.index');
    }
}
