<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use app\models\Users;
use yii\web\Controller;

/**
 * LoginForm is the model behind the login form.
 */
class AuthForm extends Model
{
    public $mail;
    public $pass;
    public $repass;
    public $token;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['mail'], 'required','message' => 'Вы не заполнили почту'],
            [['pass'], 'required', 'message' => 'Вы не заполнили пароль'],
            [['token'], 'required','message'=>false],
           
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
            
        ];
    }

    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUser(){
        if( $this->token!=Yii::$app->session->get('skey') ){
            Yii::$app->session->set('alerts', 'Ошибка при отправке формы');
            return false;
        }
        $db = new Users();
        $res = $db->find()->where(["mail"=>$this->mail])->one();

        if($res===null){
            Yii::$app->session->set('alerts', 'Вы ввели неправильный пароль или почту');
            return false;
        }
        
        if($res->pass!=md5($this->pass)){
            Yii::$app->session->set('alerts', 'Вы ввели неправильный пароль или почту');
            return false; 
        }
        
        $res->token = $this->token;
        $res->update();
        Yii::$app->session->set('register', ['token'=>$this->token, 'mail'=>$this->mail]);
        return true;
    }
    
    public function validateRemoteuser(){
        if(Yii::$app->request->post('token')!='sdsaasdtoken99' ){
            return false;
        }
        $db = new Users();
        $res = $db->find()->where(["mail"=>Yii::$app->request->post('mail')])->one();
        if($res->mail==null){
            echo 'такого пользователя нет';
            return false;
        }
        if($res->pass!=md5(Yii::$app->request->post('pass'))){
            echo 'такого пароля нет'; 
            return false; 
        }
        $token = rand(1,100000).rand(100,900)."000gdfgdfg";
        $res->token = $token;
        $res->update();
        return json_encode(['token'=>$token, 'mail'=>Yii::$app->request->post('mail'), 'token2'=>'sdsaasdtoken99']);
        
    }
}
