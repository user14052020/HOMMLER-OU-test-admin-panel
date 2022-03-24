<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }
        $searchModel = new ProductSearch();
        // var_dump(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider = new ActiveDataProvider([
        //     'query' => Product::find(),
        //     'pagination' => [
        //         'pageSize' => 5,
        //     ],
        // ]);
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionBulk(){
       $action=Yii::$app->request->post('action');
       $selection=(array)Yii::$app->request->post('selection');
       foreach($selection as $id){
        $model = Product::findOne((int)$id);
        $model->delete();
      }
      return $this->redirect(['index']);
    }
    public function actionView($id){
        $model = Product::findOne($id);
        return $this->render('view',['model'=> $model]);
    }
    public function actionDelete($id){
        $model = Product::findOne($id);
        if (isset($model->id)) {
            $model->delete();
        }
        return $this->redirect(['index']);

    }
    public function actionAdd(){
        $model = new Product();
        if($model->load(Yii::$app->request->post())){
            $model->imageFile = UploadedFile::getInstance($model,'imageFile');
            if (isset($model->imageFile)) {
                $model->upload();
            }
            $model->imageFile = null;
            $model->save();
            // var_dump($model);
            // exit();
            return $this->redirect(['view','id'=>$model->id]);
        }
        return $this->render('edit',['model'=> $model]);
    }
    public function actionUpdate($id){
        $model = Product::findOne($id);
        if($model->load(Yii::$app->request->post())){
            $model->imageFile = UploadedFile::getInstance($model,'imageFile');
            if (isset($model->imageFile)) {
                $model->upload();
            }
            $model->imageFile = null;
            $model->save();
            return $this->redirect(['view','id'=>$model->id]);
        }
        return $this->render('edit',['model'=> $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
