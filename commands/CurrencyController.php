<?php

namespace app\commands;

use app\models\CurrencyUpdate;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class CurrencyController extends Controller
{
    public function actionUpdate()
    {
        Console::output(Console::ansiFormat("Обновление курса валют " . date('Y-m-d'), [Console::FG_GREEN]));
        try {
            (new CurrencyUpdate())->run();
        } catch(\Exception $e) {
            Console::output(Console::ansiFormat("Ошибка при обновлении: {$e->getMessage()}", [Console::FG_RED]));
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}