<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="site-reg">
<div style="color:#f41424; font-size:26px"> <?=$_SESSION['alerts']; unset($_SESSION['alerts']);?></div>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'mail')->textInput(['placeholder'=>'exaple@mail.ru'])->label('Почта');?>
        <?= $form->field($model, 'pass')->passwordInput()->label('Пароль'); ?>
        <?= $form->field($model, 'repass')->passwordInput()->label('Повторите пароль'); ?>
        <?= $form->field($model, 'token')->hiddenInput(['value'=>$_SESSION['skey']])->label(false); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary'])?>
        </div>
    <?php ActiveForm::end(); ?>
<?=$_SESSION['register'];?>
</div>
