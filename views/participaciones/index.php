<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Participaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pelicula_id',
            'persona_id',
            'papel_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
