<?php
/**
 * Created by PhpStorm.
 * User: cleril
 * Date: 04.04.2019
 * Time: 22:16
 */

namespace frontend\modules\user\controllers;

use frontend\models\User;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function actionView($id)
    {

        return $this->render('view',[
            'user' => $this->findUser($id),
        ]);
    }

    private function findUser($id)
    {
        if($user = User::find()->where(['id'=> $id])->one()) {
            return $user;
        }
        throw new NotFoundHttpException();
    }
}