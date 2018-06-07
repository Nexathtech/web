<?php

namespace kodi\common\models\promocode\search;

use kodi\common\models\promocode\PromoCode as PromoCodeModel;
use kodi\common\models\SocialUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class PromoCodeSearch
 * =====================
 *
 */
class PromoCode extends PromoCodeModel
{
    /**
     * @return mixed
     */
    public function attributes()
    {
        $attributes = [
            'identity.name',
        ];
        return array_merge(parent::attributes(), $attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'code'], 'integer'],
            [['identity_id', 'description', 'status', 'type', 'expires_at', 'identity.name'], 'safe'],
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
        $query = PromoCode::find()
            ->from(['promoCode' => PromoCode::tableName()])
            ->joinWith(['identity' => function (ActiveQuery $query) {
                $query->from(['identity' => SocialUser::tableName()]);
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['identity.name'] = [
            'asc' => [SocialUser::tableName() . '.name' => SORT_ASC],
            'desc' => [SocialUser::tableName() . '.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'promoCode.id' => $this->id,
            'promoCode.status' => $this->status,
            'promoCode.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);
        // filter by identity's name
        if (!empty($this->identity_id)) {
            $query->andWhere('identity.name LIKE "%' . $this->getAttribute('identity.name') . '%"');
        }

        // filter by expires date range
        if (!empty($this->expires_at) && strpos($this->expires_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->expires_at);
            $sDate = date('Y-m-d H:i:s', strtotime($start_date));
            $eDate = date('Y-m-d H:i:s', strtotime($end_date));
            $query->andFilterWhere(['between', 'promoCode.expires_at', $sDate, $eDate]);
            $this->expires_at = $start_date . ' - ' . $end_date;
        }

        return $dataProvider;
    }
}