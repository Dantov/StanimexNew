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

    protected $scenario = "";

    const SCENARIO_PRICE = 'price';

    function __construct()
    {
        $this->scenario = PriceList::SCENARIO_PRICE;
    }

	public function getStock()
    {
        $stock = Stock::find()
            ->with(['images'])
            ->orderBy('date DESC')
            ->asArray()
            ->all();

        //debug($stock,"stock",1);

        foreach ( $stock as $k => &$machine )
        {
            // Удалим пустые, только что внесенные
            if ( $this->isEmptyMachine($machine) && $this->scenario === PriceList::SCENARIO_PRICE )
            {
                unset($stock[$k]);
                continue;
            }

            if ( empty($machine['images']) )
            {
                $machine['images'][]['img_name'] = 'no-img.png';
                continue;
            }
            foreach ( $machine['images'] as &$image )
                if ( !file_exists( _rootDIR_ . "/web/Stockimages/" . $image['img_name'] ) )
                    $image['img_name'] = 'no-img.png';
        }

        return $stock;
	}

	protected function isEmptyMachine( $machine ) : bool
    {
        if ( empty($machine['name_ru']) && empty($machine['name_en']) && empty($machine['short_name_ru']) && empty($machine['short_name_en']) )
            return true;

        return false;
    }



}