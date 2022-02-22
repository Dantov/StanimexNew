<?php
namespace app\models;


use app\models\tables\Webuy;
use app\models\tables\Stock;
use app\models\tables\Images;
use app\models\tables\Aboutus;
use app\models\tables\Contacts;
use Yii;
use yii\helpers\Url;

class Home {


    function __construct()
    {
    }

	public function getStock()
    {
        $stock = Stock::find()
            ->with(['images'])
            ->where(['=','status','hot'])
            ->orWhere(['=','status','sold'])
            ->asArray()
            ->all();

        foreach ( $stock as &$machine )
        {
            foreach ( $machine['images'] as &$image )
                if ( !file_exists( _rootDIR_ . "/web/Stockimages/" . $image['img_name'] ) )
                    $image['img_name'] = 'no-img.png';
        }

        return $stock;
	}
	
	public function getAboutUs()
    {
        return Aboutus::find()
            ->asArray()
            ->all();
	}

	public function getContacts()
    {
        return Contacts::find()
            ->asArray()
            ->all();
	}

	public function getWebuy()
    {
        return Webuy::find()->where(['<>','name_ru',''])->orWhere(['<>','name_en',''])->asArray()->all();
	}

}