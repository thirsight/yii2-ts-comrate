<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ts\comrate\models\Rate */

$this->title = Yii::t('rate', 'Update {modelClass}: ', [
    'modelClass' => 'Rate',
]) . ' ' . $model->rate_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rate', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rate_id, 'url' => ['view', 'id' => $model->rate_id]];
$this->params['breadcrumbs'][] = Yii::t('rate', 'Update');
?>
<div class="rate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
