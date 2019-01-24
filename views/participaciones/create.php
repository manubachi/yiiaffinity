<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Insertar nueva participacion en ' . $pelicula->titulo;
?>
<h1><?= $this->title ?></h1>
<?php
    $inputOptions = [
        'inputOptions' => [
            'class' => 'form-control',
            'readonly' => true,
            'value' => $pelicula->id,
            'type' => 'hidden',
        ],
    ];
?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($participaciones, 'pelicula_id', $inputOptions) ?>
    <?= $form->field($participaciones, 'persona_id')->dropDownList($listaPersonas) ?>
    <?= $form->field($participaciones, 'papel_id')->dropDownList($listaPapeles)?>
    <div class="form-group">
        <?= Html::submitButton('Insertar participacion',
            [
                'class' => 'btn btn-primary'
            ])
        ?>
        <?= Html::a('Cancelar', [
            'peliculas/ver',
            'id' => $pelicula->id,
            ],
            ['class' => 'btn btn-danger']
        ) ?>
    </div>
<?php ActiveForm::end() ?>
