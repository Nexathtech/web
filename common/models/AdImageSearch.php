<?php

namespace kodi\common\models;

use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class AdImageSearch
 * ===================
 *
 * Page represents the model behind the search form about `kodi\common\models\AdImage`.
 */
class AdImageSearch extends AdImage
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
            [['status', 'type', 'location_latitude', 'location_longitude', 'created_at', 'user.email'], 'safe'],
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
        $query = AdImage::find()->joinWith(['user user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user.email'] = [
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ad_image.id' => $this->id,
            //'user_id' => $this->user_id,
            'ad_image.status' => $this->status,
            'ad_image.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'location_latitude', $this->location_latitude])
            ->andFilterWhere(['like', 'location_longitude', $this->location_longitude]);

        // filter by user's email
        $query->andWhere('user.email LIKE "%' . $this->getAttribute('user.email') . '%"');

        // filter by created date range
        if (!empty($this->created_at) && strpos($this->created_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'ad_image.created_at', $sDate, $eDate]);
            $this->created_at = $start_date . ' - ' . $end_date;
        }

        return $dataProvider;
    }
}
