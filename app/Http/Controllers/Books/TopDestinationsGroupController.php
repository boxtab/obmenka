<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopDestinationsGroup;
use App\Models\Bid;
use App\Models\Books\TopDestinations;
use App\Models\Books\TopDestinationsGroup;
use App\Models\Books\TopDestinationsGroupCross;
use App\Models\Offer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\RedirectResponse;
use App\Traits\ExceptionSQL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Группы источников дохода.
 *
 * @package App\Http\Controllers\Books
 */
class TopDestinationsGroupController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listTopDestinationsGroup = DB::select(DB::raw("
            select
                tdg.id as id,
                tdg.description as description,
                DATE_FORMAT( tdg.month_year, '%Y-%m' ) as month_year,
                (
                    select
                           GROUP_CONCAT(
                               td.descr
                               order by td.descr asc
                               SEPARATOR ', '
                            )
                    from top_destinations_group_cross as tdgc
                        left outer join top_destinations td on tdgc.top_destinations_id = td.id
                    where tdgc.top_destinations_group_id = tdg.id
                ) as top_destinations,
                tdg.created_at as created_at,
                tdg.updated_at as updated_at,
                CONCAT(uc.surname, ' ', LEFT(uc.name, 1), '. ', LEFT(uc.patronymic, 1), '.') as created_full_name,
                CONCAT(uu.surname, ' ', LEFT(uu.name, 1), '. ', LEFT(uu.patronymic, 1), '.') as updated_full_name
            from top_destinations_group as tdg
                left outer join users uc on tdg.created_user_id = uc.id
                left outer join users uu on tdg.updated_user_id = uu.id;
        "));

        return view('books.top-destinations-group.index', compact('listTopDestinationsGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listTopDestinations = TopDestinations::on()
            ->orderBy('id')
            ->get();

        return view('books.top-destinations-group.show', compact('listTopDestinations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopDestinationsGroup $request
     * @return RedirectResponse
     */
    public function store( StoreTopDestinationsGroup $request ): RedirectResponse
    {
        try {

            DB::transaction( function() use ( $request ) {
                $topDestinationsGroup = TopDestinationsGroup::on()->updateOrCreate(['id' => $request->id], [
                    'description'   => $request->description,
                    'month_year'    => $request->month_year . '-01',
                ]);

                foreach ( $request->top_destinations as $topDestinationId ) {

                    DB::table('top_destinations_group_cross')->insert([
                        'top_destinations_id'       => $topDestinationId,
                        'top_destinations_group_id' => $topDestinationsGroup->id,
                    ]);
                }
            });

            return redirect()->route('top-destinations-group.index');

        } catch ( Exception $e ) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TopDestinationsGroup $topDestinationsGroup
     * @return View
     */
    public function edit( TopDestinationsGroup $topDestinationsGroup ): View
    {
        $listTopDestinations = TopDestinations::on()
            ->orderBy('id')
            ->get();

        $listTopDestinationsSelected = TopDestinationsGroupCross::on()
            ->where('top_destinations_group_id', $topDestinationsGroup->id)
            ->get('top_destinations_id')
            ->map( function ( $item ) {
                return $item->top_destinations_id;
            })
            ->toArray();

        return view('books.top-destinations-group.show', compact(
            'topDestinationsGroup',
            'listTopDestinations',
            'listTopDestinationsSelected'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TopDestinationsGroup $topDestinationsGroup
     * @return RedirectResponse
     */
    public function destroy( TopDestinationsGroup $topDestinationsGroup ): RedirectResponse
    {
        try {

            DB::transaction( function() use ( $topDestinationsGroup ) {
                TopDestinationsGroupCross::on()
                    ->where('top_destinations_group_id', $topDestinationsGroup->id)
                    ->delete();
                $topDestinationsGroup->delete();
            });

        } catch ( Exception $e ) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('top-destinations-group.index');
    }
}
