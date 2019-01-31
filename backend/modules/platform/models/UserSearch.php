<?php

namespace backend\modules\platform\models;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `app\models\user`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name','username', 'create_time', 'status','phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $tablename = self::tableName();
        $query = user::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => PAGE_SIZE],//一页多少行
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],//默认排序
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $tablename.'.status' => $this->status,
            $tablename.'.phone' => $this->phone,
        ]);

        $query->andFilterWhere(['like',  $tablename.'.name', $this->name])
            ->andFilterWhere(['like',  $tablename.'.username', $this->username]);
        return $dataProvider;
    }
}
