<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\modules\user;
use frontend\models\Post;

class PostCreateEvent extends Event
{
    public $user;

    public $post;

    public function getUser()
    {
        return $this->user;
    }

    public function getPost()
    {
        return $this->post;
    }


}