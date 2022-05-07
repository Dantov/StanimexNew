<?php

namespace app\models\tables;


use yii\db\ActiveRecord;

class UsersOnline extends ActiveRecord
{

    public static function tableName()
    {
        return "users_online";
    }

}