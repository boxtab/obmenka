<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInitialBoxBalance;
use App\Repositories\BoxRepositoryInterface;
use App\Traits\ExceptionSQL;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Класс для ввода начальных остатков по счетам. Которые будут использоваться в остатках в качестве начальной точки.
 *
 * @package App\Http\Controllers
 */
class InitialBoxController extends Controller
{
    use ExceptionSQL;

    /**
     * @var BoxRepositoryInterface
     */
    protected $boxRepository;

    /**
     * InitialBoxController constructor.
     *
     * @param BoxRepositoryInterface $boxRepository
     */
    public function __construct( BoxRepositoryInterface $boxRepository )
    {
        $this->boxRepository = $boxRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listBalanceBox = $this->boxRepository->getListBalanceBox();

        return view('initial-box.index', compact('listBalanceBox'));
    }

    /**
     * Обновляет начальный остаток бокса.
     *
     * @param UpdateInitialBoxBalance $request
     * @return JsonResponse
     */
//    public function update( Request $request ): JsonResponse
    public function update( UpdateInitialBoxBalance $request ): JsonResponse
    {
        $response['message'] = 'success';

//        Log::info( $request->id );
//        Log::info( $request->balance );

        try {
            $this->boxRepository->pushBalance( $request->id, $request->balance );
            $response['balance'] = $this->boxRepository->pullBalance( $request->id );
        } catch ( Exception $e ) {
            $response['message'] = $this->getMessageFilterSQLError( $e );
        }

        return response()->json( $response );
    }
}
