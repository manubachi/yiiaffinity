<?php

namespace app\controllers;

use app\models\Generos;
use app\models\Peliculas;
use app\models\PeliculasSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->login === 'admin';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->request->get('id') == 1;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionPrueba()
    {
        $provider = new ActiveDataProvider([
            'query' => Peliculas::find(),
            'pagination' => [
                'pageSize' => 2,
            ],
            'sort' => [
                'attributes' => [
                    'titulo',
                    'anyo',
                ],
            ],
        ]);
        var_dump($provider->models);
        var_dump($provider->count);
        var_dump($provider->totalCount);
    }

    /**
     * Genera el listado de películas.
     * @return string Vista del listado de las películas
     */
    public function actionIndex()
    {
        $searchModel = new PeliculasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Crea una nueva película.
     * @return string Devuelve la vista index, si se ha creado la película, o la vista create si no.
     */
    public function actionCreate()
    {
        $pelicula = new Peliculas();

        if (Yii::$app->request->isAjax && $pelicula->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($pelicula);
        }

        if ($pelicula->load(Yii::$app->request->post()) && $pelicula->save()) {
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'pelicula' => $pelicula,
            'listaGeneros' => ['' => ''] + $this->listaGeneros(),
        ]);
    }

    public function actionView($id)
    {
        return $this->actionVer($id);
    }

    public function actionVer($id)
    {
        $pelicula = $this->buscarPelicula($id);

        $participantes = (new \yii\db\Query())
            ->select(['personas.nombre', 'papeles.papel'])
            ->from('participaciones')
            ->innerJoin('personas', 'persona_id = personas.id')
            ->innerJoin('papeles', 'papel_id = papeles.id')
            ->where(['pelicula_id' => $pelicula->id])
            ->all();
        $participantes = ArrayHelper::index($participantes, null, 'papel');

        return $this->render('ver', [
            'pelicula' => $pelicula,
            'participantes' => $participantes,
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
        $fila = Peliculas::find()
            ->where(['id' => $id])
            ->with([
                'participaciones.persona',
                'participaciones.papel',
            ])
            ->one();
        if ($fila === null) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
