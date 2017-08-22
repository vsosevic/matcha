<?php
use app\models\Avatars;

?>

<a href="with/<?php echo $model['user_name'] ?>" style="text-decoration: none;">

<div class="row is-table-row" style="margin-bottom: 10px;">

    <div class="col-sm-1 bg-success text-center">
        <img src="<?php echo Yii::$app->request->baseUrl . '/' . Avatars::getAvatarsByUserId($model['Id'])->avatar1 ?>" class="img-circle img-responsive center-block">
    </div>
    
    <div class="col-sm-11 bg-info">
        <h3><?php echo $model['first_name']. " " .$model['last_name']; ?>
            <small> <?php echo $model['user_name'] ?> </small>
        </h3>
        <p>
            <span class="text-muted">Email: </span>
            <span><?php echo $model['email'] ?></span>
        </p>
    </div>
    
</div>

</a>
