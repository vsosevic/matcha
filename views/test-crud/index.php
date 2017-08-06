<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TestCrudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Id',
            'user_name',
            'first_name',
            'last_name',
            'email:email',
            // 'password',
            // 'gender',
            // 'orientation',
            // 'about:ntext',
            // 'auth_key',
            // 'registration_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
