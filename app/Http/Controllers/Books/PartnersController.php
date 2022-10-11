<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartners;
use App\Models\Books\Partners;
use App\Models\Books\PaymentSystem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PartnersController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     */
//    public function index(): View
//    {
//        $listPartners = Partners::all();
//        return view('books.partners.index', compact('listPartners'));
//    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if ( $request->ajax() ) {
            try {
                $data = DB::table('partners as p')
                    ->select(DB::raw(
                        'p.id,
                        p.descr,
                        p.created_at,
                        p.updated_at,
                        concat(cu.surname, " ", LEFT(cu.name, 1), ". ", LEFT(cu.patronymic, 1), ".") as created_full_name,
                        concat(uu.surname, " ", LEFT(uu.name, 1), ". ", LEFT(uu.patronymic, 1), ".") as updated_full_name'
                    ))
                    ->leftJoin('users as cu', 'p.created_user_id', '=', 'cu.id')
                    ->leftJoin('users as uu', 'p.updated_user_id', '=', 'uu.id')
                    ->orderBy('created_at')
                    ->get();

                return Datatables::of( $data )
                    ->addIndexColumn()
                    ->addColumn('open', function( $row ) {
                        return '<a href="' . route('partners.edit', ['partners' => $row->id]) . '">
                                    Открыть
                                </a>';
                    })
                    ->addIndexColumn()
                    ->addColumn('delete', function( $row ) {
                        return '<a  href="#"
                                    class="delete-confirm"
                                    data-id="'.$row->id.'"
                                    data-toggle="modal"
                                    data-target="#deleteModal">
                                    Удалить
                                </a>';
                    })
                    ->rawColumns(['open', 'delete'])
                    ->make(true);


            } catch (Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors( $this->getMessageFilterSQLError( $e ) );
            }
        }

        return view('books.partners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.partners.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePartners $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePartners $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Partners::on()->updateOrCreate(['id' => $request->id], [
                'descr' => $request->descr,
            ]);

            return redirect()->route('partners.index');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partners $partners
     * @return View
     */
    public function edit(Partners $partners): View
    {
        return view('books.partners.show', compact('partners'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Partners $partners
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Partners $partners): \Illuminate\Http\RedirectResponse
    {
        try {
            $partners->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('partners.index');
    }
}
