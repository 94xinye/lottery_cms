<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ad */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => \app\models\Ad::$types[$model->type], 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adx-create">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><?= Html::a(\app\models\Ad::$types[$model->type].'管理', ['index','type'=>$model->type]) ?></li>
            <li role="presentation" class="active"><?= Html::a('添加'.\app\models\Ad::$types[$model->type], ['create','type'=>$model->type]) ?></li>
        </ul>
        <div class="tab-content">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
