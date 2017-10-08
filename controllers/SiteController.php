<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\Users;
use app\models\Likes;
use app\models\Avatars;
use app\models\Userstointerests;
use app\models\Cities;
use app\models\Visits;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage with matched users.
     *
     * @return string
     */
    public function actionIndex()
    {
        $myself = "''";

        $likes = array();

        if (isset(Yii::$app->user->identity->Id)) {
            $myself = Yii::$app->user->identity->Id;
            $likes = Likes::getLikesForUser();
        }

        $query = Users::find()
        ->joinWith('city', true)
        ->where(['fame_rating' => 1])
        ->andWhere(['<>', 'Users.Id', $myself]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'Id' => SORT_DESC,
                    'age' => SORT_ASC, 
                ]
            ],
        ]);

        $isAbleToLike = Avatars::isAbleToLike(Yii::$app->user->identity->Id);

        $this->view->title = 'Your best matches';
        return $this->render('index', ['dataProvider' => $dataProvider, 'likes' => $likes, 'isAbleToLike' => $isAbleToLike]);
    }

    /**
     * Page with users who's visited me
     *
     * @return string
     */
    public function actionVisits()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $likes = Likes::getLikesForUser();

        $visits = Visits::getVisitsFromUsers();

        $query = Users::find()
        ->joinWith('city', true)
        ->where(['in', 'Users.Id', $visits]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $isAbleToLike = Avatars::isAbleToLike(Yii::$app->user->identity->Id);

        $this->view->title = "See who's come to your profile";
        return $this->render('index', ['dataProvider' => $dataProvider, 'likes' => $likes, 'isAbleToLike' => $isAbleToLike]);
    }

    /**
     * Page with users I've visited
     *
     * @return string
     */
    public function actionVisited()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $likes = Likes::getLikesForUser();

        $visits = Visits::getVisitedUsers();

        $query = Users::find()
        ->joinWith('city', true)
        ->where(['in', 'Users.Id', $visits]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $isAbleToLike = Avatars::isAbleToLike(Yii::$app->user->identity->Id);

        $this->view->title = "See whom you've visited";
        return $this->render('index', ['dataProvider' => $dataProvider, 'likes' => $likes, 'isAbleToLike' => $isAbleToLike]);
    }

    /**
     * Page with users who liked you
     *
     * @return string
     */
    public function actionLiked()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $likes = Likes::getLikesForUser();

        $liked = Likes::getLikesFromUsers();

        $query = Users::find()
        ->joinWith('city', true)
        ->where(['in', 'Users.Id', $liked]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $isAbleToLike = Avatars::isAbleToLike(Yii::$app->user->identity->Id);

        $this->view->title = "See whom you've visited";
        return $this->render('index', ['dataProvider' => $dataProvider, 'likes' => $likes, 'isAbleToLike' => $isAbleToLike]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}