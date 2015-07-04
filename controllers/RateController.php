<?php

namespace ts\comrate\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use ts\comrate\models\Rate;

/**
 * RateController implements the CRUD actions for Rate model.
 */
class RateController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new Rate model.
     *
     * @param $class
     * @param $modelId
     * @param $rating
     * @return int
     */
    public function actionCreateByCompany($class, $modelId, $rating)
    {
        if (Yii::$app->request->isAjax) {
            $model = Rate::create(urldecode($class), $modelId, $rating);
            return empty($model->errors) ? $model->rate_id : 0;
        }
    }
}
