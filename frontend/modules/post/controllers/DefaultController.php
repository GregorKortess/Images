<?php

namespace frontend\modules\post\controllers;

use frontend\models\Post;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\User;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{

    /**
     * C
     * @return string|
     */
    public function actionCreate()
    {
        $model = new PostForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {

            $model->picture = UploadedFile::getInstance($model,'picture');

            if ($model->save()) {

                Yii::$app->session->setFlash('success','Post created !');
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Ренедрит
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $currentUser = Yii::$app->user->identity;

        return $this->render('view',[
           'post' => $this->findPost($id),
            'currentUser' => $currentUser,
        ]);
    }

    public function actionComment()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;


        $id = Yii::$app->request->post('id');
        $comment = Yii::$app->request->post('comment');

        $post = $this->findPost($id);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        if($post->createComment($currentUser, $comment)){
            Yii::$app->session->setFlash('success','Комментарий добавлен');
            $this->redirect(['/post/'.$id]);

        }

        return [
            'access' => true,
        ];
    }


    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        $post->unLike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    /**
     * @param $id
     * @return $User|null
     * @throws NotFoundHttpException
     */
    private function findPost($id)
    {
        if($user = Post::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }
}
