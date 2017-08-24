<?php 

namespace app\controllers;

use yii\web\Controller;
use app\models\Chat;
use app\models\Users;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use Yii;
use yii\helpers\Url;

class ChatController extends Controller
{
    public function actionIndex ()
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['users/login'])); 

        $usersForQuery = Chat::getAllUsersChattingWith();

        $this->view->title = 'Chat';

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
        
        // foreach ($messages as $message) {
        //     echo $message->message . "<br>";
        // }

        return $this->render('chatroom');
    }

    public function actionGetMessageHistory()
    {
        $user_name = $_POST['data'];
        json_decode($user_name);

        $userId = Users::findByUsername($user_name);

        $messages = Chat::getAllMessagesBetweenUsers($userId->Id, Yii::$app->user->identity->Id);
        $chat = array();
        $i = 0;
        foreach ($messages as $message) {
            if ($message->message_from == Yii::$app->user->identity->Id) {
                $chat[$i]['writtenBy'] = "me";
            } else {
                $chat[$i]['writtenBy'] = "you";
            }
            $chat[$i]['message'] = $message->message;
            $chat[$i]['date'] = $message->date;
            $i++;
        }
        print(json_encode($chat));
    }

    public function actionGetNewMessage()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        // echo "data: $chat\n\n";
        // flush();
    }

}

?>