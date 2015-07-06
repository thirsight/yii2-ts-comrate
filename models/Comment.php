<?php

namespace ts\comrate\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $comm_id
 * @property integer $comm_parent
 * @property string $comm_content
 * @property string $comm_status
 * @property string $comm_ip
 * @property string $comm_agent
 * @property integer $user_id
 * @property string $model_table
 * @property string $model_pk
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comment extends \ts\base\BaseModel
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_PENDING   = 'pending';
    const STATUS_DRAFT     = 'draft';
    const STATUS_TRASH     = 'trash';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comm_content', 'model_table', 'model_pk'], 'trim'],
            [['comm_content', 'model_table', 'model_pk'], 'required'],
            [['comm_parent', 'user_id'], 'integer'],
            [['comm_parent'], 'default', 'value' => 0],

            [['comm_content'], 'string'],
            [['comm_content'], 'filter', 'filter' => '\ts\base\Filter::mergeBlank'],

            [['comm_status'], 'default', 'value' => self::STATUS_PUBLISHED],
            [['comm_status'], 'in', 'range' => [self::STATUS_PUBLISHED, self::STATUS_PENDING, self::STATUS_DRAFT, self::STATUS_TRASH]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comm_id' => Yii::t('ts', 'Comm ID'),
            'comm_parent' => Yii::t('ts', 'Comm Parent'),
            'comm_content' => Yii::t('ts', 'Comm Content'),
            'comm_status' => Yii::t('ts', 'Comm Status'),
            'comm_ip' => Yii::t('ts', 'Comm Ip'),
            'comm_agent' => Yii::t('ts', 'Comm Agent'),
            'user_id' => Yii::t('ts', 'User ID'),
            'model_table' => Yii::t('ts', 'Model Table'),
            'model_pk' => Yii::t('ts', 'Model Pk'),
            'created_at' => Yii::t('ts', 'Created At'),
            'updated_at' => Yii::t('ts', 'Updated At'),
        ];
    }

    /**
     * @param $modelTable
     * @param $modelPk
     * @param $content
     * @return Comment
     */
    public static function create($modelTable, $modelPk, $content)
    {
        $model = new self();
        $model->comm_ip    = Yii::$app->request->userIP;
        $model->comm_agent = Yii::$app->request->userAgent;
        $model->user_id    = Yii::$app->user->id;
        $model->comm_content = $content;
        $model->model_table  = $modelTable;
        $model->model_pk     = $modelPk;
        $model->save();

        return $model;
    }
}
