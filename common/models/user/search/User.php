<?php

namespace kodi\common\models\user\search;

use kodi\common\models\user\Profile;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kodi\common\models\user\User as UserModel;
use yii\db\ActiveQuery;

/**
 * Class User
 * ==========
 *
 * @package kodi\common\models\user\search
 */
class User extends UserModel
{
    /**
     * @return mixed
     */
    public function attributes()
    {
        $attributes = [
            'profile.name',
            'photo',
            'subscription',
        ];
        return array_merge(parent::attributes(), $attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['role', 'type', 'email', 'created_at', 'updated_at', 'profile.name', 'status'], 'safe'],
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
        $query = UserModel::find()
            ->from(['user' => UserModel::tableName()])
            ->joinWith(['profile' => function (ActiveQuery $query) {
                $query->from(['profile' => Profile::tableName()]);
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['profile.name'] = [
            'asc' => [Profile::tableName() . '.name' => SORT_ASC],
            'desc' => [Profile::tableName() . '.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'role' => $this->role,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        // filter by person full name
        $query->andWhere('profile.name LIKE "%' . $this->getAttribute('profile.name') . '%"');

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