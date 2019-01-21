<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Participaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pelicula_id')->textInput() ?>

    <?= $form->field($model, 'persona_id')->textInput() ?>

    <?= $form->field($model, 'papel_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
