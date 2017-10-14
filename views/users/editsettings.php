<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Edit settings';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['settings']];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model app\models\EditSettingsForm */
/* @var $form ActiveForm */
?>

<?php if (Yii::$app->session->hasFlash('unfilled_acount')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?= Yii::$app->session->getFlash('unfilled_acount') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(); ?>

            <label>User Name</label>
            <p class="text-muted"><?php echo $model->user_name; ?></p>

            <?= $form->field($model, 'first_name') ?>
            <?= $form->field($model, 'last_name') ?>
            <?= $form->field($model, 'gender')->dropDownList($model->genderList); ?>
            <?= $form->field($model, 'orientation')->dropDownList($model->orientationList); ?>
            <?= $form->field($model, 'age')->textInput(['type' => 'number', 'min' => 18, 'max' => 150]); ?>

            <div class="form-group">
            <label>Interests (example:  #vegan #geek #piercing)</label>
            <?= Html::textInput('interests', $interests, $options = ['class' => 'form-control']) ?>
            </div>

            <div class="form-group">
            <label>City</label>
            <?= Html::textInput('userCity', $userCity, $options = ['class' => 'form-control']) ?>
            </div>

            <?= $form->field($model, 'about')->textarea(['rows' => '3']) ?>
            <?= $form->field($model, 'email') ?>

            <div class="form-group">
                <?= Html::submitButton('Save changes', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- raw -->
