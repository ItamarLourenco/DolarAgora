<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dolar */

$this->title = 'Create Dolar';
$this->params['breadcrumbs'][] = ['label' => 'Dolars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dolar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
