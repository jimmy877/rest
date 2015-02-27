<?php

namespace app\extensions;
use Yii;
use app\models\Users;
use yii\web\Session;

class Functions 
{
   public static function security(){
        
        $session = Yii::$app->session;
        $sess = $session->get('skey');
        $reg = $session->get('register');
        if (!isset($sess)){
            $val = rand(1,100000).'dsdkfjhskey2Df'.rand(1,100000);
            $session->set('skey', $val); 
        }
        if (isset($reg)){
            $val = rand(1,100000).'dsdkfjhskey2Df'.rand(1,100000);
            $user = Users::findOne(['mail'=>$reg['mail']]);
            if($user->token == $reg['token']){
                $user->token = $val;
                $user->update(); 
                 $session->set('register',['token'=>$val,'mail'=>$reg['mail']]);         
            }
            else{
                $session->remove('register');
            }

        }

   }
   
    public static function access(){
        
        $session = Yii::$app->session;
        $reg = $session->get('register');
        if (isset($reg)){
            Yii::$app->getResponse()->redirect('/');
        }
        return true;
    }
    
    public static function remoteAccess(){
        
        $token2 = Yii::$app->request->post('token2');
        $token = Yii::$app->request->post('token');
        $mail = Yii::$app->request->post('mail');
        if ($token2!='sdsaasdtoken99'){
            return false;
        }
        $user = Users::findOne(['mail'=>$mail]);
        if ($user->mail==null){
            return false;
        }
        /**/
        
        $sess = $session->get('skey');
        $reg = $session->get('register');
        if (isset($reg)){
            Yii::$app->getResponse()->redirect('/');
        }
        return true;
    }
    

}
