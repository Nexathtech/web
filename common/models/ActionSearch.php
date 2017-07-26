<?php

namespace kodi\common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ActionSearch
 * ==================
 *
 */
class ActionSearch extends Action
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['initiator_id', 'initiator', 'type', 'created_at', 'data', 'promo_code'], 'safe'],
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
        $query = Action::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'initiator' => $this->initiator,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'initiator_id', $this->initiator_id]);
        $query->andFilterWhere(['like', 'promo_code', $this->promo_code]);

        // filter by expires date range
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