<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador peliculas.
 */
class GenerosController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Genera el listado de géneros.
     * @return string Vista del listado de los géneros
     */
    public function actionIndex()
    {
        $count = Yii::$app->db
            ->createCommand('SELECT count(*) FROM generos')
            ->queryScalar();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);
        $filas = \Yii::$app->db
            ->createCommand('SELECT g.*, count(p.id) AS cantidad
                               FROM generos g
                          LEFT JOIN peliculas p
                                 ON g.id = p.genero_id
                           GROUP BY g.id
                           ORDER BY genero
                              LIMIT :limit
                             OFFSET :offset', [
                        ':limit' => $pagination->limit,
                        ':offset' => $pagination->offset,
            ])->queryAll();
        return $this->render('index', [
            'filas' => $filas,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Crea un nuevo género.
     * @return string Devuelve la vista index, si se ha creado el género, o la vista create si no.
     */
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

    /**
     * Borra un género.
     * @param  int $id   ID del género a borrar.
     * @return Response  Redirección a index.
     */
    public function actionDelete($id)
    {
        $fila = $this->comprobarGenero($id);

        if (!empty($fila)) {
            Yii::$app->session->setFlash('error', 'No se puede borrar porque hay películas de este género');
        } else {
            Yii::$app->db->createCommand()->delete('generos', ['id' => $id])->execute();
            Yii::$app->session->setFlash('warning', 'Género borrado correctamente');
        }
        return $this->redirect(['generos/index']);
    }

    /**
     * Modifica un género.
     * @param  int $id   ID del género a modificar.
     * @return Response  Redirección a index.
     */
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

    /**
     * Función que busca el género correspondiente al id en la tabla de géneros.
     * @param  [type] $id Id correspondiente al genero que se desea buscar.
     * @return [type]     Datos del genero que se ha buscado.
     */
    private function buscarGenero($id)
    {
        $fila = Yii::$app->db->createCommand('SELECT *
                                                FROM generos
                                               WHERE id = :id', [':id' => $id])
                             ->queryOne();

        if (empty($fila)) {
            throw new NotFoundHttpException('Ese género no existe.');
        }
        return $fila;
    }

    /**
     * Función que comprueba si el género tiene películas en la tabla peliculas.
     * @param  [type] $id Id del género que se quiere comprobar.
     * @return [type]     Estado de la consulta.
     */
    private function comprobarGenero($id)
    {
        $fila = \Yii::$app->db
                        ->createCommand('SELECT *
                                           FROM peliculas
                                          WHERE genero_id = :genero_id
                                          LIMIT 1', [':genero_id' => $id])
                        ->queryOne();

        return $fila;
    }
}
