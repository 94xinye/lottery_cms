<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 15:38
 */

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;
use app\models\Products;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a('会员管理', ['index']) ?></li>
        </ul>
        <div class="tab-content">
            <?= GridView::widget([
                'layout'=>"{summary}\n{items}\n{pager}",
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'options' => ['style' => 'width:50px']
                    ],
                    'mobile',
                    'nickname',
                    'headimgurl',
                    [
                        'attribute' =>'score',
                        'options' => ['style' => 'width:50px']
                    ],
                    [
                        'attribute' => 'created_at',
                        'filterType'=>'date',
                        'format' => 'datetime',
                        'options' => ['style' => 'width:160px']
                    ],
                    [
                        'format' => 'raw',
                        'value' => function ($data) {
                            $html = '';
                            if($data->status){
                                $html .= '<a href="javascript:void(0);" class="badge">启用</a>&nbsp;&nbsp;';
                                $html .= '<a href="'.\yii\helpers\Url::to(['disable','id'=>$data->id]).'" class="badge bg-blue" data-confirm="确定禁用用户吗？">禁用</a>&nbsp;&nbsp;';
                            }else{
                                $html .= '<a href="'.\yii\helpers\Url::to(['enable','id'=>$data->id]).'" class="badge bg-blue" data-confirm="确定启用用户吗？">启用</a>&nbsp;&nbsp;';
                                $html .= '<a href="javascript:void(0);" class="badge">禁用</a>&nbsp;&nbsp;';
                            }
                            $html .= '<a href="'.\yii\helpers\Url::to(['resetpwd','id'=>$data->id]).'" class="badge bg-blue">重置密码</a>';
                            return $html;
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>