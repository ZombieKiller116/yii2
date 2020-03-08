<?php

    use yii\helpers\Html;
    use yii\captcha\Captcha;
    use yii\widgets\ActiveForm;
?>
<div class="custom-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h1 class="h1">Регистрация</h1>
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'email'); ?>
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                    <?= $form->field($model, 'name'); ?>
                    <?= $form->field($model, 'captcha')->widget(Captcha::className()); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end(); ?>
                <?php if( Yii::$app->session->hasFlash('register-error') ): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach (Yii::$app->session->getFlash('register-error') as $key => $error): ?>
                            <?= Html::encode($error[0]); ?><br>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>