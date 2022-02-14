<?php
namespace app\models;


use app\models\tables\Stock;

use Yii;
use yii\helpers\Url;

class Machine {

    public $stockID;

    public $machineData = [];

    function __construct( int $id )
    {
        $this->stockID = $id;
    }

	public function getMachine()
    {
        if (!empty($this->machineData))
            return $this->machineData;

        return $this->machineData = Stock::find()
            ->with(['images'])
            ->where(['=','id',$this->stockID])
            ->orderBy('date DESC')
            ->asArray()
            ->one();
	}

	public function getMachinesCrumbs( $id = null )
    {
        if ( !$id ) return [];

        $stock = $this->machineData = Stock::find()
            ->select('id, short_name_ru, short_name_en')
            ->orderBy('date DESC')
            ->asArray()
            ->all();

        $result = [];
        $numLast = count($stock) - 1;

        foreach ( $stock as $num => $machine )
        {
            if ( $machine['id'] == $id )
            {
                $prevKey = $num-1;
                $nextKey = $num+1;
                if ( $prevKey < 0 ) $prevKey = $numLast;
                if ( $nextKey > $numLast ) $nextKey = 0;

                $result['prev'] = $stock[$prevKey];
                $result['next'] = $stock[$nextKey];

                break;
            }
        }

        return $result;
    }

	public function getMainImg() : array
    {
        if ( !$this->machineData )
            $this->getMachine();

        $images = $this->machineData['images'];

        foreach ( $images as $image )
        {
            if ( $image['main'] == 1 )
                return $image;
        }

        return [];
    }



}