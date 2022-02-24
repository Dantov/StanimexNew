<?php

namespace app\models\tables;


use yii\db\ActiveRecord;

class Orders extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public static function tableName()
    {
        return "orders";
    }

    /*
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = [];
        //$scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
    */

    public function rules()
    {
        return [
            [['name','email','phone'], 'required','message' => 'Имя E-mail и Телефон необходямы к заполнению.'],
            //rule 1
            [
                [
                    'name',
                    'company',
                    'email',
                    'phone',
                    'theme',
                    'message',
                    'date'
                ],
                'trim',
            ],
            //rule 2
            [['email'],'email','message' => 'Формат E-mail не верен.'],

            [['pos_id'], 'number', 'max'=>PHP_INT_MAX],
        ];
    }
}