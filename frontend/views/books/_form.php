<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Books */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="books-form">
    <?php $form = ActiveForm::begin([
//        'action' => $referrer,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'author_id')->dropDownList($authorsList) ?>

    <?= $form->field($model, 'date')->textInput([
        'value' => date('d.m.Y', (int)$model->date),
    ]) ?>

    <?= $form->field($model, 'referrer')->hiddenInput([
            'value'=>$referrer,
            'name'=>'referrer',
        ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
