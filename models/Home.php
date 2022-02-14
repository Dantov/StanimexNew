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
        return Stock::find()
            ->with(['images'])
            ->where(['=','status','hot'])
            ->orWhere(['=','status','sold'])
            ->asArray()
            ->all();
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
        return Webuy::find()
            ->asArray()
            ->all();
	}

}