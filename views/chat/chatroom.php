<?php
use app\models\Avatars;

$this->title = $chatWith;
$this->params['breadcrumbs'][] = ['label' => 'Chat', 'url' => ['/chat/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="/matcha/web/assets/39607ace/jquery.js"></script>

<div class="col-sm-3 col-sm-offset-4 frame">
    <ul class="chat-ul"></ul>
    <div>
        <div class="msj-rta macro" style="margin:auto">                        
            <div class="text text-r" style="background:whitesmoke !important">
                <input class="mytext" placeholder="Type a message"/>
            </div> 
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl ?>/assets/matchaJS/chat.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl ?>/css/chat.css">
