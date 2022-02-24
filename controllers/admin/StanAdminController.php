<?php

namespace app\controllers\admin;

use app\models\admin\AboutUsModel;
use app\models\admin\OrdersModel;
use app\models\admin\StockModel;
use app\models\admin\WeBuyModel;
use app\models\Files;
use app\models\StanLoginForm;
use app\models\tables\Orders;
use app\models\tables\Webuy;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class StanAdminController extends Controller
{

    public $layout = "admin_tpl";
    //public $layout = "stan-theme";

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

    protected function actionCheckSession()
    {
        $loginForm = new StanLoginForm();

        if ( !$loginForm->admSessionKey('has') )
            return yii::$app->response->redirect(['/stan-admin']);

        return true;
    }

    /**
     *
     */
    public function actionLogin()
    {
        $request = yii::$app->request;
        $response = yii::$app->response;
        $session = yii::$app->session;

        if ( !$request->isPost )
            $this->response->redirect('/');

        $loaded = $request->post();

        $loginForm = new StanLoginForm($loaded['login'],$loaded['password']);

        if ( !$loginForm->validateLogin() )
        {
            $session->setFlash('loginError',$loginForm->getError('login'));
            return $response->redirect(['/stan-admin']);
        }

        if ( !$loginForm->validatePassword() )
        {
            $session->setFlash('passwordError','Пароль не верен!'); //$loginForm->getError('password')
            return $response->redirect(['/stan-admin']);
        }

        $loginForm->admSessionKey('set');

        return $response->redirect(['/stan-admin/main']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionMain()
    {
        $this->actionCheckSession();

        $uniqueUsers = 100;
        $totalViews = 100;
        $topMachine = 100;
        $compact = ['uniqueUsers','totalViews','topMachine'];
        return $this->render('main', compact($compact));
    }

    /**
     * @return string|\yii\console\Response|Response
     */
    public function actionAbout()
    {
        $this->actionCheckSession();
        $request = yii::$app->request;
        $response = yii::$app->response;

        if ( $request->isPost )
        {
            $loaded = $request->post();
            $about = new AboutUsModel();
            //debug($loaded,"loaded");
            $parsed = $about->parseData($loaded);
            //debug($parsed,"parsed",1);
            $about->updateData($parsed);

            return $response->redirect(['/stan-admin/about']);
        }

        $aboutModel = new AboutUsModel();

        $about = $aboutModel->getAbout();
        $contacts = $aboutModel->getContacts();

        $compact = ['about','contacts'];
        return $this->render('about', compact($compact));
    }

    /**
     * @return string
     * @throws \yii\db\StaleObjectException
     */
    public function actionWebuy()
    {
        $this->actionCheckSession();
        $request = yii::$app->request;

        $wb = new WeBuyModel();

        /** ДОБАВИТЬ / УДАЛИТЬ  */
        if ( $request->isAjax )
        {
            $loaded = $request->post();
            $resp = [];
            if ( isset( $loaded['addNewRow'] ) )
            {
                if ( $id = $wb->createNew() )
                {
                    $resp['id'] = $id;
                } else {
                    $resp['errors'] = "Error adding try later!";
                }
                exit( json_encode($resp) );
            }

            if ( $id = $loaded['removePosId'] )
            {
                if ($wb->remove($id))
                {
                    $resp['ok'] = 1;
                } else {
                    $resp['errors'] = "Error on deleting pos try later!";
                }
                exit( json_encode($resp) );
            }

            exit(json_encode(['debug'=>'nothing done']));
        }


        /** ЗАПИСАТЬ */
        if ( $request->isPost )
        {

            $loaded = $request->post();
            //debug($loaded,'$loaded',1);
            $parsed = $wb->parseData($loaded);
            $wb->updateData($parsed);
        }

        /** РИСУЕМ СТР. */
        $webuy = $wb->getWebuy();
        $compact = ['webuy'];
        return $this->render('webuy', compact($compact));
    }

    /**
     * ПРОСМОТР СТОКА В АДМИНКЕ
     * @return string
     */
    public function actionStock()
    {
        $this->actionCheckSession();
        $request = yii::$app->request;
        $response = yii::$app->response;
        $session = Yii::$app->session;

        $session->set('isPriceList', true);
        $stockM = new StockModel();
        $machines = $stockM->getStock();
        $session->set('isPriceList',false);

        $compact = ['machines'];
        return $this->render('stock', compact($compact));
    }

    /**
     * @param null $id
     * @return string|\yii\console\Response|Response
     * @throws \Exception
     */
    public function actionEditmachine( $id = null )
    {
        $this->actionCheckSession();
        $request = yii::$app->request;
        $session = Yii::$app->session;

        $stockM = new StockModel($id);

        /** ДОБАВЛЯЕМ КАРТИНКИ */
        if ( $request->isAjax )
        {
            $loaded = $request->post();
            $resp = ['debug'=>'nothing done yet'];
            if ( isset($loaded['uploadImages']) )
            {
                //$resp = ['ID'=>$id,'loaded'=>$loaded,'$_FILES'=>$_FILES];
                $resp = ['debug'=>$id];

                if ( $errors = $stockM->uploadFiles() )
                {
                    if ( is_array($errors) )
                    {
                        $session->setFlash('uplFiles_error','Some Machine image files are not uploaded: ' . implode('; ', $errors) );
                    } elseif ($errors) {
                        $session->setFlash('uplFiles_success','Machine image files are success uploaded!');
                    } else {
                        $session->setFlash('uplFiles_error','An error has occurred! Machine image files are no uploaded.');
                        $resp['errors'] = "An error has occurred! Machine image files are no uploaded.";
                        exit( json_encode($resp) );
                    }

                    $stockM->updateImgFlag();

                    $resp['files'] = $stockM->getUploadedFiles();
                }
            }

            exit( json_encode($resp) );
        }

        /** СОХРАНЕНИЕ ФОРМЫ*/
        if ( !$request->isAjax && $request->isPost  )
        {
            $loaded = $request->post();
            //debug($loaded,"loaded");

            $machineParsed = $stockM->parseMachineData($loaded);
            if ( $stockM->editMachineData($machineParsed) )
            {
                $session->setFlash('success_upd','Machine text data are success edited!');
            } else {
                $session->setFlash('no_upd','Machine text data are not updated!');
            }

            /**  Updating Images main Flag!!!!!!!! */
            if ( isset($loaded['main']) )
            {
                if ( $stockM->updateImgFlag((int)$loaded['main']) )
                    $session->setFlash('imgFlag_upd','Main image flag are success updated!');
            }

        }

        /** РЕНДЕР ВИДА */
        $machine = $stockM->getMachine();
        $images = $machine['images'];

        $compact = ['machine','images'];
        return $this->render('editmachine', compact($compact));
    }

    /**
     * УДАЛЕНИЕ КАРТИНОК
     * @return \yii\console\Response|Response
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $this->actionCheckSession();
        $request = yii::$app->request;
        $response = yii::$app->response;

        if ( !$request->isAjax )
            return $response->redirect(['/stan-admin/stock']);

        $loaded = $request->post();
        //debugAjax($loaded,"loaded");

        $stockM = new StockModel();
        if ( $stockM->deleteImage( (int)$loaded['removeImage'] ) )
            exit(json_encode(['ok'=>1]));

        exit(json_encode(['error'=>'1']));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionAddmachine()
    {
        $this->actionCheckSession();
        $response = yii::$app->response;

        $stockM = new StockModel();
        $machineID = $stockM->addMachine();

        return $response->redirect(['/stan-admin/editmachine/' . $machineID]);
    }

    /**
     * УДАЛЕНИЕ ПОЗИЦИИ
     * @param int $id
     * @return \yii\console\Response|Response
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeletemachine(int $id )
    {
        $this->actionCheckSession();
        $session = Yii::$app->session;
        $response = yii::$app->response;

        $stockM = new StockModel($id);
        if ($stockM->deleteMachine()) {
            $session->setFlash('success_dellPosition', 'Machine "' . $stockM->deletedMachineName . '" is successfully deleted!');
        } else {
            $session->setFlash('error_dellPosition', 'Machine "' . $stockM->deletedMachineName . '" is not deleted!');
        }

        return $response->redirect(['/stan-admin/stock']);
    }

    public function actionOrderbox()
    {
        $this->actionCheckSession();
        $session = Yii::$app->session;
        $response = yii::$app->response;


        $om = new OrdersModel();
        $orders = $om->getOrders();

        //debug($orders,'$orders',1);

        $compact = ['orders'];
        return $this->render('orders', compact($compact));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogoutt()
    {
        $loginForm = new StanLoginForm();

        $loginForm->admSessionKey('dell');

        return yii::$app->response->redirect(['/']);
    }


}