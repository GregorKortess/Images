<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $feedItems[] frontend\models\Feed */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'My Yii Application';
?>
    <div class="site-index">

        <?php if ($feedItems): ?>
            <?php foreach ($feedItems as $feedItem): ?>
                <?php /* @var $feedItem Feed */ ?>

                <div class="col-md-12">

                    <div class="col-md-12">
                        <img src="<?php echo $feedItem->author_picture; ?>" width="30" height="30" />
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($feedItem->author_nickname) ? $feedItem->author_nickname : $feedItem->author_id]); ?>">
                            <?php echo Html::encode($feedItem->author_name); ?>
                        </a>
                    </div>

                    <img src="<?php echo Yii::$app->storage->getFile($feedItem->post_filename); ?>" />
                    <div class="col-md-12">
                        <?php echo HtmlPurifier::process($feedItem->post_description); ?>
                    </div>

                    <div class="col-md-12">
                        <?php echo Yii::$app->formatter->asDatetime($feedItem->post_created_at); ?>
                    </div>

                    <div class="col-md-12">
                        Likes: <span class="likes-count"><?php echo $feedItem->countLikes(); ?></span>

                        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                        </a>
                        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->post_id; ?>">
                            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                        </a>
                    </div>

                </div>
                <div class="col-md-12"><hr/></div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-md-12">
                Nobody posted yet!
            </div>
        <?php endif; ?>

    </div>

<?php $this->registerJsFile('@web/js/like.js', [
    'depends' => JqueryAsset::className(),
]);