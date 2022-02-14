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
        return Stock::find()
            ->with(['images'])
            ->orderBy('date DESC')
            ->asArray()
            ->all();
	}



}