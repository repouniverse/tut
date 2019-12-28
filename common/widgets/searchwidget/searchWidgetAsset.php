<?php
// your_app/votewidget/VoteWidgetAsset.php
namespace common\widgets\searchwidget;
use yii\web\AssetBundle;
class searchWidgetAsset extends AssetBundle
{
    public $js = [
        'js/searchWidget.js'
    ];

    public $css = [
         // CDN lib
       // '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        'css/searchWidget.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}