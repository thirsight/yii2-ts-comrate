<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model ts\comrate\models\Rate */

$this->title = Yii::t('rate', 'Create Rate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rate', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
