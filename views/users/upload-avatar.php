<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Edit avatar';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['settings']];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model app\models\EditSettingsForm */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($avatars, $_GET['avatarId'])->fileInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save changes', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- raw -->
