<?php

namespace backend\modules\platform\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\platform\models\Node;

/**
 * NodeSearch represents the model behind the search form of `backend\modules\platform\models\Node`.
 */
class NodeSearch extends Node
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_id', 'pid', 'sort'], 'integer'],
            [['name', 'module', 'url', 'remark', 'status', 'is_menu', 'icon', 'is_api', 'is_need_validation_rule','create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Node::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'node_id' => $this->node_id,
            'pid' => $this->pid,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'is_menu', $this->is_menu])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'is_api', $this->is_api])
            ->andFilterWhere(['like', 'is_need_validation_rule', $this->is_need_validation_rule]);

        return $dataProvider;
    }
}
