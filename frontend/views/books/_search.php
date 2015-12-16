<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BooksSearch */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="books-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-12 col-md-3">
    <?= $form->field($model, 'author_id')->dropDownList($authorsList, ['prompt'=>''])->label(false) ?>
        </div>
        <div class="col-sm-12 col-md-3">
    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-2">
            Дата выхода книги
        </div>
        <div class="col-sm-6 col-md-2">
    <?= $form->field($model, 'date_from')->textInput(['placeholder'=>'01.01.2014'])->label(false); ?>
        </div>
        <div class="col-sm-6 col-md-2">
    <?= $form->field($model, 'date_to')->textInput(['placeholder'=>'31.12.2015'])->label(false); ?>
        </div>
        <div class="col-sm-12 col-md-6 text-right">
            <div class="form-group">
                <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
