<?php

namespace backend\modules\platform\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Role;

/**
 * RoleSearch represents the model behind the search form of `backend\models\Role`.
 */
class RoleSearch extends Role
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            [['role_name', 'functional_description', 'role_status', 'role_remark', 'addtime', 'edittime'], 'safe'],
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
        $query = Role::find();

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
            'role_id' => $this->role_id,
            'addtime' => $this->addtime,
            'edittime' => $this->edittime,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name])
            ->andFilterWhere(['like', 'functional_description', $this->functional_description])
            ->andFilterWhere(['like', 'role_status', $this->role_status])
            ->andFilterWhere(['like', 'role_remark', $this->role_remark]);

        return $dataProvider;
    }
}
