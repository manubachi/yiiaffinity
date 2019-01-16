<?php

namespace app\controllers;

use app\models\BuscarForm;
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

        $query = (new \yii\db\Query())
            ->select(['p.*', 'g.genero'])
            ->from('peliculas p')
            ->innerJoin('generos g', 'p.genero_id = g.id');

        if ($buscarForm->load(Yii::$app->request->post()) && $buscarForm->validate()) {
            $query->andFilterWhere(['ilike', 'titulo', $buscarForm->titulo]);
            $query->andFilterWhere(['p.genero_id' => $buscarForm->genero_id]);
        }

        if (empty($sort->orders)) {
            $query->orderBy(['p.id' => SORT_ASC]);
        } else {
            $query->orderBy($sort->orders);
        }

        return $this->render('index', [
            'filas' => $query->all(),
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

    public function actionVer($id)
    {
        $peliculasForm = new PeliculasForm(['attributes' => $this->buscarPelicula($id)]);
        $peliculasForm->genero_id = (new \yii\db\Query())
            ->select('genero')
            ->from('generos')
            ->where(['id' => $peliculasForm->genero_id])
            ->scalar();

        return $this->render('ver', [
            'peliculasForm' => $peliculasForm,
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
        return (new \yii\db\Query())
            ->select('genero')
            ->from('generos')
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
        $fila = (new \yii\db\Query())
            ->from('peliculas')
            ->where(['id' => $id])
            ->one();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
