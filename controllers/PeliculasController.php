<?php

namespace app\controllers;

use app\models\BuscarForm;
use app\models\Generos;
use app\models\Peliculas;
use app\models\PeliculasForm;
use Yii;
use yii\data\Sort;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    public function actionPrueba()
    {
        Yii::$app->session->setFlash('error', 'Esto es un error.');
        return $this->redirect(['peliculas/index']);
    }

    /**
     * Genera el listado de películas.
     * @return string Vista del listado de las películas
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'titulo',
                'anyo',
                'duracion',
                'genero',
            ],
        ]);

        $buscarForm = new BuscarForm();
        $query = Peliculas::find();

        if ($buscarForm->load(Yii::$app->request->post()) && $buscarForm->validate()) {
            $query->andFilterWhere(['ilike', 'titulo', $buscarForm->titulo]);
            $query->andFilterWhere(['genero_id' => $buscarForm->genero_id]);
        }

        if (empty($sort->orders)) {
            $query->orderBy(['id' => SORT_ASC]);
        } else {
            $query->orderBy($sort->orders);
        }

        return $this->render('index', [
            'peliculas' => $query->all(),
            'sort' => $sort,
            'listaGeneros' => ['' => ''] + $this->listaGeneros(),
            'buscarForm' => $buscarForm,
        ]);
    }

    /**
     * Crea una nueva película.
     * @return string Devuelve la vista index, si se ha creado la película, o la vista create si no.
     */
    public function actionCreate()
    {
        $pelicula = new Peliculas();

        if ($pelicula->load(Yii::$app->request->post()) && $pelicula->save()) {
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'pelicula' => $pelicula,
        ]);
    }

    public function actionVer($id)
    {
        $pelicula = $this->buscarPelicula($id);
        // $peliculasForm = new PeliculasForm(['attributes' => $pelicula->attributes]);
        $pelicula->genero_id = $pelicula->genero->genero;

        return $this->render('ver', [
            'pelicula' => $pelicula,
        ]);
    }

    /**
     * Modifica una película.
     * @param  int $id   ID de la película a modificar.
     * @return Response  Redirección a index.
     */
    public function actionUpdate($id)
    {
        $pelicula = $this->buscarPelicula($id);

        if ($pelicula->load(Yii::$app->request->post()) && $pelicula->save()) {
            return $this->redirect(['peliculas/index']);
        }

        return $this->render('update', [
            'pelicula' => $pelicula,
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
        $this->buscarPelicula($id)->delete();
        return $this->redirect(['peliculas/index']);
    }

    /**
     * Genera un array con clave = id de los géneros y valor = nombre del género.
     * @return array array de géneros.
     */
    private function listaGeneros()
    {
        return Generos::find()
            ->select('genero')
            ->indexBy('id')
            ->column();
    }

    /**
     * Busca una película.
     * @param  int     $id ID de la pelicula a buscar.
     * @return string      Datos de la película buscada.
     */
    private function buscarPelicula($id)
    {
        $fila = Peliculas::findOne($id);
        if ($fila === null) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
