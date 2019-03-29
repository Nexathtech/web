<?php

namespace kodi\common\models\event\search;

use kodi\common\models\user\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kodi\common\models\event\Event as EventModel;
use yii\db\ActiveQuery;

/**
 * Class Event
 * ===========
 *
 * @package kodi\common\models\event\search
 */
class Event extends EventModel
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['title', 'status', 'location_latitude', 'location_longitude', 'location_radius', 'users_max_prints_amount', 'starts_at', 'ends_at', 'created_at', 'updated_at'], 'safe'],
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
        $query = EventModel::find()->from(['event' => EventModel::tableName()]);

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
            'event.id' => $this->id,
            'event.status' => $this->status,
            'event.users_max_prints_amount' => $this->users_max_prints_amount,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        // filter by starts_at date range
        if (!empty($this->starts_at) && strpos($this->starts_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->starts_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'event.starts_at', $sDate, $eDate]);
            $this->starts_at = $start_date . ' - ' . $end_date;
        }

        // filter by ends_at date range
        if (!empty($this->ends_at) && strpos($this->ends_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->ends_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'event.ends_at', $sDate, $eDate]);
            $this->ends_at = $start_date . ' - ' . $end_date;
        }

        return $dataProvider;
    }
}
