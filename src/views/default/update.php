<?php


$this->title = '修改密码: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '密码列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '查看'.$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="passwd-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
