<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name Название валюты
 * @property string $code Код валюты
 * @property float|null $rate
 * @property string|null $updated
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['rate'], 'number'],
            [['updated'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'rate' => 'Rate',
            'updated' => 'Updated',
        ];
    }
}
