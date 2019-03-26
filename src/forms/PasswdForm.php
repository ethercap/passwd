<?php

namespace ethercap\passwd\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ethercap\passwd\models\Passwd;

/**
 * PasswdForm represents the model behind the search form about `common\models\Passwd`.
 */
class PasswdForm extends Passwd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['group', 'title', 'loginName', 'passwd', 'url', 'content', 'creationTime', 'updateTime'], 'safe'],
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
        $query = Passwd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'creationTime' => $this->creationTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'loginName', $this->loginName])
            ->andFilterWhere(['like', 'passwd', $this->passwd])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
