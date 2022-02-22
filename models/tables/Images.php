<?php

namespace app\models\tables;
use yii\db\ActiveRecord;


class Images extends ActiveRecord
{

    public static function tableName()
    {
        return "images";
    }

    public function getStock()
    {
        return $this->hasOne(Stock::className(),['id'=>'pos_id']);
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