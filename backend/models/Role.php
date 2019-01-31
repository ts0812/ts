<?php

namespace backend\models;

use Yii;
use common\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $role_id 角色id
 * @property string $role_name 角色名称
 * @property int $role_code 角色编号
 * @property string $functional_description 职能描述
 * @property int $role_status 状态:0为禁用,1为正常,99删除
 * @property string $role_remark 备注
 * @property int $addtime 添加时间
 * @property int $edittime 修改时间
 */
class Role extends \yii\db\ActiveRecord {

    /**
     * 0 => '禁止',
     * 1 => '正常',
     * 2 => '删除',
     */
    const STATUS_NOTPASS = 0;
    const STATUS_AUDITING = 1;
    const STATUS_PASSED = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'admin_user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['role_name',], 'required', 'message' => ''],
                [['role_status'], 'integer'],
                [['role_name'], 'string', 'max' => 20],
                [['functional_description'], 'string', 'max' => 150],
                [['role_remark'], 'string', 'max' => 255],
                [['role_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'role_id' => '角色id',
            'role_name' => '角色名称',
            'functional_description' => '职能描述',
            'role_status' => '状态',
            'role_remark' => '备注',
            'addtime' => '添加时间',
            'edittime' => '修改时间',
        ];
    }

    //获取状态值
    public static function getStatusName($type = null) {
        $data = [
            self::STATUS_NOTPASS => '禁止',
            self::STATUS_AUDITING => '正常',
            self::STATUS_PASSED => '删除',
        ];
        return is_null($type) ? $data : $data[$type];
    }

    //查询角色信息
    public static function getAllRoleName($rid = 1) {
        $userSalt = ArrayHelper::map(Role::findAll(['role_id' => $rid]), 'role_id', 'role_name');
        return $userSalt[$rid];
    }
    //查询所有有效角色
    public static function getAllRole(){
        $rolelists=self::findAll(['role_status'=>1]);
        return $rolelists?ArrayHelper::map($rolelists,'role_id','role_name'):[];
    }
    /**
     * 修改权限
     * @param int $roleId 角色id
     * @param array $nowAuthIds 新的权限id 集合
     * @param array $authIds 旧的权限id 集合
     */
    public static function updateAuth(int $roleId, array $nowAuthIds, array $authIds)
    {
        //要添加的权限
        $add = array_diff($nowAuthIds, $authIds);
        //要取消的权限
        $delete = array_diff($authIds, $nowAuthIds);
        //添加权限 插入数据
        $model = new \backend\models\NodeRole;
        if ($add) {
            foreach ($add as $nodeId) {
                $model->isNewRecord = true;
                $model->setAttributes(['role_id' => (int)$roleId, 'node_id' => $nodeId]);
                $model->save();
            }
        }
        //取消权限 删除数据
        if ($delete) {
            foreach ($delete as $nodeId) {
                Yii::$app->db->createCommand()->delete($model::tableName(), ['node_id' => $nodeId, 'role_id' => (int)$roleId])->execute();
            }
        }
    }
}
