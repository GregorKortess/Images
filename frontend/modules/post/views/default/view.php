<?php

/* @var $post frontend\models\Post */

use yii\helpers\Html;

use yii\helpers\ArrayHelper;
?>

<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user): ?>
                <b><?php echo $post->user->username; ?></b>
            <?php endif; ?>
        </div>
        <br>
        <hr/>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>">
        </div>

        <div class="col-md-12">
            <hr/>
            <?php echo Html::encode($post->description); ?>
        </div>

    </div>

    <hr/>
    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
    </div>

</div>
    <br>
    <hr>
    <div class="col-md-12">
        <form>
            <label for="comments">Оставить комментарий</label>
            <br>
            <a href="#" class="btn btn-success button-comment" data-id="<?php echo $post->id; ?>">
                Отправка комментария
            </a>
            <br><br>
            <textarea class="form-control" name="" id="comments" rows="10"></textarea>
        </form>
    </div>

    <br>
    <hr>

    <span class="show-comments">
        <?php foreach ($post->showComments() as $comment): ?>

            <?php $comment = json_decode($comment); ?>
        <?php $comments = ArrayHelper::toArray($comment); ?>
        <h3><?php echo Html::encode($comments['currentUserID']); ?></h3>
        <?php echo Html::encode($comments['comment']); ?>

            <a href="#" class="btn btn-danger button-delete" data-id="<?php echo $post->id; ?>" data-text="<?php echo $comments['comment'] ?>" data-user="<?php echo $comments['currentUserID'] ?>">Удалить</a>
            <hr>
        <?php endforeach; ?>
            </span>



<?php

$this->registerJsFile('@web/js/like.js', [
        'depends' =>\yii\web\JqueryAsset::className(),
]);

$this->registerJsFile('@web/js/comment.js', [
    'depends' =>\yii\web\JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/delete.js', [
    'depends' =>\yii\web\JqueryAsset::className(),
]);
