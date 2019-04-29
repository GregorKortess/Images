<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($user) {
                    /* @var $post backend\models\User */
                    return Html::img($user->getImage(), ['width' => '120px']);
                }
            ],
            'username',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'about:ntext',
            'type',
            'nickname',
            [
                'attribute' => 'role',
                'value' => function ($user) {
                    /* @var $user User */
                    if (!$user->getRoles()) {
                        return "user";
                    }
                    return implode(',', $user->getRoles());
                }
            ],
        ],
    ]) ?>

</div>
