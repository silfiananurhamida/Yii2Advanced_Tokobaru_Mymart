<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\ItemSearch;
use common\models\Statistic;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\MyComponent;
/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->actionRecord(Yii::$app->request);
        Yii::$app->MyComponent->trigger(MyComponent::EVENT_TRIGGER);
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        Yii::$app->MyComponent->trigger(MyComponent::EVENT_TRIGGER);
        //$this->actionRecord(Yii::$app->request);
        //var_dump (YII::$app->request->pathInfo); die();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    private function actionRecord($param)
    {
        $stats = new Statistic();
        $stats->access_time = date('Y-m-d H:i:s');
        $stats->user_ip = $param->userIP;
        $stats->user_host = $param->hostInfo;
        $stats->path_info = $param->pathInfo;
        $stats->query_string = $param->queryString;
        //var_dump($stats->user_host); die();
        $stats->save();
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
