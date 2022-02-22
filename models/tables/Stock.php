<?php

namespace app\models\tables;

use yii\db\ActiveRecord;
use Yii;

class Stock extends ActiveRecord
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public $imgFor;

    public static function tableName()
    {
        return "stock";
    }

    public function getImages()
    {
        $session = Yii::$app->session;

        if ( $session['isPriceList'] === true )
        {
            return $this->hasMany(Images::className(),['pos_id'=>'id'])
                ->select('*')
                ->where(['=','main',1]);
        }
        return $this->hasMany(Images::className(),['pos_id'=>'id']);
    }

    public function attributeLabels()
    {
        return [
             'name_ru' => 'Полное Имя: ',
             'name_en' => 'Full Name: ',
             'short_name_ru' => 'Full Name: ',
             'short_name_en' => 'Short Name: ',
             'description_ru'=> 'Описание: ',
             'description_en'=> 'Description:',
             'views'=> 'Просмотры: ',
             'date'=> 'Дата: ',
             'status'=> 'Статус: ',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['date'];
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
                    'short_name_ru',
                    'short_name_en',
                ],
                'required',
                'message' => 'Это поле нужно заполнить!'
            ],
            //rule4
            [
                [
                    'name_ru',
                    'name_en',
                    'short_name_ru',
                    'short_name_en',
                    'description_ru',
                    'description_en',
                ],
                'trim',
            ],
            //rule5
            [
                ['views'], 'number'
            ],
            //rule6
            [
                ['date','status'], 'string'
            ],
        ];
    }

}