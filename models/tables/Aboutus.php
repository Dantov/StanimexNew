<?php

namespace app\models\tables;
use yii\db\ActiveRecord;

class Aboutus extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';


    public static function tableName()
    {
        return "aboutus";
    }

    public function scenarios()
    {
        $columnsAdd = [
            'text_ru',
            'text_en',
        ];
        $columnsEdit = [
            'id',
            'text_ru',
            'text_en',
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
                    'text_ru',
                    'text_en',
                ],
                'safe',
            ],

        ];
    }
}