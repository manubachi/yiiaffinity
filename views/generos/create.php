<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Insertar un nuevo género';
$this->params['breadcrumbs'][] = ['label' => 'Géneros', 'url' => ['generos/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<div class="row">
    <?php $form = ActiveForm::begin();?>
        <?= $form->field($generosForm, 'genero') ?>
        <div class="form-group">
            <?= Html::submitButton('Insertar género', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancelar', ['generos/index'], ['class' => 'btn btn-danger']) ?>
        </div>
    <?php ActiveForm::end();?>
</div>
