<?php
namespace backend\modules\platform\models;
use common\models\Common;
use Yii;

/**
 * This is the model class for table "admin_user_node".
 *
 * @property int $node_id 节点id
 * @property int $pid 节点父id
 * @property string $name 菜单名称
 * @property string $module 模块
 * @property string $url 权限路径
 * @property string $remark 备注
 * @property int $status 状态：0为禁用,1为正常
 * @property int $sort 排序
 * @property int $is_menu 是否作为菜单显示 1：是
 * @property string $menu_url 菜单url
 * @property string $icon 菜单图标
 * @property int $is_api 是否为接口(0:否 1:是)
 * @property int $is_need_validation_rule 是否需要验证规则(0:否 1:是)
 */
class Node extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user_node';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'sort'], 'integer'],
            [['status', 'name', 'sort', 'url', 'is_menu','pid' ], 'required'],
            [['name', 'remark'], 'string', 'max' => 50],
            [['module'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
            [['status', 'is_menu', 'is_api', 'is_need_validation_rule'], 'string', 'max' => 1],
            [['icon','create_time'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_id' => '节点id',
            'pid' => '节点父id',
            'name' => '菜单名称',
            'module' => '模块',
            'url' => '权限路径',
            'remark' => '备注',
            'status' => '状态',
            'sort' => '排序',
            'icon' => '菜单图标',
            'is_menu' => '是否作为菜单显示',
            'is_api' => '是否为接口',
            'is_need_validation_rule' => '是否需要验证规则',
            'create_time' => '创建时间'
        ];
    }
    /**
     * 获取父节点 名称
     * @return array
     */
   public static function getAllNodeName() {
       $nodeRoles = Node::find()->where(['status' => 1])->orderBy('sort DESC')->asArray()->all();
       $levellist = \common\models\Common::list_to_levellist($nodeRoles, 'node_id', 'name', 'pid');
       $list = ['无'] + $levellist;
        return $list;
    }
}
