<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Participaciones */

$this->title = 'Update Participaciones: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Participaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pelicula_id, 'url' => ['view', 'pelicula_id' => $model->pelicula_id, 'persona_id' => $model->persona_id, 'papel_id' => $model->papel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="participaciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
