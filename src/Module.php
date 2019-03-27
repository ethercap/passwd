<?php

namespace ethercap\passwd;

use yii\web\ForbiddenHttpException;
use Yii;
use yii\di\Instance;
use yii\db\Connection;

/**
 * passwd module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ethercap\passwd\controllers';
    // 数据库
    public $db = 'db';
    // passwd salt
    public $salt = '';

    public $allowUserIds = [];

    public $encodePasswd;

    public $decodePasswd;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->salt)) {
            throw new InvalidConfigException('密码不加盐，一生黑！');
        }

        if (empty($this->encodePasswd)) {
            $this->encodePasswd = function ($passwd, $key, $salt) {
                $encodeKey = sha1($salt.$key.$salt);
                return base64_encode(Yii::$app->security->encryptByPassword($passwd, $encodeKey));
            };
        }

        if (empty($this->decodePasswd)) {
            $this->decodePasswd = function ($encrypt, $key, $salt) {
                $encodeKey = sha1($salt.$key.$salt);
                return Yii::$app->security->decryptByPassword(base64_decode($encrypt), $encodeKey);
            };
        }

        if (is_object($this->allowUserIds) && $this->allowUserIds instanceof \Closure) {
            $this->allowUserIds = call_user_func($this->allowUserIds, $this);
        }
        if (!is_array($this->allowUserIds)) {
            $this->allowUserIds = [$this->allowUserIds];
        }
        $this->db = Instance::ensure($this->db, Connection::class);

        $user = Yii::$app->user->identity;
        if (!$user) {
            Yii::$app->user->loginRequired();
            return parent::init();
        }
        if (!in_array($user->id, $this->allowUserIds)) {
            throw new ForbiddenHttpException('你没有权限访问当前页面');
        }
        parent::init();
    }
}
