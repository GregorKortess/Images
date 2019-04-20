<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */

/* @var $feedItems [] frontend\models\Feed */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Newsfeed';
?>


    <div class="container full">

        <div class="page-posts no-padding">
            <div class="row">
                <div class="page page-post col-sm-12 col-xs-12">
                    <div class="blog-posts blog-posts-large">

                        <div class="row">

                            <?php if ($feedItems): ?>
                                <?php foreach ($feedItems as $feedItem): ?>
                                    <?php /* @var $feedItem Feed */ ?>
                                    <!-- feed item -->
                                    <article class="post col-sm-12 col-xs-12">
                                        <div class="post-meta">
                                            <div class="post-title">
                                                <img src="<?php echo $feedItem->author_picture; ?>"
                                                     class="author-image"/>
                                                <div class="author-name">
                                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($feedItem->author_nickname) ? $feedItem->author_nickname : $feedItem->author_id]); ?>">
                                                        <?php echo Html::encode($feedItem->author_name); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-type-image">
                                            <a href="#">
                                                <a href="<?php echo Url::to(['/post/' . $feedItem->post_id]) ?>">
                                                    <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>"/>
                                                </a>
                                            </a>
                                        </div>
                                        <div class="post-description">
                                            <p> <?php echo HtmlPurifier::process($feedItem->post_description); ?></p>
                                        </div>
                                        <div class="post-bottom">
                                            <div class="post-likes">
                                                <i class="fa fa-lg fa-heart-o"></i>
                                                 <span class="likes-count"><?php echo $feedItem->countLikes(); ?></span>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="#"
                                                   class="btn btn-default button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>"
                                                   data-id="<?php echo $feedItem->post_id; ?>">
                                                    Unlike&nbsp;&nbsp;<span
                                                            class="glyphicon glyphicon-thumbs-down"></span>
                                                </a>
                                                <a href="#"
                                                   class="btn btn-default button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>"
                                                   data-id="<?php echo $feedItem->post_id; ?>">
                                                    Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                                </a>
                                            </div>
                                            <div class="post-comments">
                                                <?php if (!$feedItem->countComments()) { echo 0; } else echo $feedItem->countComments(); ?> comments

                                            </div>
                                            <div class="post-date">
                                                <span><?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at); ?></span>
                                            </div>
                                            <div class="post-report">
                                                <a href="#">Report post</a>
                                            </div>
                                        </div>
                                    </article>
                                    <!-- feed item -->


                                <?php endforeach; ?>

                            <?php else: ?>
                                <div class="col-md-12">
                                    Nobody posted yet!
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $this->registerJsFile('@web/js/like.js', [
    'depends' => JqueryAsset::className(),
]);