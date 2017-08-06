<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserSettings */

$this->title = 'Update User Settings: ' . $model->Id;
$this->params['breadcrumbs'][] = ['label' => 'User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Id, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
