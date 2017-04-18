<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Ad;
use app\modules\backend\models\AdSearch;
use app\modules\backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends BackendController
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
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        $searchModel = new AdSearch();
        $params = Yii::$app->request->queryParams;
        $params['AdSearch']['type'] = $type;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Ad();
        $model->type = $type;
        if ($model->load(Yii::$app->request->post())) {
            $model->online_at = $model::getDatetimeToAt($model->online_at);
            $model->offline_at = $model::getDatetimeToAt($model->offline_at);
            if($model->save()){
                return $this->showFlash('添加成功','success');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->online_at = $model::getDatetimeToAt($model->online_at);
            $model->offline_at = $model::getDatetimeToAt($model->offline_at);
            if($model->save()){
                return $this->showFlash('添加成功','success');
            }
        } else {
            $model->online_at = $model->getAtToDatetime($model->online_at);
            $model->offline_at = $model->getAtToDatetime($model->offline_at);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Sort an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSort($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save(false)){
                return $this->showFlash('修改成功','success');
            }
        } else {
            return $this->render('sort', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){

            return $this->showFlash('删除成功','success',['index']);
        }
        return $this->showFlash('删除失败','danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Disable an existing Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = 4;
        if($model->save(false)){
            return $this->showFlash('禁用成功','success',['index']);
        }
        return $this->showFlash('禁用失败','danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Enable an existing Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionEnable($id)
    {
        $t = time();
        $model = $this->findModel($id);
        if($model->online_at>$t){
            $model->status = 2;
        }else if($model->offline_at<$t){
            $model->status = 3;
        }else{
            $model->status = 1;
        }
        if($model->save(false)){
            return $this->showFlash('启用成功','success',['index']);
        }
        return $this->showFlash('启用失败','danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
