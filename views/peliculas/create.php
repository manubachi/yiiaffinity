<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Insertar una nueva película';
$this->params['breadcrumbs'][] = ['label' => 'Películas', 'url' => ['peliculas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin() ?>
<<<<<<< HEAD
    <?= $form->field($peliculasForm, 'titulo') ?>
    <?= $form->field($peliculasForm, 'anyo') ?>
    <?= $form->field($peliculasForm, 'sinopsis')->textarea() ?>
    <?= $form->field($peliculasForm, 'duracion') ?>
    <?= $form->field($peliculasForm, 'sinopsis')->textarea() ?>
    <?= $form->field($peliculasForm, 'genero_id')->dropDownList($listaGeneros) ?>
=======
    <?= $form->field($pelicula, 'titulo') ?>
    <?= $form->field($pelicula, 'anyo') ?>
    <?= $form->field($pelicula, 'sinopsis')->textarea() ?>
    <?= $form->field($pelicula, 'duracion') ?>
    <?= $form->field($pelicula, 'genero_id') ?>
>>>>>>> 9fd3144f2022ca97c21460f209968cc9b8b69915
    <div class="form-group">
        <?= Html::submitButton('Insertar película', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
