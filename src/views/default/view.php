<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
?>

<div class="panel panel-warning passwd-view">
    <div class="panel-heading">
        <h3 class="panel-title text-center"><?=Html::encode($this->title)?></h3>
    </div>
    <div class="panel-body">
    <p class="text-right">
        <?= Html::a('首页', ['index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确认要删除？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'group',
            'title',
            'loginName',
            'passwd1',
            'url:url',
            'content',
            'creationTime',
            'updateTime',
        ],
    ]) ?>
    </div>
</div>
