<?php

use yii\helpers\Html;
use app\modules\backend\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \app\models\Ad::$types[$searchModel->type];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adx-index">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><?= Html::a($this->title.'管理', ['index','type'=>$searchModel->type]) ?></li>
            <li role="presentation"><?= Html::a('添加'.$this->title, ['create','type'=>$searchModel->type]) ?></li>
        </ul>
        <div class="tab-content">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'layout'=>"{summary}\n{items}\n{pager}",
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'filterType'=>'date',
                        'attribute' => 'online_at',
                        'format' => 'datetime',
                        'options' => ['style' => 'width:160px']
                    ],
                    [
                        'filterType'=>'date',
                        'attribute' => 'offline_at',
                        'format' => 'datetime',
                        'options' => ['style' => 'width:160px']
                    ],
                    'title',
                    [
                        'label' => '图片',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $html = '<img width="60" src="'.$data->image.'"/>';
                            return $html;
                        },
                        'options' => ['style' => 'width:60px']
                    ],
                    'sort',
                    [
                        'format' => 'raw',
                        'attribute'=>'status',
                        'filter'=>$searchModel->statuses,
                        'value' => function ($data) {
                            $color = '';
                            switch($data->status){
                                case '1':
                                    $color = 'green';
                                    break;
                                case '2':
                                    $color = 'orange';
                                    break;
                                case '3':
                                    $color = 'gray';
                                    break;
                                case '4':
                                    $color = 'red';
                                    break;
                            }
                            return '<span style="color:'.$color.'">'.$data->statuses[$data->status].'</span>';
                        },
                    ],
                    [
                        'format' => 'raw',
                        'value' => function ($data) {
                            $html = '';
                            $html .= '<a href="'.\yii\helpers\Url::to(['update','id'=>$data->id]).'" class="badge bg-blue">编辑</a>&nbsp;&nbsp;';
                            if($data->status!='4'){
                                $html .= '<a href="javascript:void(0);" class="badge">启用</a>&nbsp;&nbsp;';
                                $html .= '<a href="'.\yii\helpers\Url::to(['disable','id'=>$data->id]).'" class="badge bg-blue" data-confirm="确定禁用吗？">禁用</a>&nbsp;&nbsp;';
                            }else{
                                $html .= '<a href="'.\yii\helpers\Url::to(['enable','id'=>$data->id]).'" class="badge bg-blue" data-confirm="确定启用吗？">启用</a>&nbsp;&nbsp;';
                                $html .= '<a href="javascript:void(0);" class="badge">禁用</a>&nbsp;&nbsp;';
                            }
                            $html .= '<a href="'.\yii\helpers\Url::to(['sort','id'=>$data->id]).'" class="badge bg-blue">排序</a>';
                            return $html;
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
