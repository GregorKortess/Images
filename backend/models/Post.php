<?php

namespace backend\models;

use Yii;
use frontend\models\events\PostCreateEvent;
use yii\db\Connection;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 * @property int $complaints
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
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
            'complaints' => 'Complaints',
        ];
    }

    public static function findComplaints()
    {
        return Post::find()->where('complaints > 0')->orderBy('complaints desc');
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function approve()
    {
        /*  @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);

        $this->complaints = 0;
        return $this->save(false,['complaints']);
    }

    public function deletePost()
    {
        /*  @var $redis Connection */
        $redis = Yii::$app->redis;
        $key1 = "post:{$this->id}:complaints";
        $key2 = "post:{$this->id}:likes";
        $key3 = "post:{$this->id}:comments";
        $key4 = "post:{$this->id}:commentsCount";
        $redis->del($key1,$key2,$key3,$key4);

        $sql = "DELETE FROM post where id =". $this->id."; DELETE from feed where post_id =".$this->id;
        return Yii::$app->db->createCommand($sql)->query();
    }
}
