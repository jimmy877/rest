<?php

namespace app\components\security;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\Session;

class SecurityWidget extends Widget
{
    public $desc;
    public $res;

    public function init()
    {
        parent::init();
        
    }

    public function run()
    {
        
        
        return Html::encode($this->desc);
    }
}