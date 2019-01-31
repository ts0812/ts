<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password_hash 密码

 * @property string $email 邮箱
 * @property string $auth_key 登陆令牌
 * @property int $status 状态
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property string $password 密码
 */
class User extends \yii\db\ActiveRecord
{   
    public $passwd;
    public static $_status = [
        '禁用',
        '正常',
        99 => '删除'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'role_id'], 'integer'],
            [['username', 'password','name'], 'string'],
            [['password_hash'], 'string', 'max' => 80],
            [[ 'email', 'auth_key'], 'string', 'max' => 60],
            [['username'], 'unique'],
            [['email'],'email'],
            [['username','password','email','passwd'],'required'],
            [['passwd'],'filterPassword'],
            ['username', 'unique'],
            [['phone'],'match','pattern'=>'/^[1][3578][0-9]{9}$/'],
            [['login_ip', 'last_login_ip'], 'string', 'max' => 20],
            [['last_login_time', 'login_time', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id'=>'角色',
            'username' => '账号',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'auth_key' => 'Auth Key',
            'status' => '状态',
            'phone'=>'手机',
            'create_time' => '创建时间',
            'update_time' => 'update_time',
            'password' => 'Password',
            'passwd' => '密码',
            'name'=>'名字',
            'last_login_time'=>'上次登录时间',
            'last_login_ip'=>'上次登录ip',
        ];
    }
    public function filterPassword(){
           
         if(!preg_match("/^[0-9_a-zA-Z]{6,16}$/",$this -> passwd))
          {
            
            $this->addError('passwd', "只能输入6-16位数字和字母");
          }

    }

    public function setPassword($password) {
        $this->password_hash = \Yii::$app->security->generateRandomString();
        $this->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password_hash . $password);

    }
    /**
     * 联表role
     */
    public function getRole()
    {
        return $this->hasOne(\backend\models\Role::className(), ['id' => 'role_id']);
    }
}
