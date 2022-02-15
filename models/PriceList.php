<?php
namespace app\models;


use app\models\tables\Webuy;
use app\models\tables\Stock;
use app\models\tables\Images;
use app\models\tables\Aboutus;
use app\models\tables\Contacts;
use Yii;
use yii\helpers\Url;

class PriceList {


    function __construct()
    {
    }

	public function getStock()
    {
        $stock = Stock::find()
            ->with(['images'])
            ->orderBy('date DESC')
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



}