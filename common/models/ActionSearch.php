<?php

namespace kodi\common\models;

use kodi\common\models\user\Profile;
use kodi\common\models\user\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\validators\NumberValidator;
use yii\validators\SafeValidator;

/**
 * Class ActionSearch
 * ==================
 *
 */
class ActionSearch extends Action
{
    /**
     * @return mixed
     */
    public function attributes()
    {
        $attributes = [
            'user.profile.name',
        ];
        return array_merge(parent::attributes(), $attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id'], NumberValidator::class, 'integerOnly' => true],
            [['action_type', 'device_type', 'promo_code', 'status', 'user.profile.name'], SafeValidator::class],
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
        $query = Action::find()
            ->from(['action' => Action::tableName()])
            ->joinWith(['user' => function(ActiveQuery $query) {
                $query->from(['user' => User::tableName()])
                ->joinWith(['profile' => function(ActiveQuery $query) {
                    $query->from(['profile' => Profile::tableName()]);
                }]);
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['status' => SORT_DESC, 'action_type' => SORT_DESC]],
            //'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['user.profile.name'] = [
            'asc' => ['profile.name' => SORT_ASC],
            'desc' => ['profile.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'action.id' => $this->id,
            'action_type' => $this->action_type,
            'device_type' => $this->device_type,
            'device_id' => $this->device_id,
            'action.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'promo_code', $this->promo_code]);
        // filter by user's email
        if (!empty($this->getAttribute('user.profile.name'))) {
            $query->andWhere("profile.name LIKE '%{$this->getAttribute('user.profile.name')}%' OR profile.surname LIKE '%{$this->getAttribute('user.profile.name')}%' OR profile.user_id = '{$this->getAttribute('user.profile.name')}'");
        }

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