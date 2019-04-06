<?php
/**
 * Created by PhpStorm.
 * User: cleril
 * Date: 04.04.2019
 * Time: 22:16
 */
// use Faker\Factory;

namespace frontend\modules\user\controllers;

use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        return $this->render('view', [
            'user' => $this->findUser($nickname),
            'currentUser' => $currentUser,
        ]);
    }

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

    /**
     * Fake user accounts generator
     */
//
//    public function actionGenerate()
//    {
//        $faker = Factory::create();
//
//        for ($i = 0; $i < 1000; $i++) {
//            $user = new user([
//                'username' => $faker->name,
//                'email' => $faker->email,
//                'about' => $faker->text(200),
//                'nickname' => $faker->regexify('A-Za-z0-9_{5,15}'),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//            $user->save(false);
//        }
//    }
}