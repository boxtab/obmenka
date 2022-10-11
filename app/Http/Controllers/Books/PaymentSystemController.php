<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentSystem;
use App\Models\Books\PaymentSystem;
use Exception;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;

class PaymentSystemController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listPaymentSystem = PaymentSystem::all();

        return view('books.payment-system.index', compact('listPaymentSystem'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.payment-system.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentSystem $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePaymentSystem $request): \Illuminate\Http\RedirectResponse
    {
        try {
            PaymentSystem::on()->updateOrCreate(['id' => $request->id], [
                'descr' => $request->descr,
            ]);

            return redirect()->route('payment-system.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PaymentSystem $paymentSystem
     * @return View
     */
    public function edit(PaymentSystem $paymentSystem): View
    {
        return view('books.payment-system.show', compact('paymentSystem'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PaymentSystem $paymentSystem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PaymentSystem $paymentSystem): \Illuminate\Http\RedirectResponse
    {
        try {
            $paymentSystem->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('payment-system.index');
    }
}
