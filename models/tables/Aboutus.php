<?php

namespace app\models\tables;
use yii\db\ActiveRecord;

class Aboutus extends ActiveRecord
{

    /*
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    */

    public static function tableName()
    {
        return "aboutus";
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
                'trim',
            ],

        ];
    }
}