<?php

/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="post-default-index">

    <h1>Create post</h1>

    <? $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model,'picture')->fileInput(); ?>

    <?php echo $form->field($model,'description'); ?>

    <?php echo Html::submitButton('create',['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
