<?php
use app\models\Papeles;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ver una película';
$this->params['breadcrumbs'][] = $this->title;
?>
<dl class="dl-horizontal">
    <dt>Título</dt>
    <dd><?= Html::encode($pelicula->titulo) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Año</dt>
    <dd><?= Html::encode($pelicula->anyo) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Duración</dt>
    <dd><?= Html::encode($pelicula->duracion) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Género</dt>
    <dd><?= Html::encode($pelicula->genero->genero) ?></dd>
</dl>

<dl class="dl-horizontal">
    <dt>Sinópsis</dt>
    <dd><?= Html::encode($pelicula->sinopsis) ?></dd>
</dl>


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
    </div>
    <div class="form-group">
        <?= Html::a('Volver', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
