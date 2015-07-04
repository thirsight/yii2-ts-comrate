<?php

namespace ts\comrate\models;

use Yii;
use yii\console\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rate".
 *
 * @property integer $rate_id
 * @property string $model_class
 * @property integer $model_pk
 * @property integer $user_id
 * @property string $rate
 * @property integer $created_at
 * @property integer $updated_at
 */
class Rate extends ActiveRecord
{
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_class', 'model_pk', 'user_id', 'rating'], 'trim'],
            [['model_class', 'model_pk', 'user_id', 'rating'], 'required'],
            [['model_pk', 'user_id'], 'integer'],
            [['rating'], 'number'],
            [['model_class'], 'string', 'max' => 128],
            [['model_pk', 'user_id'], 'unique', 'targetAttribute' => ['model_class', 'model_pk', 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate_id' => Yii::t('rate', 'Rate ID'),
            'model_class' => Yii::t('rate', 'Rate Model'),
            'model_pk' => Yii::t('rate', 'Rate Model Pk'),
            'user_id' => Yii::t('rate', 'User ID'),
            'rating' => Yii::t('rate', 'Rate'),
            'created_at' => Yii::t('rate', 'Created At'),
            'updated_at' => Yii::t('rate', 'Updated At'),
        ];
    }

    /**
     * Create rate
     *
     * @param $rateModelClass
     * @param $rateModelId
     * @param $rating
     * @return string|Rate
     */
    public static function create($rateModelClass, $rateModelId, $rating)
    {
        $rate = new self();
        $rate->model_class = $rateModelClass;
        $rate->model_pk = $rateModelId;
        $rate->user_id = Yii::$app->getUser()->id;
        $rate->rating = $rating;
        $rate->save();

        return $rate;
    }

    /**
     * 统计平均值
     *
     * @param $rates
     * @return float|int
     */
    public static function statsRatingAvg($rates)
    {
        if ($rates && is_array($rates)) {
            $rates = ArrayHelper::getColumn($rates, 'rating');
            $count = count($rates);
            $sum   = array_sum($rates);

            return round($sum / $count, 1);
        }
        return 0;
    }

    public static function isUserRated($rates, $userId)
    {
        if ($rates && is_array($rates) && $userId) {
            $rates = ArrayHelper::getColumn($rates, 'user_id');

            return array_search($userId, $rates) !== false;
        }
        return false;
    }

    /**
     * Get total rating by model
     *
     * @param \yii\db\ActiveRecord $model
     * @return int|mixed
     */
    public static function getTotalRating(ActiveRecord $model)
    {
        try {
            // Get all rates by model and model_id
            $rates = self::find()
                ->where(['model_class' => $model::className()])
                ->andWhere(['model_id' => $model->id])
                ->asArray()
                ->all();

            // Counting total rating
            $totalRating = 0;
            if(count($rates) !== 0) {
                foreach ($rates as $rate) {
                    $totalRating += $rate['rate'];
                }
                $totalRating /= count($rates);
            }

            return $totalRating;

        } catch (Exception $e) {
            Yii::error($e->getMessage(), self::className() . '->getTotalRating()');
            return 0;
        }
    }

    /**
     * Get rating by model source
     *
     * @param \yii\db\ActiveRecord $model
     * @return int|mixed
     */
    public static function getRatingByModel($model)
    {
        try {

            if(!$model || !($model instanceof ActiveRecord)) throw new Exception('Variable model is not correct!');

            // Get rating by model and model_id
            $rating = self::find()
                ->where(['model_source' => $model::className()])
                ->andWhere(['model_source_id' => $model->id])
                ->asArray()
                ->one();

            return $rating ? $rating['rate'] : 0;

        } catch (Exception $e) {
            Yii::error($e->getMessage(), self::className() . '->getRatingByModel()');
            return 0;
        }
    }
}
