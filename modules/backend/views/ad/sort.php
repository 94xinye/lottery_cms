<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 18:36
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ad */

$this->title = '修改轮播图: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '轮播图管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="adx-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a('轮播图管理', ['index','type'=>$model->type]) ?></li>
            <li role="presentation"><?= Html::a('添加轮播图', ['create','type'=>$model->type]) ?></li>
            <li role="presentation" class="active"><?= Html::a('修改排序', 'javascript:void(0);') ?></li>
        </ul>
        <div class="tab-content">

            <?= $this->render('_sort_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
