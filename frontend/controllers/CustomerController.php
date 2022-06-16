<?php

namespace frontend\controllers;
use Yii;
use frontend\models\User;
use frontend\models\OrderTabel;
use frontend\models\Order;
use frontend\models\OrderItem;
use frontend\models\Customer;
use frontend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Customer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //tutup ke 3
        //$searchModel = new CustomerSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        $userdata = count(Customer::find()->where(['user_id' => Yii::$app->user->identity->id])->one());
        $query = Customer::find()->where(['user_id' => Yii::$app->user->identity->id]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        $dataProvider = new ActiveDataProvider(['query' => $query,
        ]);
        return $this->render('index', ['userData' => $userdata,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShowOrder(){
        $model1=new OrderTabel();
        $model2=new OrderItem();
        $models1=$model1->daftarOrderCustomer();
        $models2=$model2->daftarOrderItem();
            return $this->render('show-order', [
                'models1' => $models1,
                'models2' => $models2,
            ]);
    }

    /**
     * Displays a single Customer model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Customer();
        //tambahan
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } //else {
            $model->loadDefaultValues();
        //}

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
