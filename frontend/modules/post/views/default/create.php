<?php

/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="post-default-index">

    <h1><?php echo Yii::t('create','Create post') ?></h1>

    <? $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model,'picture')->fileInput(); ?>

    <?php echo $form->field($model,'description'); ?>

    <?php echo Html::submitButton(Yii::t('create','Create'),['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
