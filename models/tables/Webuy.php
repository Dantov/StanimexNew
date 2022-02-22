<?php

namespace app\models\tables;


use yii\db\ActiveRecord;

class Webuy extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public static function tableName()
    {
        return "webuy";
    }

    public function attributeLabels()
    {
        return [
            'name_ru' => 'Имя: ',
            'name_en' => 'Name: ',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = [];
        //$scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            //rule1
            [
                [
                    'name_ru',
                    'name_en',
                ],
                'trim',
            ],

        ];
    }
}