<?php

namespace app\models\tables;
use yii\db\ActiveRecord;


class Shipments extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public static function tableName()
    {
        return "shipments";
    }

    public function getStock()
    {
        return $this->hasOne(Stock::className(),['id'=>'pos_id'])
            ->select('id, short_name_ru');
    }


    public function rules()
    {
        return [
            //rule1
            [
                ['img', 'description_ru', 'description_en'],
                'trim','string'
            ],
            [
                ['pos_id'],
                'number'
            ],
            [
                ['date'],
                'string'
            ],
        ];
    }
}