<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BooksSearch */
/* @var $authorsList array list of authors */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <?php echo $this->render('_search', [
            'model' => $searchModel,
            'authorsList' => $authorsList,
        ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'raw',
                'value' => function($data){
                    return $data->previewUrl ? Html::a(
                        Html::img($data->previewUrl,[
                            'alt' => $data->name,
                            'style' => 'width: 75px;',
                        ]),
                        $data->previewUrl,
                        [
                            'class' => 'showModalImageButton',
                            'title' => $data->name,
                        ]): null;
                },
            ],
            [
                'attribute' => 'author_id',
                'value' => 'author.fullname',
            ],
            [
                'attribute' => 'date',
                'format' => 'date',
            ],
            [
                'attribute' => 'date_create',
                'format' => 'date',
            ],

            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Update',
                            'data-method' => 'post',
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'class' => 'showModalButton',
                            'title' => 'View',
                            'data-method' => 'post',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => 'Delete',
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'template' => '{update} {view} {delete}',
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
