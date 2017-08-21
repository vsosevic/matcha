<?php 

namespace app\controllers;

use yii\web\Controller;
use app\models\Chat;
use app\models\Users;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use Yii;

class ChatController extends Controller
{
    public function actionIndex ()
    {

        $usersForQuery = Chat::getAllUsersChattingWith();

        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT * FROM Users WHERE id IN (". $usersForQuery .")",
            'totalCount' => 1,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                ]
            ],
        ]);

        $this->view->title = 'Chat';
        return $this->render('index', ['dataProvider' => $dataProvider]);

        // $messages = Chat::find()
        //     ->where(['message_from' => 1])
        //     ->orWhere(['message_to' => 1])
        //     ->orderBy('date')
        //     ->all();

        // var_dump($message_from);
    }

    public function actionWith ($user_name)
    {
        $userChattingWith = Users::findByUserName($user_name);

        $userId = Users::findByUsername($user_name);

        $messages = Chat::getAllMessagesBetweenUsers($userId->Id, Yii::$app->user->identity->Id);
        
        foreach ($messages as $message) {
            echo $message->message . "<br>";
        }
    }
}

?>