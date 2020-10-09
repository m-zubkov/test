<?php

namespace app\models;

use app\models\db\Currency;
use GuzzleHttp\Client;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Console;

class CurrencyUpdate extends Model
{
    protected $client;

    public function __construct($config = [])
    {
        $this->client = new Client();
        parent::__construct($config);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $currencies = $this->getCurrencyData();
        foreach ($currencies['Valute'] as $item) {
            Console::output(Console::ansiFormat("{$item['CharCode']}: {$item['Value']}"));
            $rate = str_replace(',', '.', $item['Value']);
            if (!$currency = Currency::findOne(['code' => $item['CharCode']])) {
                $currency = new Currency();
                $currency->code = $item['CharCode'];
                $currency->name = $item['Name'];
            } else {
                $currency->updated = date('Y-m-d H:i:s');
            }

            $currency->rate = $rate;

            if (!$currency->save()) {
                throw new Exception("Ошибка обновления валюты {$item['CharCode']}: \n".
                    implode("\r\n", $currency->getErrorSummary(true)));
            }
        }
    }

    /**
     * @return array
     */
    protected function getCurrencyData()
    {
        $response = $this->client->get(\Yii::$app->params['currencyUpdateUrl']);
        $result = mb_convert_encoding($response->getBody()->getContents(), 'UTF-8', 'windows-1251');

        $result = str_replace('<?xml version="1.0" encoding="windows-1251"?>', '<?xml version="1.0" encoding="UTF-8"?>', $result);
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }
}