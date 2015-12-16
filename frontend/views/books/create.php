<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Books */

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authorsList' => $authorsList,
        'referrer' => $referrer,
    ]) ?>

</div>