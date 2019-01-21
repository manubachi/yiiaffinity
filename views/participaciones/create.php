<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Participaciones */

$this->title = 'Create Participaciones';
$this->params['breadcrumbs'][] = ['label' => 'Participaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participaciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
