
<?php
use yii\helpers\Html;
use app\models\Users;
use app\models\Cities;

$this->title = 'Account settings';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row is-table-row">
	<div class="col-sm-4 bg-success text-center">
		<a href="upload-avatar?avatarId=avatar1"><img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatars->avatar1 ?>" class="img-circle img-responsive center-block"></a>
		<br>
		Fame-rating: <code> <?php echo $model->fame_rating; ?> </code>
	</div>
	<div class="col-sm-8 bg-info">
		<h3><?php echo $model->first_name. " " .$model->last_name; ?>
			<small> <?php echo $model->user_name ?> </small>
			<a href="editsettings"><button class="btn pull-right btn-primary"><span class="glyphicon glyphicon-edit ">Edit</span></button></a>
		</h3>
		<br>
		<hr>
		<p>
			<span class="text-muted">Email: </span>
			<span><?php echo $model->email ?></span>
		</p>
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
	</div>
</div>

<div class="row bg-success" style="padding: 20px;">
	<div class="col-sm-3">
		<a href="upload-avatar?avatarId=avatar2"><img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatars->avatar2 ?>" class="img-responsive"></a>
	</div>
	<div class="col-sm-3">
		<a href="upload-avatar?avatarId=avatar3"><img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatars->avatar3 ?>" class="img-responsive"></a>
	</div>
	<div class="col-sm-3">
		<a href="upload-avatar?avatarId=avatar4"><img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatars->avatar4 ?>" class="img-responsive"></a>
	</div>
	<div class="col-sm-3">
		<a href="upload-avatar?avatarId=avatar5"><img src="<?php echo Yii::$app->request->baseUrl . '/' . $avatars->avatar5 ?>" class="img-responsive"></a>
	</div>
</div>

<div id='demo'></div>

<?php
	// echo ($_SERVER['SERVER_ADDR']);
  // print_r(yii::$app->geolocation->getInfo('173.194.118.22'));
print_r(yii::$app->geoplugin->locateCity()['geoplugin_countryName']);

?>

<script type="text/javascript" src="/matcha/web/assets/matchaJS/geoscript.js"></script>



