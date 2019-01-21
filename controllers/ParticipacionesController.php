<?php

namespace app\controllers;

use Yii;
use app\models\Participaciones;
use app\models\ParticipacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipacionesController implements the CRUD actions for Participaciones model.
 */
class ParticipacionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Participaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParticipacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participaciones model.
     * @param integer $pelicula_id
     * @param integer $persona_id
     * @param integer $papel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pelicula_id, $persona_id, $papel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($pelicula_id, $persona_id, $papel_id),
        ]);
    }

    /**
     * Creates a new Participaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participaciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pelicula_id' => $model->pelicula_id, 'persona_id' => $model->persona_id, 'papel_id' => $model->papel_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Participaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $pelicula_id
     * @param integer $persona_id
     * @param integer $papel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pelicula_id, $persona_id, $papel_id)
    {
        $model = $this->findModel($pelicula_id, $persona_id, $papel_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pelicula_id' => $model->pelicula_id, 'persona_id' => $model->persona_id, 'papel_id' => $model->papel_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Participaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $pelicula_id
     * @param integer $persona_id
     * @param integer $papel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pelicula_id, $persona_id, $papel_id)
    {
        $this->findModel($pelicula_id, $persona_id, $papel_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Participaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $pelicula_id
     * @param integer $persona_id
     * @param integer $papel_id
     * @return Participaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pelicula_id, $persona_id, $papel_id)
    {
        if (($model = Participaciones::findOne(['pelicula_id' => $pelicula_id, 'persona_id' => $persona_id, 'papel_id' => $papel_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
