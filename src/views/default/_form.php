<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

?>

<div class=" panel panel-info passwd-form">
    <div class="panel-heading">
        <h3 class="panel-title text-center"><?=Html::encode($this->title)?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
        ]); ?>

        <?= $form->field($model, 'group')->dropDownList($model::$groupList, ['maxlength' => true]) ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'loginName')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'passwd1', [
            'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon" id="togglePasswd">显示</span></div>',
        ])->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'passwd2', [
            'inputTemplate' => '<div class="input-group">{input}<a type="button" class="input-group-addon btn btn-primary" data-toggle="modal" data-target="#passwdModal">生成</a></div>',
        ])->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
Modal::begin([
    'header' => '<h3>密码生成</h3>',
    'id' => 'passwdModal',
    'footer' => Html::button('重新生成', ['class' => 'btn btn-default', 'id' => 'refreshBtn']).Html::button('确定', ['class' => 'btn btn-success', 'id' => 'applyBtn']),
]); ?>
<form class="form-horizontal" id="genPasswdForm">
    <div class="form-group">
        <label class="control-label col-md-2" style="padding-top:7px;text-align:right;">密码</label>
        <div class="col-md-9">
            <input name="passwdStr" value="" class="form-control" id="passwdStr" /> 
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" style="padding-top:7px;text-align:right;">位数</label>
        <div class="col-md-9">
            <input name="number" value="16" class="form-control" /> 
        </div>
    </div>
    <div class="form-group" style="padding-top:10px;">
        <label class="control-label col-md-2" style="padding-top:7px;text-align:right;">选项</label>
        <div class="col-md-9">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input name="types" type="checkbox" value="0"> a-z
                </label>
                <label class="btn btn-default active">
                    <input name="types" type="checkbox" value="1"> A-Z
                </label>
                <label class="btn btn-default active">
                    <input name="types" type="checkbox" value="2"> 数字
                </label>
                <label class="btn btn-default active">
                    <input name="types" type="checkbox" value="3"> 标点
                </label>
            </div>
        </div>
    </div>
</form>
<?php 
Modal::end();
$js = '
$("#passwdModal").on("show.bs.modal", function (e) {
    generate();
});
$("#genPasswdForm input[name=number]").on("change", function(){
    generate();
});
$("label.btn").on("click",function(){
    var isActive = $(this).hasClass("active");
    if(isActive) {
        $(this).removeClass("active");
    } else {
        $(this).addClass("active");
    }
    generate();
    return false;
});
$("#refreshBtn").on("click", function(){
    generate();
});
$("#applyBtn").on("click", function(){
    var str = $("#passwdStr").val();
    $("#passwd-passwd1").val(str);
    $("#passwd-passwd2").val(str);
    $("#passwdModal").modal("hide");
});

function generate()
{
    var length = parseInt($("#genPasswdForm input[name=number]").val());
    config = {
        "length" : length,
        "types" : [],
    };
    $("label.active.btn input").each(function(index, e){
        config["types"].push(parseInt($(e).val()));
    });
    var str = genPasswd(config);
    $("#passwdStr").val(str);
}
//生成密码
function genPasswd(config)
{
    var datas = [
        ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"],
        ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"],
        [0,1,2,3,4,5,6,7,8,9],
        ["!","@","#","$","%","^","&","*","(",")"],
    ];
    var arr = [];
    if(config.types.length == 0) {
        return "";
    }
    for(i=0; i<config.types.length; i++) {
        index = config.types[i];
        arr = arr.concat(datas[index])
    } 
    str = "";
    for(i=0; i<config.length; i++) {
        pos = Math.round(Math.random() * (arr.length-1));
        str += arr[pos];
    }
    return str;
}
$("#togglePasswd").on("click", function(){
    var type = $("#passwd-passwd1").attr("type");
    var text;
    if(type == "password") {
        type = "input";
        text = "隐藏";
    }else {
        type = "password";
        text = "显示";
    }
    $("#passwd-passwd1").attr("type", type);
    $("#passwd-passwd2").attr("type", type);
    $(this).text(text);
});    
';
$this->registerJs($js);
