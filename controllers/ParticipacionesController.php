<?php

namespace app\controllers;

use app\models\Papeles;
use app\models\Participaciones;
use app\models\Peliculas;
use app\models\Personas;
use Yii;

class ParticipacionesController extends \yii\web\Controller
{
    public function actionUpdate($pelicula_id)
    {
        $pelicula = Peliculas::findOne($pelicula_id);
        $participaciones = Participaciones::find()
            ->where(['pelicula_id' => $pelicula_id])
            ->all();

        return $this->render('update', [
            'pelicula' => $pelicula,
            'participaciones' => $participaciones,
        ]);
    }

    public function actionDelete($pelicula_id, $persona_id, $papel_id)
    {
        $participacion = Participaciones::findOne([
            'pelicula_id' => $pelicula_id,
            'persona_id' => $persona_id,
            'papel_id' => $papel_id,
        ]);

        $participacion->delete();
        return $this->redirect([
            'participaciones/update',
            'pelicula_id' => $pelicula_id,
        ]);
    }

    public function actionCreate($pelicula_id)
    {
        $participaciones = new Participaciones();
        $pelicula = Peliculas::findOne($pelicula_id);
        if ($participaciones->load(Yii::$app->request->post()) && $participaciones->save()) {
            return $this->redirect([
                'peliculas/ver',
                'id' => $pelicula_id,
            ]);
        }
        return $this->render('create', [
            'participaciones' => $participaciones,
            'pelicula' => $pelicula,
            'listaPersonas' => ['' => ''] + $this->listaPersonas(),
            'listaPapeles' => ['' => ''] + $this->listaPapeles(),
        ]);
    }

    private function listaPersonas()
    {
        return Personas::find()
            ->select('nombre')
            ->indexBy('id')
            ->column();
    }

    private function listaPapeles()
    {
        return Papeles::find()
            ->select('papel')
            ->indexBy('id')
            ->column();
    }
}
