<?php

namespace app\models\tables;


use yii\db\ActiveRecord;

class Users extends ActiveRecord
{

    public static function tableName()
    {
        return "users";
    }

}