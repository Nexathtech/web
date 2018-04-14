<?php

namespace kodi\common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\validators\NumberValidator;
use yii\validators\SafeValidator;

/**
 * Class OrderSearch
 * =================
 *
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id'], NumberValidator::class, 'integerOnly' => true],
            [['type', 'name', 'surname', 'email', 'company', 'country', 'total', 'payment_type', 'status'], SafeValidator::class],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['status' => SORT_ASC]],
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
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'company', $this->company]);
        $query->andFilterWhere(['like', 'country', $this->country]);
        $query->andFilterWhere(['like', 'total', $this->total]);
        // filter by user's email
        $query->andWhere('name LIKE "%' . $this->getAttribute('name') . '%" OR surname LIKE "%' . $this->getAttribute('name') . '%"');

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