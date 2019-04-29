<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Admin panel</h1>


        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Complaints</h2>

                <p>Sometimes people post offensive things...</p>

                <p><a class="btn btn-default" href="<?php echo Url::to(['/complaints/manage']) ?>">Manage</a></p>
            </div>
            <div class="col-lg-4">


            </div>
            <div class="col-lg-4">
                <h2>Users</h2>

                <p>Show user list</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>


    </div>
</div>
