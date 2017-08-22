<?php
use app\models\Avatars;

?>

<div class="col-sm-3 col-sm-offset-4 frame">
    <ul></ul>
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
