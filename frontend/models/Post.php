<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\db\Connection;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 */
class Post extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],

                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }

    /**
     * Like current post by given user
     * @param \frontend\models\User $user
     */
    public function like(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * Unlike current post by given user
     * @param \frontend\models\User $user
     */
    public function unLike(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    /**
     * Check whether given user liked current post
     * @param \frontend\models\User $user
     * @return integer
     */
    public function isLikedBy(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    public function createComment($user, $comment)
    {
        $currentUserId = $user->username;
        $params = [
          'currentUserID' => $currentUserId,
          'comment' => $comment,
        ];

        $params = json_encode($params);

        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->zadd("post:{$this->getId()}:comments", time(),  $params);
        $redis->zadd("user:{$user->getId()}:comments",  time() , $params);
        $redis->incr("post:{$this->getId()}:commentsCount");

        return true;
    }

    public function showComments()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->zrange("post:{$this->getId()}:comments", 0 , -1);
    }

    public function deleteComment($user,$commentText,$commentAuthor)
    {

        $params = [
            'currentUserID' => $commentAuthor,
            'comment' => $commentText,
        ];

        $params = json_encode($params);

        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->zrem("post:{$this->getId()}:comments", $params);
        $redis->zrem("user:{$user->getId()}:comments",  $params);
        $redis->decr("post:{$this->getId()}:commentsCount");

        return true;
    }

    public function countComments()
    {
        $redis = Yii::$app->redis;
        return $redis->get("post:{$this->getId()}:commentsCount");
    }
}
