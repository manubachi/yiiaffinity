<?php
use app\models\Papeles;

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = 'Ver una película';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= DetailView::widget([
    'model' => $pelicula,
    'attributes' => [
        'titulo',
        'anyo',
        [
            'label' => 'Duración',
            'value' => $pelicula->duracion * 60,
            'format' => 'duration',
        ],
        'sinopsis', 
        'created_at:datetime',
        'precio:currency',
    ],
]) ?>

<?php foreach ($participantes as $papel => $personas): ?>
    <dl class="dl-horizontal">
        <dt><?= Html::encode($papel) ?></dt>
        <?php foreach ($personas as $persona): ?>
            <dd><?= Html::encode($persona['nombre']) ?></dd>
        <?php endforeach ?>
    </dl>
<?php endforeach ?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
    <div class="form-group">
        <?= Html::a(
            'Modificar participaciones',
            [
                'participaciones/update',
                'pelicula_id' => $pelicula->id,
            ],
            ['class' => 'btn btn-info']
            ) ?>

            <?= Html::a(
                'Crear participaciones',
                [
                    'participaciones/create',
                    'pelicula_id' => $pelicula->id,
                ],
                ['class' => 'btn btn-success']
                ) ?>
    </div>
    <div class="form-group">
        <?= Html::a('Volver', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a(
                'Crear participaciones',
                [
                    'participaciones/create',
                    'pelicula_id' => $pelicula->id,
                ],
                ['class' => 'btn btn-success']
                ) ?>
    </div>
<?php ActiveForm::end() ?>
