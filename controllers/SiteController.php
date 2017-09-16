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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $myself = "''";
        $likes = array();

        if (isset(Yii::$app->user->identity->Id)) {
            $myself = Yii::$app->user->identity->Id;

            $queryLikes = Likes::find(['like_to'])
                ->where(['like_from' => Yii::$app->user->identity->Id])
                ->asArray()
                ->all();

            foreach ($queryLikes as $value) {
                $likes[] = $value['like_to'];
            }
        }

        $query = Users::find()
        ->joinWith('city', true)
        ->where(['fame_rating' => 1])
        ->andWhere(['<>', 'Users.Id', $myself]);
        // echo "<pre>";
        // var_dump($query); die();

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
        
        $this->view->title = 'Your best matches';
        return $this->render('index', ['dataProvider' => $dataProvider, 'likes' => $likes]);
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