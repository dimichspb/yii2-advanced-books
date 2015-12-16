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
            // only authorized users can access BooksController's actions
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
    public function actionIndex()
    {
        // we need to give the list of Authors to the view so we have to use Authors model
        $authors = new Authors();

        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authorsList' => $authors->getAuthorsFullnamesList(), // sending authors fullnames list to view
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       // if the modal window is opened render compact view of page
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
        // if form validates and preview file has been saved redirect browser to referrer page
        if ($model->saveChanges()) {
            return $this->redirect(Yii::$app->request->post('referrer'));
        }

        return $this->render('create', [
            'model' => $model,
            'authorsList' => $authors->getAuthorsFullnamesList(),
            'referrer' => $this->getReferrer(), //sending referrer url to the view for redirect on success validation
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
            'referrer' => $this->getReferrer(),
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

    /**
     * Returns page referrer url with params. If referrer is form with referrer field specified return its value.
     * For example if one of fields was not validated after form submit we need to know origin referrer url not
     * previous form url. So using hidden field referrer in form we can know original referrer.
     *
     * @return string referrer url with params
     */
    private function getReferrer()
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
