<?php

namespace app\controllers;

use app\models\PeliculasForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    /**
     * Genera el listado de películas.
     * @return string Vista del listado de las películas
     */
    public function actionIndex()
    {
        $filas = \Yii::$app->db
            ->createCommand('SELECT p.*, g.genero
                               FROM peliculas p
                               JOIN generos g
                                 ON p.genero_id = g.id
                           ORDER BY titulo')->queryAll();
        return $this->render('index', [
            'filas' => $filas,
        ]);
    }

    /**
     * Crea una nueva película.
     * @return string Devuelve la vista index, si se ha creado la película, o la vista create si no.
     */
    public function actionCreate()
    {
        $peliculasForm = new PeliculasForm();

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('peliculas', $peliculasForm->attributes)
                ->execute();
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'peliculasForm' => $peliculasForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    /**
     * Modifica una película.
     * @param  int $id   ID de la película a modificar.
     * @return Response  Redirección a index.
     */
    public function actionUpdate($id)
    {
        $peliculasForm = new PeliculasForm(['attributes' => $this->buscarPelicula($id)]);

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('peliculas', $peliculasForm->attributes, ['id' => $id])
                ->execute();
            return $this->redirect(['peliculas/index']);
        }

        return $this->render('update', [
            'peliculasForm' => $peliculasForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    /**
     * Borra una película.
     * @param  int $id   ID de la película a borrar.
     * @return Response  Redirección a index.
     */
    public function actionDelete($id)
    {
        Yii::$app->db->createCommand()->delete('peliculas', ['id' => $id])->execute();
        return $this->redirect(['peliculas/index']);
    }

    /**
     * Genera un array con clave = id de los géneros y valor = nombre del género.
     * @return array array de géneros.
     */
    private function listaGeneros()
    {
        $generos = Yii::$app->db->createCommand('SELECT * FROM generos')->queryAll();
        $listaGeneros = [];
        foreach ($generos as $genero) {
            $listaGeneros[$genero['id']] = $genero['genero'];
        }
        return $listaGeneros;
    }

    /**
     * Busca una película.
     * @param  int     $id ID de la pelicula a buscar.
     * @return string      Datos de la película buscada.
     */
    private function buscarPelicula($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM peliculas
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
