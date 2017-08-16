<?php 

namespace app\controllers;

use yii\web\Controller;
use app\models\Chat;
use app\models\Users;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;

class ChatController extends Controller
{
    public function actionIndex ()
    {
        
        $allUsersIdChattingWith = array();
        
        $messages = Chat::find()
            ->where(['message_from' => 1])
            ->all();

        foreach ($messages as $value) {
            $allUsersIdChattingWith[] = $value->message_to;
        }

        $messages = Chat::find()
            ->where(['message_to' => 1])
            ->all();
            
        foreach ($messages as $value) {
            $allUsersIdChattingWith[] = $value->message_from;
        }

        $allUsersIdChattingWith = array_unique($allUsersIdChattingWith);

        $usersForQuery = implode(',', $allUsersIdChattingWith);

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
}

?>