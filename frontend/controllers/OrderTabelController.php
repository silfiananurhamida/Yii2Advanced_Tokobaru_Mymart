<?php

namespace frontend\controllers;

use frontend\models\OrderTabel;
use frontend\models\OrderTabelSearch;

use frontend\models\Item;
use frontend\models\OrderItem;
use frontend\models\ItemSearch;
use frontend\models\Customer;

use yii\base\InvalidParamException;
USE yii\web\BadRequestHttpException;
use yii\web\Controller;

use yii\web\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderTabelController implements the CRUD actions for OrderTabel model.
 */
class OrderTabelController extends Controller
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
     * Lists all OrderTabel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$searchModel = new OrderTabelSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

        $cartlist = $this->getCartList();
        $ordertabellist = Item::find->where(['id' => $cartlist]);

        $dataProvider = new ActiveDataProvider([
            'query' => $ordertabellist
        ]);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderTabel model.
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
     * Creates a new OrderTabel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCheckout(){
        $carlist = $this->getCartList();
        $transaction = Order :: getDb()->beginTransaction();
        try{
            $customer = Customer::findOne([
                'user_id' => Yii::$app->user->identity->id;
            ]);
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->save();

            $orderId = Order::find([
                'customer_id' => $customer->id
            ])->orderBy('id DESC')->one();

            for ($i=0; $i < sizeof($cartlist); $i++){
                $OrderItems = new OrderItem();
                $OrderItems->order_id = $orderId->id;
                $OrderItems->item_id = $cartlist[$i];
                $OrderItems->save();
            }
            $transaction->commit();
            $this->removeCartList();
        } catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }
        return $this->render('checkout');
    }
    public function actionClear(){
        $this->removeCartList();
        $this->redirect(['order/index']);
    }

    public function getCartList(){
        $count = 0;
        $cartlist = [];
        $cookies = Yii::$app->request->cookies;
        if($cookies->has('totalcart')){
            for ($i=0; $i<=$count; $i++){
                array_push($cartlist, $cookies->getValue('totalcart'));
            }
        }

        return $cartlist;
    }

    public function removeCartList(){
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('totalcart')){
            $cookies = Yii::$app->response->cookies;
            for($i=0; $i<=$count; $i++){
                $cookies->remove('cart'.$i);
            }
            $cookies->remove('totalcart');
        }

    }


    public function actionCreate()
    {
        $model = new OrderTabel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } /*else {
            $model->loadDefaultValues();
        }*/

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrderTabel model.
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
     * Deletes an existing OrderTabel model.
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
     * Finds the OrderTabel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OrderTabel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderTabel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
