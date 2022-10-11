<?php

namespace App\Exports;

use App\Models\IncomeExpense;
use App\Repositories\IncomeExpenseRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Repositories\IncomeExpenseRepositoryInterface;

class IncomeExpenseExport implements FromCollection
{
    /**
     * Репозиторий для извлечения данных из хранилища прихода/расхода.
     *
     * @var IncomeExpenseRepositoryInterface
     */
    protected $incomeExpenseRepository;

//    public function __construct()
//    {
//
//    }

    public function collection()
    {
        // TODO: Implement collection() method.
//        return IncomeExpense::all();
        $this->incomeExpenseRepository = new IncomeExpenseRepository( new IncomeExpense );

        return $this->incomeExpenseRepository->getListExport( null, null, null );
    }
}
