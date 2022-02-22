<?php

namespace app\models\tables;


use yii\db\ActiveRecord;

class Contacts extends ActiveRecord
{

    public static function tableName()
    {
        return "contacts";
    }


    public function rules()
    {
        return [
            //rule1
            [
                [
                    'description_ru',
                    'description_en',
                ],
                'trim',
            ],

        ];
    }

}