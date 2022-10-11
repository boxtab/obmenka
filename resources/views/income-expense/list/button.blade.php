<a href="{{ route('income-expense.export') }}" class="btn btn-primary">Экспорт</a>

<a class="button-container btn btn-primary"
   data-toggle="dropdown"
   aria-haspopup="true"
   aria-expanded="false">
    Добавить
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
    @isset( $listIncomeExpenseType )
        @if( ! empty( $listIncomeExpenseType ) )
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['PARTNERS'] ) }}">Партнеры</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['INCOME_UNFINISHED'] ) }}">Приход незавершенка</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['EXPENSE_UNFINISHED'] ) }}">Расход незавершенка</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['COMPANY_EXPENSE'] ) }}">Расход фирмы</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['COMPANY_INCOME'] ) }}">Приход фирмы</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['OUTPUT_CARD_CARD'] ) }}">Вывод карта/карта</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['OUTPUT_CARD_CASH'] ) }}">Вывод карта/нал</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['OUTPUT_WALLET_CARD'] ) }}">Вывод кошелек/карта</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['OUTPUT_WALLET_WALLET'] ) }}">Вывод кошелек/кошелек</a>
            <a class="dropdown-item" href="{{ route( 'income-expense.create', $listIncomeExpenseType['OUTPUT_EXCHANGE'] ) }}">Вывод обмен (разные валюты)</a>
        @else
            <a class="dropdown-item" href="#">Массив типов прихода/расхода пустой</a>
        @endif
    @else
        <a class="dropdown-item" href="#">Массив типов прихода/расхода не передан в шаблон</a>
    @endisset
</div>
