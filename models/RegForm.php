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
class RegForm extends Model
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
            [['pass'],'string','min'=>6,'message' =>'Пароль слишком короткий'],
            [['repass'], 'required','message' => 'Нужно повторить пароль'],
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
    public function addUser(){
        if( $this->token!=Yii::$app->session->get('skey') ){
            Yii::$app->session->set('alerts', 'Ошибка при отправке формы');
            return false;
        }
        $db = new Users();
        $res = $db->find()->where(["mail"=>$this->mail])->one();
        if($res!==null){
            Yii::$app->session->set('alerts', 'Такой email уже есть.');
            return false;
        }
        $db->mail = $this->mail;
        $db->pass = md5($this->pass);
        $db->token = $this->token;
        $db->save();
        return true;
    }
}
