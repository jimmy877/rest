<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegForm;
use app\models\AuthForm;
use app\extensions\Functions;


class SiteController extends Controller
{
    public $desc;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        Functions::security();
        $this->layout="site";
        return $this->render('index',['desc'=>'']);
    }

    public function actionLogin()
    {
        Functions::security();
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionExit()
    {
        Functions::security();
        Yii::$app->session->remove('register');
        return $this->redirect(['/site']);
    }

    public function actionContact()
    {
        Functions::security();
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        Functions::security();
        return $this->render('about');
    }
    
    
    public function actionRegistration()
    {
        Functions::security();
        Functions::access();
        $this->layout="site";
        $model = new RegForm();
        if ($model->load(Yii::$app->request->post())){
            
            $res = $model->addUser();
            if($res==false){
                return $this->redirect(['registration']);
            }
            else{
                return $this->goBack('/');
            }
        }

        return $this->render('reg',['model' => $model]);
    }
    
    public function actionAuth()
    {
        Functions::security();
        Functions::access();
        $this->layout="site";
        $model = new AuthForm();
        
        if ($model->load( Yii::$app->request->post() ) ){
            
            $res = $model->validateUser();
            if($res==false){
                return $this->redirect(['auth']);
            }
            else{
                return $this->redirect('/');
            }
        }
        
        return $this->render('auth',['model' => $model]);
    }
    
    public function actionRemoteauth()
    {

        $model = new AuthForm();
        
        if (Yii::$app->request->post('token') ){
            
            $res = $model->validateRemoteuser();
            if($res==false){
                return false;
            }
            else{
                return $res;
            }
        }
        
    }
    
}
