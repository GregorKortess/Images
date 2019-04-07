<?php

namespace frontend\modules\user\controllers;

use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use frontend\components\Storage;


class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $modelPicture = new PictureForm();

        return $this->render('view', [
            'user' => $this->findUser($nickname),
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
        ]);
    }


    /**
     *  upload profile image via ajax request
     */
    public function actionUploadPicture()
    {

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()) {

            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture); // 15/27/30379e706840f951d22de02458a4788eb55f.jpg

            if ($user->save(false, ['picture'])) {
                print_r($user->attributes);
            }
        }
    }

    /**
     * @param $nickname
     * @return array|\yii\db\ActiveRecord|null
     * @throws NotFoundHttpException
     */
    private function findUser($nickname)
    {
        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    public function actionSubscribe($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $user = $this->findUserById($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view','nickname' => $user->getNickName()]);

    }

    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentlyUser */
        $currentlyUser = Yii::$app->user->identity;
        $user = $this->findUser($id);

        $currentlyUser->unFollowUser($user);

        return $this->redirect(['/user/profile/view','nickname' => $user->getNickName()]);

    }

    private function findUserById($id)
    {
        if($user = User::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }


}