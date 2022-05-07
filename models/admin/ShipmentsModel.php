<?php

namespace app\models\admin;

use app\models\Files;
use app\models\tables\Shipments;
use app\models\tables\Stock;
use app\models\Uploader;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ShipmentsModel extends Model
{

    protected $uploadedFiles = [];

    public $myErrors;
    protected $orderData;
    protected $id;

    public function __construct(int $id = null, array $config = [])
    {
        parent::__construct($config);

        if ( $id )
            $this->id = $id;
    }

    public function getAll()
    {
        $all = Shipments::find()
            ->orderBy('date DESC')
            ->with('stock')
            ->asArray()
            ->all();


        foreach ( $all as &$one )
        {
            $one['img'] = explode('--!!--',$one['img'])[0];
            if ( empty($one['img']) || !file_exists(_rootDIR_ . "/web/shipments/" . $one['img'] ) )
                $one['img'] = 'default.jpg';
        }

        return $all;
    }

    public function getFromStockID( int $id )
    {
        $sp =  Shipments::find()
            ->where(['=','pos_id',$id])
            ->one();

        return $sp->id??'';
    }

    public function getOne()
    {
        $res = Shipments::find()
            ->with('stock')
            ->where(['=','id',$this->id])
            ->asArray()
            ->one();

        if ( $res )
            if ( !empty($res['img']) )
            {
                $res['img'] = explode('--!!--',$res['img']);
            } else {
                $res['img'] = [];
            }

        return $res;
    }

    public function newOne( int $stockID )
    {
        $ship = new Shipments();

        $stock = Stock::find()
            ->select(['short_name_ru','short_name_en'])
            ->where(['=','id',$stockID])->one();

        $ship->description_ru = $stock->short_name_ru;
        $ship->description_en = $stock->short_name_en;
        $ship->pos_id = $stockID;
        $ship->date = date("Y-m-d");

        $ship->save(false);

        return $ship->id;
    }

    /**
     * @param int $stockID
     * @return bool|array
     * @throws \Exception
     */
    public function uploadImages()
    {
        $uploader = new Uploader();

        if ( $uploader->upload( $this->id, 'images', _rootDIR_ . '/web/shipments/' ) )
        {
            // file is uploaded successfully
            $fileNames = $uploader->uploadedFiles;

            $table = Shipments::find()->where(['=','id',$this->id])->one();

            $images = [];
            if ( !empty($table->img) )
                $images = explode('--!!--',$table->img);
            foreach ( $fileNames as $fileName )
            {
                $this->uploadedFiles[] = "/web/shipments/" . $fileName;
                $images[] = $fileName;
            }

            $table->img = implode('--!!--',$images);

            $table->save(false);

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

    public function update( array $data )
    {
        $s = Shipments::findOne($this->id);
        $s->description_ru = $data['description_ru'];
        $s->description_en = $data['description_en'];
        $s->date = $data['date'];

        //$s->attributes = $data;

        if ( $s->save(false) ) return true;

        $this->myErrors = $s->errors;
        return false;
    }

    /**
     * @param string $imgName
     * @return bool
     */
    public function removeImg( string $imgName )
    {
        $s =Shipments::find()->where(['id'=>$this->id])->one();

        $images = explode('--!!--', $s->img);
        $elemID = array_search($imgName,$images);
        if ( $elemID !== false )
            unset($images[$elemID]);
        $s->img = implode('--!!--',$images);

        //debug($images,'$images',1);

        $files = Files::instance();
        if ( $files->delete(_rootDIR_ . "/web/shipments/" . $imgName ) )
        {
            $res = $s->save(false);
            //debugAjax($res,"loaded",END_AB);
            if ( $res ) return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return false|int
     * @throws \yii\db\StaleObjectException
     */
    public function remove()
    {
        $s = Shipments::findOne($this->id);
        if ( !$s )
            return false;

        $images = $s->img??[];
        if ( !empty($s->img) )
        {
            $images = explode('--!!--',$images);
        } else {
            $images = [];
        }

        if ( $s->delete() )
        {
            $files = Files::instance();
            foreach ( $images as $img )
            {
                $files->delete(_rootDIR_ . "/web/shipments/" . $img );
            }

            return true;
        }

        return false;
    }

    public function getErrors($attribute = null)
    {
        return parent::getErrors($attribute); // TODO: Change the autogenerated stub
    }

}