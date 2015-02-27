<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Rest-main';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>


<form method="post" action="/myrest/">
<input type="text" value="" name="test" /><br/><br/>
<input  type="submit"/>

</form>
</div>
