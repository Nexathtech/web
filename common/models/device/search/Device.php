<?php

namespace kodi\common\models\device\search;

use kodi\common\models\user\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kodi\common\models\device\Device as DeviceModel;
use yii\db\ActiveQuery;

/**
 * Class User
 * ==========
 *
 * @package kodi\common\models\device\search
 */
class Device extends DeviceModel
{
    /**
     * @return mixed
     */
    public function attributes()
    {
        $attributes = [
            'user.email',
        ];
        return array_merge(parent::attributes(), $attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['name', 'status', 'location_latitude', 'location_longitude', 'created_at', 'updated_at', 'user.email'], 'safe'],
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
        $query = DeviceModel::find()
            ->from(['device' => DeviceModel::tableName()])
            ->joinWith(['user' => function (ActiveQuery $query) {
                $query->from(['user' => User::tableName()]);
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['user.email'] = [
            'asc' => [User::tableName() . '.email' => SORT_ASC],
            'desc' => [User::tableName() . '.email' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'device.id' => $this->id,
            'device.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        // filter by user's email
        $query->andWhere('user.email LIKE "%' . $this->getAttribute('user.email') . '%"');

        // filter by created date range
        if (!empty($this->created_at) && strpos($this->created_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'device.created_at', $sDate, $eDate]);
            $this->created_at = $start_date . ' - ' . $end_date;
        }

        return $dataProvider;
    }
}