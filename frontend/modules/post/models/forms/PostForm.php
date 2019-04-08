<?php
/**
 * Created by PhpStorm.
 * User: cleril
 * Date: 08.04.2019
 * Time: 17:30
 */

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;

class PostForm extends Model
{

    const MAX_DESCRIPTION_LENGHT = 1000;

    public $picture;
    public $description;

    private $user;

    public function rules()
    {
        return [
          [['picture'],'file',
              'skipOnEmpty' => false,
              'extensions' => ['jpg','png'],
              'checkExtensionByMimeType' => true,
              'maxSize' => $this->getMaxFileSize()],
            [['description'],'string','max' => self::MAX_DESCRIPTION_LENGHT],
        ];
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        if ($this->validate()) {
            $post = new Post();
            $post->description = $this->description;
            $post->created_at = time();
            $post->filename = Yii::$app->storage->saveUploadedFile($this->picture);
            $post->user_id =$this->user->getId();
            return $post->save(false);
        }
    }

    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

}