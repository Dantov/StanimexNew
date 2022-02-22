<?php

namespace app\models\admin;

use Yii;
use yii\base\Model;
use app\models\tables\Aboutus;
use app\models\tables\Contacts;

/**
 * ContactForm is the model behind the contact form.
 */
class AboutUsModel extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    public function getAbout()
    {
        $a = Aboutus::find()
            ->orderBy('id')
            ->asArray()
            ->all();
        return $a;
    }

    public function getContacts()
    {
        $c = Contacts::find()
            ->orderBy('id')
            ->asArray()
            ->all();
        return $c;
    }


    public function parseData( array $data ) : array
    {
        $validTables = [
            'aboutus' => ['text_ru','text_en'],
            'contacts' => ['description_ru','description_en'],
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
                if ( $tableName === 'aboutus' )
                {
                    $values = [
                        'text_ru' => $rowData['text_ru'],
                        'text_en' => $rowData['text_en'],
                    ];

                    $customer = Aboutus::findOne((int)$rowID);
                    $customer->attributes = $values;
                    $customer->save();
                }

                if ( $tableName === 'contacts' )
                {
                    $values = [
                        'description_ru' => $rowData['description_ru'],
                        'description_en' => $rowData['description_en'],
                    ];

                    $customer = Contacts::findOne((int)$rowID);
                    $customer->attributes = $values;
                    $customer->save();
                }
            }

        }

    }


}
