<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin_user_node_role".
 *
 * @property int $node_id 节点id
 * @property int $role_id 角色id
 */
class NodeRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_user_node_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['node_id', 'role_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'node_id' => 'Node ID',
            'role_id' => 'Role ID',
        ];
    }
    
    public function getNodes()
    {
        return $this->hasOne(\backend\models\Node::className(), ['node_id' => 'node_id']);
    }
}
