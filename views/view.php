<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model ts\comrate\models\Rate */

$this->title = $model->rate_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rate', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-view">

    <p>
        <?= Html::a(Yii::t('rate', 'Update'), ['update', 'id' => $model->rate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('rate', 'Delete'), ['delete', 'id' => $model->rate_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('rate', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rate_id',
            'model_class',
            'model_pk',
            'user_id',
            'rate',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
