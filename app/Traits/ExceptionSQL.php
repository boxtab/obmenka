<?php

namespace App\Traits;

use Exception;
use \Illuminate\Database\QueryException;

trait ExceptionSQL
{
    protected function getMessageFilterSQLError( Exception $e )
    {
        $message = $e->getMessage();

        if ($e instanceof QueryException) {
            switch ($e->errorInfo[1]) {
                case 1451:
                    $message = 'Невозможно удалить запись. На нее есть ссылки из других таблиц';
                    break;
                case 1062:
                    $message = 'Такая запись уже существует';
                    break;
                default:
                    $message = $e->getMessage();
            }
        }

        return $message;
    }
}
