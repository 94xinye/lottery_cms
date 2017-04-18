<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 14:51
 */

namespace app\modules\backend\controllers;
use app\models\Member;
use app\modules\backend\models\MemberSearch;
use app\modules\backend\models\ResetPasswordForm;
use Yii;
use app\modules\backend\components\BackendController;
use app\modules\backend\actions\ContentCheckAction;
use app\modules\backend\actions\ContentDeleteAllAction;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class MemberController extends BackendController
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
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->module->params['pageSize']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionResetpwd($id)
    {
        $model = new ResetPasswordForm();
        $model->user = $this->findModel($id);
        if(empty($model->user) || !($model->user instanceof Member)){
            $this->addFlash('用户不存在或者已删除');
        }
        if($model->load(Yii::$app->request->post()) && $model->saveEdit()){
            return $this->showFlash('重置密码成功', 'success');
        }
        return $this->render('reset-password',[
            'model'=>$model
        ]);
    }

    /**
     * Disable an existing Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        if($model->save(false)){
            return $this->showFlash('禁用成功','success',['index']);
        }
        return $this->showFlash('禁用失败','danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Enable an existing Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        if($model->save(false)){
            return $this->showFlash('启用成功','success',['index']);
        }
        return $this->showFlash('启用失败','danger',Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
