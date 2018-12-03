<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador peliculas.
 */
class GenerosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $filas = \Yii::$app->db->createCommand('SELECT *
                                                FROM generos')->queryAll();
        return $this->render('index', [
            'filas' => $filas,
        ]);
    }

    public function actionCreate()
    {
        $generosForm = new GenerosForm();

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('generos', $generosForm->attributes)
                ->execute();
            Yii::$app->session->setFlash('success', 'Género insertado correctamente');
            return $this->redirect(['generos/index']);
        }
        return $this->render('create', [
            'generosForm' => $generosForm,
        ]);
    }

    public function actionDelete($id)
    {
        $fila = $this->comprobarGenero($id);

        if ($fila != null) {
            Yii::$app->session->setFlash('error', 'No se puede borrar porque hay películas de este género');
            return $this->redirect(['generos/index']);
        }
        Yii::$app->db->createCommand()->delete('generos', ['id' => $id])->execute();
        Yii::$app->session->setFlash('warning', 'Género borrado correctamente');
        return $this->redirect(['generos/index']);
    }

    public function actionUpdate($id)
    {
        $generosForm = new GenerosForm(['attributes' => $this->buscarGenero($id)]);

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('generos', $generosForm->attributes, ['id' => $id])
                ->execute();
            Yii::$app->session->setFlash('success', 'Género modificado correctamente');
            return $this->redirect(['generos/index']);
        }

        return $this->render('update', [
            'generosForm' => $generosForm,
        ]);
    }

    private function buscarGenero($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Ese género no existe.');
        }
        return $fila;
    }

    private function comprobarGenero($id)
    {
        $fila = \Yii::$app->db->createCommand('SELECT *
                                                 FROM peliculas
                                                WHERE genero_id = :genero_id', [':genero_id' => $id])
                                                ->queryOne();
        return $fila;
    }
}
