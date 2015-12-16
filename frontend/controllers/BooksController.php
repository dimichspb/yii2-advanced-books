<?php

namespace frontend\controllers;

use Yii;
use common\models\Books;
use common\models\BooksSearch;
use common\models\Authors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $authors = new Authors();

        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authorsList' => $authors->getAuthorsFullnamesList(),
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Books();
        $authors = new Authors();

        if ($model->saveChanges()) {
            return $this->redirect(Yii::$app->request->post('referrer'));
        }

        return $this->render('create', [
            'model' => $model,
            'authorsList' => $authors->getAuthorsFullnamesList(),
            'referrer' => $this->getReferrer(),
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $authors = new Authors();

        if ($model->saveChanges()) {
            return $this->redirect(Yii::$app->request->post('referrer'));
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $this->findModel($id),
                'authors' => $authors,
            ]);
        }

        return $this->render('update', [
            'model' => $this->findModel($id),
            'authorsList' => $authors->getAuthorsFullnamesList(),
            'referrer' => $this->getReferrer($id),
        ]);
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) 
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
 
    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    private function getReferrer($id = null)
    {
        $referrer = Yii::$app->request->post('referrer');
        if ($referrer) {
            return $referrer;
        }

        $route = parse_url(Yii::$app->request->referrer, PHP_URL_PATH);
        parse_str(parse_url(urldecode(Yii::$app->request->referrer), PHP_URL_QUERY), $params);

        return $params ? $route . '?'. http_build_query($params): $route;
    }
}
