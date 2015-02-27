<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\rest\ActiveController;
use app\extensions\Test;


class MyrestController extends Controller
{
    public $modelClass = 'app\models\Users';
     
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
     public function actionView ($id=1){
        $req = Yii::$app->request;
        $post = $req->post('token');
        $data = ['one'=>1,'two'=>2];
        if($post!=null){ 
          return '{"id":1,"username":"anton"}';
              
        }
        echo 'one';
        
     }
     
     public function actionIndex(){
        if(Yii::$app->request->post()){
             Yii::$app->request->post('test');
        }
        /*$users = new Users();
        $users->mail='molot877@mail.ru';
        $users->pass="Anton";
        $users->token = 'dsdfsdfsdfd';
        $users->save();*/
        $res = Test::mytest();
        echo $res->mail;
        //return $this->render('index');
     }
     
}
