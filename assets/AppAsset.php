<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap4\BootstrapAsset',
    ];

    public function __construct( array $config = [] )
    {
        parent::__construct( $config );

        $this->css = [
            'css/bootstrap.min.css',
            //'css/bootstrap-theme.min.css',
            'css/style.css?v=' . time(),
            'fontawesome-6/css/fontawesome.min.css',
        ];

        $this->js = [
            'js/bootstrap.min.js',
            'js/const.js?v=' . time(),
        ];
    }
}
