<?php

namespace ethercap\passwd\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * 该model对应数据库表 "passwd".
 *
* @property integer $id 
* @property string $group 分类
* @property string $title 标题
* @property string $loginName 登录名
* @property string $passwd 密码
* @property string $url 网址
* @property string $content 备注
* @property string $creationTime 
* @property string $updateTime 
 */
class Passwd extends \yii\db\ActiveRecord
{

    public $_passwd1;
    public $_passwd2;

    public static $groupList = [
        '服务器' => '服务器',
        '数据库' => '数据库',
        '网站' => '网站',
        '默认分组' => '默认分组'
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'passwd';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->controller->module->db;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'group', 'loginName', 'passwd1', 'passwd2'], 'required'],
            [['group', 'title', 'loginName'], 'string', 'max' => 32],
            [['passwd1', 'passwd2', 'url'], 'string', 'max' => 128],
            ['url', 'url'],
            ['group', 'default', 'value' => '默认分组'],
            ['passwd2', 'checkPasswd'],
            [['content'], 'string', 'max' => 1024],
            [['creationTime', 'updateTime'], 'safe'],
        ];
    }

    public function checkPasswd($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->passwd1 != $this->passwd2) {
                $this->addError($attribute, "两次密码不相等");
            }
        }
    }

    public function getPasswd1()
    {
        if($this->_passwd1) {
            return $this->_passwd1;
        }
        if(empty($this->passwd)) {
            $this->_passwd1 = "";
            return $this->_passwd1;
        }
        $module = Yii::$app->controller->module;
        $this->passwd1 = call_user_func($module->decodePasswd, $this->passwd, $this->key, $module->salt);
        return $this->_passwd1;
    }

    public function setPasswd1($passwd1)
    {
        $this->_passwd1 = $passwd1;
    }

    public function getPasswd2()
    {
        if($this->_passwd2) {
            return $this->_passwd2;
        }
        $this->_passwd2 = $this->_passwd1;
        return $this->_passwd2;
    }

    public function setPasswd2($passwd2)
    {
        $this->_passwd2 = $passwd2;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => '分类',
            'title' => '标题',
            'loginName' => '登录名',
            'passwd' => '密码',
            'passwd1' => '密码',
            'passwd2' => '确认密码',
            'url' => '网址',
            'content' => '备注',
            'creationTime' => '创建时间',
            'updateTime' => '修改时间',
        ];
    }

    public function beforeSave($insert)
    {
        if(empty($this->key)) {
            $this->key = Yii::$app->security->generateRandomString(20);
        }
        if($this->_passwd1) {
            $module = Yii::$app->controller->module;
            $this->passwd = call_user_func($module->encodePasswd, $this->_passwd1, $this->key, $module->salt);
        }
        return parent::beforeSave($insert);
    }


    public function behaviors()
    {
        return [
            [
                'class' => \lspbupt\common\behaviors\DateTimeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creationTime','updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime'],
                ],
            ],
        ];
    }

}
