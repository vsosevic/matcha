
<?php
use yii\helpers\Html;
use app\models\Users;
use app\models\Cities;

$this->title = $model->user_name . "'s profile";
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl ?>/matchaJS/like.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl ?>/matchaJS/block-fake.js"></script>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Section with 1 avatar and user info -->
<div class="row is-table-row bg-success">
	<?php foreach($avatars as $avatar): ?>

		<?php if ($avatar !== "sources/no_image.png" && !is_numeric($avatar)): ?>
			<div class="col-sm-2 text-center">
				<img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatar ?>" class="img-responsive">
			</div>
		<?php endif; ?>

	<?php endforeach; ?>
</div>

<!-- Section with 4 more avatars -->
<div class="row" style="padding: 20px;">
	

	<div class="col-sm-12 bg-info">
		<h3><?php echo $model->first_name. " " .$model->last_name; ?>
			<small> <?php echo $model->user_name ?> </small>
			<div class="online-status"></div>
		</h3>
		<br>
		<hr>
		<p>
			<span class="text-muted">Gender: </span>
			<span><?php echo $model->genderList[$model->gender] ?></span>
		</p>
		<p>
			<span class="text-muted">Orientation: </span>
			<span><?php echo $model->orientationList[$model->orientation] ?></span>
		</p>
		<p>
			<span class="text-muted">Interests: </span>
			<span><?php echo $interests ?></span>
		</p>
		<p>
			<span class="text-muted">City: </span>
			<span><?php echo Cities::getCityToStringById($model->city_id) ?></span>
		</p>
		<p>
			<span class="text-muted">About: </span>
			<span><?php echo $model->about ?></span>
		</p>
		<p>
			Fame-rating: <code> <?php echo $model->fame_rating; ?> </code>
		</p>
	</div>
</div>

<div class="col-sm-2 user-id-like" >
	<a href="#" class="like" id="<?php echo $model->Id ?>" class="text-center" <?php if(in_array($model->id, $likes)) { echo "style='display: none;'"; } ?> >
	    <img src="<?php echo Yii::$app->request->baseUrl . '/sources/like.png' ?>" class="img img-responsive">
	</a>
	<a href="#" class="like" id="<?php echo $model->Id ?>" class="text-center" <?php if(!in_array($model->id, $likes)) { echo "style='display: none;'"; } ?> >
	    <img src="<?php echo Yii::$app->request->baseUrl .'/sources/liked.png' ?>" class="img img-responsive">
	</a>
</div>

<div class="col-sm-2 user-id-block" >
    <a href="#" class="block" id="<?php echo $model->Id ?>" class="text-center" <?php if($blocked) { echo "style='display: none;'"; } ?> >
        <img src="<?php echo Yii::$app->request->baseUrl . '/sources/block.png' ?>" class="img img-responsive">
    </a>
    <a href="#" class="block" id="<?php echo $model->Id ?>" class="text-center" <?php if(!$blocked) { echo "style='display: none;'"; } ?> >
        <img src="<?php echo Yii::$app->request->baseUrl .'/sources/unblock.png' ?>" class="img img-responsive">
    </a>
</div>

<div class="col-sm-2 user-id-fake" >
    <a href="#" class="fake" id="<?php echo $model->Id ?>" class="text-center" >
        <img src="<?php echo Yii::$app->request->baseUrl . '/sources/fake.png' ?>" class="img img-responsive">
    </a>
</div>

<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl ?>/matchaJS/online-status.js"></script>
