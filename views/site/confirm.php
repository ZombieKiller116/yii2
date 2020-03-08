<?php

use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
/*
 * Выведем все сообщения в цикле.
 */
echo '<div class="fullscreen">';

    //Проверим, существует ли сессия по ключу
    if(Yii::$app->getSession()->hasFlash('mess')){
        echo Alert::widget([
            'options' => [
                'class' => 'alert alert-danger',
            ],
            'body' => Yii::$app->getSession('mess'),
        ]);
    }

echo '</div>';

?>

<div class="custom-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h1 class="h1">Подтверждение email</h1>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'token'); ?>
                <?= $form->field($model, 'captcha')->widget(Captcha::className()); ?>
                <div class="form-group">
                    <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']); ?>
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