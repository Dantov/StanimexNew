<?php

namespace app\models\admin;

use app\models\tables\Webuy;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class WeBuyModel extends Model
{

    public function getWebuy()
    {
        $a = Webuy::find()
            ->orderBy('id')
            ->asArray()
            ->all();
        return $a;
    }

    public function createNew()
    {
        $wb = new Webuy();
        $wb->scenario = Webuy::SCENARIO_ADD;
        if ($wb->save())
            return $wb->id;

        return false;
    }

    /**
     * @param $id
     * @return false|int
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id )
    {
        $webuy = Webuy::findOne((int)$id);
        if ( $webuy )
            return $webuy->delete();

        return false;
    }

    public function parseData( array $data ) : array
    {
        $validTables = [
            'webuy' => ['name_ru','name_en'],
        ];
        $result = [];
        foreach ( $data as $table_id => $text )
        {
            if ( $table_id === "_csrf" )
                continue;

            $t_i = explode("-", $table_id);

            $tableName = $t_i[0];
            $column = $t_i[1];
            $posId = (int)$t_i[2];

            if ( !array_key_exists($tableName,$validTables) )
                continue;
            if ( !in_array($column,$validTables[$tableName]) )
                continue;
            if ( $posId < 1 || $posId > PHP_INT_MAX )
                continue;

            $result[$tableName][$posId][$column] = $text;
        }
        return $result;
    }


    public function updateData( array $data )
    {

        foreach ($data as $tableName => $tableData)
        {
            foreach ($tableData as $rowID => $rowData)
            {
                if ( $tableName === 'webuy' )
                {
                    $values = [
                        'name_ru' => $rowData['name_ru'],
                        'name_en' => $rowData['name_en'],
                    ];

                    $webuy = Webuy::findOne((int)$rowID);
                    $webuy->attributes = $values;
                    $webuy->save();
                }
            }

        }

    }


}
