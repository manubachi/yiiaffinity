<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Participaciones */

$this->title = $model->pelicula_id;
$this->params['breadcrumbs'][] = ['label' => 'Participaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="participaciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pelicula_id' => $model->pelicula_id, 'persona_id' => $model->persona_id, 'papel_id' => $model->papel_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pelicula_id' => $model->pelicula_id, 'persona_id' => $model->persona_id, 'papel_id' => $model->papel_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pelicula_id',
            'persona_id',
            'papel_id',
        ],
    ]) ?>

</div>
