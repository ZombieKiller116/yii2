<?php

    use yii\helpers\Html;
    use yii\captcha\Captcha;
    use yii\widgets\ActiveForm;
?>
<div class="custom-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h1 class="h1">Войти</h1>
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'email'); ?>
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                    <?= $form->field($model, 'captcha')->widget(Captcha::className()); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end(); ?>
                <?php if( Yii::$app->session->hasFlash('login-error') ): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= Yii::$app->session->getFlash('login-error'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>