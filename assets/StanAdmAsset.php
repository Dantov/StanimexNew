<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 */
class StanAdmAsset extends AssetBundle
{
    public $basePath = '@webroot/sadm';
    public $baseUrl = '@web/sadm';

    public $css = [];
    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function __construct( array $config = [] )
    {
        parent::__construct( $config );

        $this->css = [
            'css/bootstrap.min.css',
            'css/style.css?v=' . time(),
            'css/morris.css',
            'css/font-awesome.css',
            'css/icon-font.min.css',
        ];

        $this->js = [
            //'js/jquery-3.2.1.min.js',
            'js/const.js?v=' . time(),
            'js/jquery.nicescroll.js',
            'js/bootstrap.min.js',
            'js/raphael-min.js',
            'js/morris.js',
            'js/scripts.js',
        ];
    }
}
