<?php

namespace app\components\myteg;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Testform;

class MytegWidget extends Widget
{
    public $desc;
    public $res;

    public function init()
    {
        parent::init();
        $db = new Testform();
        $this->res = $db->find()->all();
        if ($this->desc === null) {
            $this->desc = 'Hello World';
        }
    }

    public function run()
    {
        return $this->render('index',['desc'=>$this->desc,'db'=>$this->res]);
        //return Html::encode($this->desc);
    }
}