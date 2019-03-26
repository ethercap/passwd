<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = '密码列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="passwd-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a('新建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <div class="panel panel-default passwd-list">
        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'group',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, $model->url, ['target' => '_blank']);
                },
            ],
            'loginName',
            'updateTime',
            [
                'class' => 'kartik\grid\ActionColumn',
                'width' => '25%',
                'template' => '<div class="btn-group">
                    {copy}{view}{update}{delete}
                </div>',
                'header' => '操作',
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        return Html::button('复制密码', [
                            'class' => 'btn btn-primary copyBtn',
                            'data-item' => $model->passwd1,
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('查看', ['view', 'id' => $model->id], [
                            'class' => 'btn btn-success',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('修改', $url, [
                            'class' => 'btn btn-warning',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '你确定要删除吗？',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>

<?php
$js = 'function clipCopy(text) {
    if(!text) {
        return;
    }
    const input = document.createElement("input");
    input.setAttribute("value", text);
    document.body.appendChild(input);
    input.select();
    document.execCommand("copy");
    document.body.removeChild(input);
}
$(".copyBtn").on("click", function(){
    var passwd = $(this).attr("data-item");
    clipCopy(passwd);
});';
$this->registerJs($js);
