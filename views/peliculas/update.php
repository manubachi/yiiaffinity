<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Modificar una nueva película';
$this->params['breadcrumbs'][] = ['label' => 'Películas', 'url' => ['peliculas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($peliculasForm, 'titulo') ?>
    <?= $form->field($peliculasForm, 'anyo') ?>
    <?= $form->field($peliculasForm, 'duracion') ?>
    <?= $form->field($peliculasForm, 'sinopsis') ?>
    <?= $form->field($peliculasForm, 'genero_id')->dropDownList($listaGeneros) ?>
    <div class="form-group">
        <?= Html::submitButton('Modificar película', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
