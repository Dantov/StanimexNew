<?php

namespace app\controllers;

use app\models\Home;
use app\models\PriceList;
use app\models\Machine;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class MainController extends Controller
{

    public $layout = "stan-theme";

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
    public function actionHome()
    {
        $this->view->title = "Stanimex";
        $this->view->params['isHome'] = true;

        $home = new Home();
        $stock = $home->getStock();
        $contacts = $home->getContacts();
        $this->view->params['contacts'] = $contacts;
        $aboutUs = $home->getAboutUs();
        $weBuy = $home->getWebuy();

        $compact = compact(['stock','contacts','aboutUs','weBuy']);
        return $this->render('home',$compact);
    }

    /**
     * Displays Price-List.
     *
     * @return string
     */

    public function actionPriceList()
    {
        $session = Yii::$app->session;
        $session->set('isPriceList', true);

        $this->view->title = "Stanimex Прайс лист";
        $this->view->params['isPriceList'] = true;

        $priceList = new PriceList();
        $stock = $priceList->getStock();

        $session->set('isPriceList',false);

        $isPriceList = true;
        $comp = compact(['isPriceList','stock']);
        return $this->render('price-list',$comp);
    }


    public function actionMachine( $id = null )
    {
        if ( (int)$id < 0 || (int)$id > PHP_INT_MAX )
            $this->response->redirect('/');

        $m = new Machine($id);
        $machine = $m->getMachine();
        $mainImage = $m->getMainImg();

        $machineCrumbs = $m->getMachinesCrumbs( $id );

        $this->view->title = $machine['short_name_ru'];

        $compact = compact(['machine','mainImage','machineCrumbs']);
        return $this->render('machine',$compact);
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


}
