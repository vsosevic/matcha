<?php 

namespace app\controllers;

use yii\web\Controller;
use app\models\Chat;

class ChatController extends Controller
{
    public function actionIndex ()
    {
        $chat = new Chat;

        echo "<pre>";
        var_dump($chat->getMessageFrom());
    }
}

?>