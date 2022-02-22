<?php

namespace app\models\admin;

use app\models\Files;
use app\models\PriceList;
use app\models\tables\Images;
use app\models\tables\Stock;
use app\models\Uploader;


/**
 *  СТОК МОДЕЛЬ ДЛЯ АДМИНКИ
 */
class StockModel extends PriceList
{

    protected $machineData = [];
    protected $machineID;

    const SCENARIO_ADMIN_STOCK = "adm_stock";

    public function __construct( int $machineID = null )
    {
        parent::__construct();

        if ( $machineID > 0 && $machineID < PHP_INT_MAX )
            $this->machineID = $machineID;

        $this->scenario = StockModel::SCENARIO_ADMIN_STOCK;
    }

    public function getMachine( $id = null )
    {
        if (!empty($this->machineData))
            return $this->machineData;

        $machineID = $this->machineID;
        if ( $id > 0 && $id < PHP_INT_MAX )
            $machineID = $id;

        $this->machineData = Stock::find()
            ->with(['images'])
            ->where(['=','id',$machineID])
            ->asArray()
            ->one();

        foreach ( $this->machineData['images'] as &$image )
        {
            if ( !file_exists( _rootDIR_ . "/web/Stockimages/" . $image['img_name'] ) )
                $image['img_name'] = 'no-img.png';
        }

        return $this->machineData;
    }


    public function parseMachineData( array $data ) : array
    {
        $validFields = [
            'short_name_ru',
            'name_ru',
            'name_en',
            'short_name_en',
            'description_ru',
            'description_en',
            'status',
            'views',
            'date',
        ];

        $values = [];
        foreach ( $data as $field => $f_data )
        {
            if (!in_array($field, $validFields))
                continue;

            $values[$field] = $f_data;
        }

        return $values;
    }

    public function editMachineData( array $data, int $id = null )
    {
        $machineID = $this->machineID;
        if ( $id > 0 && $id < PHP_INT_MAX )
            $machineID = $id;

        $st = Stock::findOne($machineID);
        $st->attributes = $data;

        return $st->save();
    }

    /**
     * @param array $machineData array from $_POST
     * @return bool
     */
    public function _addMachine( array $machineData )
    {
        $st = new Stock();

        if ( empty($machineData['date']))
            $machineData['date'] = date("Y-m-d");

        if ( empty($machineData['views']))
            $machineData['views'] = 1;

        $st->attributes = $machineData;

        $res = $st->save();
        //$this->machineID = Yii::$app->db->getLastInsertID();
        $this->machineID = $st->id;
        return $res;
    }
    public function addMachine()
    {
        $st = new Stock();
        $st->scenario = Stock::SCENARIO_ADD;

        $st->date = date("Y-m-d");
        $st->save();

        return $st->id;
    }

    public function updateImgFlag( int $imageID = null )
    {
        $imgT = Images::find()->where(['main'=>'1'])->andWhere(['pos_id'=>$this->machineID])->one();

        /** IF NO MAIN IMG */
        if ( empty($imgT) && !$imageID )
        {
            $imgT = Images::find()->where(['pos_id'=>$this->machineID])->one();
            $imgT->main = 1;
            return $imgT->save();
        }

        /** CHANGE MAIN IMG */
        if( !empty($imgT) && $imageID )
        {
            if ( $imageID === (int)$imgT->id )
            return  false;

            /** Уьираем флажок с предыдущей */
            $imgT->main = 0;
            $imgT->save();

            /** Ставим флажок с на новую */
            $imgT2 = Images::findOne($imageID);
            $imgT2->main = 1;
            return $imgT2->save();
        }

        return false;
    }

    /**
     * @var int $firstUploadedImgID - первой загруженной картинки
     */
    public $firstUploadedImgID;
    protected $uploadedFiles = [];
    /**
     * @throws \Exception
     */
    public function uploadFiles()
    {
        $uploader = new Uploader();

        if ( $uploader->upload( $this->machineID ) )
        {
            // file is uploaded successfully
            $fileNames = $uploader->uploadedFiles;

            foreach ( $fileNames as $fileName )
            {
                $imgTable = new Images();

                $imgTable->img_name = $fileName;
                $imgTable->pos_id = $this->machineID;
                $imgTable->main = '0';

                if ( $imgTable->save() )
                {
                    if ( !$this->firstUploadedImgID )
                        $this->firstUploadedImgID = $imgTable->id;

                    $this->uploadedFiles[] = "/web/Stockimages/" . $fileName;
                }

            }

            if ( count($uploader->uploadErrors) )
                return $uploader->uploadErrors;

            return true;
        }

        return false;
    }

    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \yii\db\StaleObjectException
     */
    public function deleteImage( int $id )
    {
        $imgT = Images::find()->where(['id'=>$id])->one();
        $imgName = $imgT->img_name;

        $files = Files::instance();
        if ( $files->delete(_rootDIR_ . "/web/Stockimages/" . $imgName ) )
        {
            if ( $imgT->main == 1 )
            {
                $imgTNew = Images::find()->where(['pos_id'=>$imgT->pos_id])->one();
                if ( $imgTNew )
                {
                    $imgTNew->main = 1;
                    $imgTNew->save();
                }
            }

            $res = $imgT->delete();
            //debugAjax($res,"loaded",END_AB);
            if ( $res ) return true;
        }

        return false;
    }

    public $deletedMachineName = "";
    /**
     * @param int|null $id
     * @return bool
     * @throws \yii\db\StaleObjectException
     */
    public function deleteMachine(int $id = null )
    {
        $machineID = $id ?? $this->machineID;

        $st = Stock::find()->where(['id'=>$machineID])->one();
        $images = Images::find()->where(['pos_id'=>$machineID])->all();
        $this->deletedMachineName = $st->name_en;

        if ( $st->delete() )
        {
            foreach ($images as $image )
            {
                $this->deleteImage($image->id);
            }
            return true;
        }

        return false;
    }


}
