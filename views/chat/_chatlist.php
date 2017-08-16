<?php
use app\models\Cities;
use app\models\Userstointerests;
use app\models\Avatars;
use yii\grid\GridView;

/* @var $this yii\web\View */

// $this->title = 'Matcha';
?>

<div class="row is-table-row">

    <div class="col-sm-4 bg-success text-center">
        <img src="<?php echo Yii::$app->request->baseUrl . '/' . Avatars::getAvatarsByUserId($model['Id'])->avatar1 ?>" class="img-circle img-responsive center-block">
        <br>
        Fame-rating: <code> <?php echo $model['fame_rating']; ?> </code>
    </div>
    
    <div class="col-sm-4 bg-info">
        <h3><?php echo $model['first_name']. " " .$model['last_name']; ?>
            <small> <?php echo $model['user_name'] ?> </small>
        </h3>
        <br>
        <hr>
        <p>
            <span class="text-muted">Email: </span>
            <span><?php echo $model['email'] ?></span>
        </p>
        <p>
            <span class="text-muted">Gender: </span>
        </p>
        <p>
            <span class="text-muted">Orientation: </span>
        </p>
        <p>
            <span class="text-muted">Interests: </span>
        </p>
        <p>
            <span class="text-muted">City: </span>
        </p>
        <p>
            <span class="text-muted">About: </span>
        </p>
    </div>
    
</div>        
