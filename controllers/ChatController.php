<?php 

namespace app\controllers;

use yii\web\Controller;
use app\models\Chat;
use app\models\Avatars;
use app\models\Users;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use Yii;
// use yii\helpers\Url;

class ChatController extends Controller
{

    // public function beforeAction()
    // {
    //     if (Yii::$app->user->isGuest)
    //     {
    //         return $this->redirect(Url::to(['users/login'])); 
    //     }
    // }

    public function actionIndex ()
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(['users/login']); 

        $usersForQuery = Chat::getAllUsersChattingWith();

        $usersWithMutualLikes = Chat::getAllUsersWithMutualLikes();

        $this->view->title = 'Chat';

        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT * FROM Users WHERE id IN (". $usersWithMutualLikes .")",
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

    }

    public function actionWith ($user_name)
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(['users/login']);
        // $userChattingWith = Users::findByUserName($user_name);

        // $userId = Users::findByUsername($user_name);

        // $messages = Chat::getAllMessagesBetweenUsers($userId->Id, Yii::$app->user->identity->Id);
        
        // foreach ($messages as $message) {
        //     echo $message->message . "<br>";
        // }
        return $this->render('chatroom', ['chatWith' => $user_name]);
    }

    public function actionGetMessageHistory()
    {
        $user_name = $_POST['data'];
        json_decode($user_name);

        $userChattingWith = Users::findByUsername($user_name);

        $messages = Chat::getAllMessagesBetweenUsers($userChattingWith->Id, Yii::$app->user->identity->Id);
        $chat = array();
        $i = 0;
        foreach ($messages as $message) {
            if ($message->message_from == Yii::$app->user->identity->Id) {
                $chat[$i]['writtenBy'] = "me";
            } else {
                $chat[$i]['writtenBy'] = "you";
                $message->seen = 1;
                $message->save();
            }
            $chat[$i]['message'] = $message->message;
            $chat[$i]['date'] = $message->date;

            $i++;
        }
        if(!empty($chat)) {
            // recerse chat so that we have correct order from bottom to top in the chat
            print(json_encode(array_reverse($chat)));
        }
    }

    public function actionGetNewMessage()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $userChattingWith = Users::findByUsername($_GET['chatWith']);
        $stringMessages = Chat::getNewMessagesBetweenUsers($userChattingWith->Id, Yii::$app->user->identity->Id);
        echo "data: $stringMessages\n\n";
        flush();
    }

    public function actionSendMessage()
    {
        $user_name = $_POST['chatWith'];
        $message = $_POST['message'];
        json_decode($message);
        json_decode($user_name);


        $userChattingWith = Users::findByUsername($user_name);

        $chat = new Chat;
        $chat->message_from = Yii::$app->user->identity->Id;
        $chat->message_to = $userChattingWith->Id;
        $chat->message = $message;
        $chat->save();

        print(json_encode($message));
    }

    public function actionGetAvatarsForChat()
    {
        $user_name = $_POST['chatWith'];
        json_decode($user_name);

        $userChattingWith = Users::findByUsername($user_name);

        $json_response = array();
        $json_response['me'] = Avatars::getAvatarsByUserId(Yii::$app->user->identity->Id)->avatar1;
        $json_response['you'] = Avatars::getAvatarsByUserId($userChattingWith->Id)->avatar1;

        print(json_encode($json_response));
    }

}

?>