<?php

$this->title = '新建密码';
$this->params['breadcrumbs'][] = ['label' => '密码列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="passwd-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
