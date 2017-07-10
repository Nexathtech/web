<?php

namespace kodi\common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SocialUserSearch
 * ======================
 *
 */
class SocialUserSearch extends SocialUser
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['uuid'], 'integer'],
            [['name', 'gender', 'profile_url', 'type', 'created_at'], 'safe'],
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
        $query = SocialUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->type,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        // filter by created date range
        if (!empty($this->created_at) && strpos($this->created_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'created_at', $sDate, $eDate]);
            $this->created_at = $start_date . ' - ' . $end_date;
        }

        return $dataProvider;
    }
}