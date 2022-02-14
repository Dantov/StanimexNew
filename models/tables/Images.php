<?php

namespace app\models\tables;
use yii\db\ActiveRecord;

class Images extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';


    public static function tableName()
    {
        return "images";
    }

    public function getStock()
    {
        return $this->hasOne(Stock::className(),['id'=>'pos_id']);
    }

    public function scenarios()
    {
        $columnsAdd = [
            'img_name',
            'main',
            'pos_id',
        ];
        $columnsEdit = [
            'id',
            'img_name',
            'main',
            'pos_id',
        ];
        return [
            self::SCENARIO_ADD => $columnsAdd,
            self::SCENARIO_EDIT => $columnsEdit,
        ];
    }

    public function rules()
    {
        return [
            //rule1
            [
                [
                    'img_name',
                    'main',
                    'pos_id',
                ],
                'safe',
            ],

        ];
    }
}