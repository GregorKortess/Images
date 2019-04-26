<?php

/* @var $post frontend\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
?>
    <div class="container full">

        <div class="page-posts no-padding">
            <div class="row">
                <div class="page page-post col-sm-12 col-xs-12 post-82">


                    <div class="blog-posts blog-posts-large">

                        <div class="row">

                            <!-- feed item -->
                            <article class="post col-sm-12 col-xs-12">
                                <div class="post-meta">
                                    <div class="post-title">
                                        <img src="<?php echo "/uploads/".$post->user->picture; ?>" class="author-image" />
                                        <div class="author-name"><a href="<?php echo "/profile/".$post->user->id; ?>"> <?php echo $post->user->username; ?></a></div>
                                    </div>
                                </div>
                                <div class="post-type-image">
                                    <a href="#">
                                        <img src="<?php echo $post->getImage(); ?>" alt="">
                                    </a>
                                </div>
                                <div class="post-description">
                                    <p> <?php echo Html::encode($post->description); ?></p>
                                </div>
                                <div class="post-bottom">
                                    <div class="post-likes">
                                       <i class="fa fa-lg fa-heart-o"></i>
                                        <span class="likes-count"><?php echo $post->countLikes(); ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#" class="btn btn-default button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
                                            <?php echo Yii::t('post','Unlike') ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                        </a>
                                        <a href="#" class="btn btn-default button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
                                            <?php echo Yii::t('post','Like') ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                        </a>
                                    </div>
                                    <div class="post-comments">
                                        <a href="#bot"><?php echo Yii::t('post','Comments'). ': ' ?><?php if (!$post->countComments()) { echo 0; } else echo $post->countComments(); ?> </a>

                                    </div>
                                    <div class="post-date">
                                        <span><?php echo date("d-m-Y",$post->created_at); ?></span>
                                    </div>
<!--                                    <div class="post-report">-->
<!--                                        <a href="#">Report post</a>-->
<!--                                    </div>-->
                                </div>
                            </article>
                            <!-- feed item -->


                            <div class="col-sm-12 col-xs-12" >
                                <h4 align="center"><?php echo Yii::t('post','Comments').': ' ?>  <?php if (!$post->countComments()) { echo 0; } else echo $post->countComments(); ?></h4>
                                <div class="comments-post">

                                    <div class="single-item-title"></div>
                                    <div class="row">
                                        <ul class="comment-list">

                                            <!-- comment item -->
                                            <li class="comment">
                                                <div class="comment-info">
                                                    <?php foreach ($post->showComments() as $comment): ?>

                                                        <?php $comment = json_decode($comment); ?>
                                                        <?php $comments = ArrayHelper::toArray($comment); ?>

                                                        <h4 class="author"><a
                                                                    href="#"><?php echo Html::encode($comments['currentUserID']); ?></a>
                                                        </h4>
                                                        <?php echo Html::encode($comments['comment']); ?>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <a href="#" class="btn btn-default button-delete"
                                                           data-id="<?php echo $post->id; ?>"
                                                           data-text="<?php echo $comments['comment'] ?>"
                                                           data-user="<?php echo $comments['currentUserID'] ?>"><?php echo Yii::t('post', 'Delete') ?>
                                                        </a>
                                                        <hr>
                                                    <?php endforeach; ?>
                                                </div>
                                            </li>
                                            <!-- comment item -->


                                        </ul>
                                    </div>

                                </div>
                                <!-- comments-post -->
                            </div>

                            <div class="col-sm-12 col-xs-12">
                                <div class="comment-respond">
                                    <h4><?php echo Yii::t('post','Reply') ?></h4>
                                    <form action="#" method="post">
                                        <p class="comment-form-comment">
                                            <textarea class="form-control" name="comment" id="comments" rows="6" placeholder="<?php echo Yii::t('post','Text') ?>" aria-required="true"></textarea>
                                        </p>
                                        <p class="form-submit">
                                            <a href="#" class="btn btn-default button-comment" data-id="<?php echo $post->id; ?>"><?php echo Yii::t('post','Post') ?></a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="post-default-index">

    <a name="bot"></a>

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
