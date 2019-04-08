<?php

/* @var $post frontend\models\Post */

use yii\helpers\Html;

?>

<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if($post->user): ?>
            <b><?php echo $post->user->username; ?></b>
            <?php endif; ?>
        </div>
        <hr/>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>">
        </div>

        <div class="col-md-12">
            <hr>vgb hnjkmu
            <?php echo Html::encode($post->description); ?>
        </div>

    </div>

</div>
