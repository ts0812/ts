<?php 
namespace backend\models;

use Yii;
use common\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%node}}".
 *
 * @property int $node_id 节点id
 * @property int $pid 节点父id
 * @property string $name 菜单名称
 * @property string $module 模块
 * @property string $url 权限路径
 * @property string $remark 备注
 * @property int $status 状态：0为禁用,1为正常
 * @property string $code 编码
 * @property int $categoty 后台权限
 * @property string $relation 关联菜单(json)
 * @property string $sort 排序
 * @property int $is_relation_node 是否关联节点 1：是 0：否
 * @property int $is_menu 是否作为菜单显示 1：是
 * @property string $menu_url 菜单url
 * @property string $icon 菜单图标
 * @property int $is_api 是否为接口(0:否 1:是)
 * @property int $is_need_validation_rule 是否需要验证规则(0:否 1:是)
 * @SuppressWarnings(PHPMD)
 */
class Node extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'admin_user_node';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['pid', 'status', 'categoty', 'sort', 'is_relation_node', 'is_menu', 'is_api', 'is_need_validation_rule'], 'integer', 'message' => ''],
                [['status'], 'required'],
                [['relation'], 'string'],
                [['name', 'remark'], 'string', 'max' => 50],
                [['module'], 'string', 'max' => 20],
                [['url', 'menu_url'], 'string', 'max' => 255],
                [['code', 'icon'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'node_id' => '节点id',
            'pid' => '节点父id',
            'name' => '菜单名称',
            'module' => '模块',
            'url' => '权限路径',
            'remark' => '备注',
            'status' => '状态',
            'code' => '编码',
            'categoty' => '后台权限',
            'relation' => '关联菜单',
            'sort' => '排序',
            'is_relation_node' => '是否关联节点',
            'is_menu' => '是否为菜单',
            'menu_url' => '菜单url',
            'icon' => '菜单图标',
            'is_api' => '是否为接口(0:否 1:是)',
            'is_need_validation_rule' => '是否需要验证规则(0:否 1:是)',
        ];
    }

    /**
     * 获取父节点 名称
     * @return array
     */
    public static function getAllNodeName() {
        $nodeRoles = Node::find()->where(['status' => 1])->orderBy('sort DESC')->asArray()->all();
        $levellist = ArrayHelper::list_to_levellist($nodeRoles, 'node_id', 'name', 'pid');
        $list = ['无'] + $levellist;
        return $list;
    }

    /**
     * 获取所有节点 菜单和url
     * @param int $userId 用户id
     * @param int $roleId 角色id
     * @return array
     */
    public static function getNodeMenu($userId,$roleId) {
    	
        $menus = [];
        $authUrl = []; 
        //用户id为1的是 超级管理员
        if ($userId == 1 || $roleId == 1) {
            $nodeRoles = Node::find()->where(['status' => 1])->orderBy('sort DESC')->asArray()->all();
        } else {
            $nodeRoles = (new \yii\db\Query())
                    ->select('*')
                    ->from('admin_user_node_role AS r')
                    ->leftJoin('admin_user_node AS n', 'r.node_id = n.node_id')
                    ->where(['n.status' => 1, 'r.role_id' => $roleId])
                    ->orderBy('n.sort DESC')
                    ->All();
        }
        foreach ($nodeRoles as $row) {
            $node = $row;
            $authUrl[] = $node['url'] ? $node['url'] : '#';
            if ($node['is_menu'] == 1)
                $menus[] = ['pid' => $node['pid'], 'node_id' => $node['node_id'], 'label' => $node['name'], 'url' => ['/' . $node['url']], 'icon' => $node['icon']];
        }
        $tree = ArrayHelper::listToTree($menus, 'node_id', 'pid', 'items');

        return [$tree, $authUrl];
    }

    /**
     * 所有权限
     * @return array mixed
     */
    public static function getAllNode() {
        $data = Node::find()->where(['status' => 1])->orderBy('sort DESC')->asArray()->all();
        $list = ArrayHelper::listToTree($data, 'node_id', 'pid', 'z');
        return $list;
    }

    /**
     * 设置子集节点状态
     * @param int $nodeId 节点id
     * @return bool
     */
    public static function setChildNodeStatus(int $nodeId, int $status) {
        if ($status !== 0)
            return false;
        $nodes = Node::find()->where(['pid' => $nodeId])->all();
        if ($nodes) {
            Yii::$app->db->createCommand()->update(self::tableName(), ['status' => $status], "pid=:pid", [':pid' => $nodeId])->execute();
            foreach ($nodes as $node) {
                $child = Node::find()->where(['pid' => $node->node_id])->all();
                if ($child)
                    Yii::$app->db->createCommand()->update(self::tableName(), ['status' => $status], "pid=:pid", [':pid' => $node->node_id])->execute();
            }
        }
        return true;
    }

    public static function getOneNode($pid) {
        return Node::findOne($pid);
    }

    //是否关联节点
    public static function getIsRelationNode() {
        return ['0' => '否', '1' => '是'];
    }

    //是否为菜单
    public static function getIsMenu() {
        return ['0' => '否', '1' => '是'];
    }

    //状态
    public static function getStatus() {
        return ['0' => '禁用', '1' => '正常'];
    }

    //是否为api
    public static function getIsApi() {
        return ['0' => '否', '1' => '是'];
    }
}
