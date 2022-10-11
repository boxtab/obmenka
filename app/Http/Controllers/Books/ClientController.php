<?php

namespace App\Http\Controllers\Books;

use App\Http\Requests\StoreClient;
use App\Http\Requests\StorePartners;
use App\Models\Books\Client;
use App\Http\Controllers\Controller;
use App\Models\Books\Partners;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;

class ClientController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listClient = Client::all();
        return view('books.client.index', compact('listClient'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.client.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClient $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClient $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Client::on()->updateOrCreate(['id' => $request->id], [
                'fullname'  => $request->fullname,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'note'      => $request->note,
            ]);

            return redirect()->route('client.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return View
     */
    public function edit(Client $client): View
    {
        return view('books.client.show', compact('client',));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client): \Illuminate\Http\RedirectResponse
    {
        try {
            $client->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('client.index');
    }
}
