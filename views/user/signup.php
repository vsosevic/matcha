<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Signing up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('signupFormSubmitted')): ?>

        <div class="alert alert-success">
            You're successfully signed up. Login and finish fill in your account data.
        </div>

    <?php else: ?>
        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                    <?= $form->field($model, 'user_name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'first_name') ?>

                    <?= $form->field($model, 'last_name') ?>

                    <?= $form->field($model, 'email')->input('email') ?>

                    <?= $form->field($model, 'password')->input('password') ?>

                    <?= $form->field($model, 'password_repeat')->input('password') ?>

                    <!-- <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
 -->
                    <div class="form-group">
                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'Signup']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>