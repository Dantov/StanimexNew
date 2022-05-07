<?php

namespace app\controllers\admin;

use app\models\tables\Orders;
use app\models\tables\Shipments;
use app\models\tables\Stock;
use app\models\tables\UsersOnline;
use function Composer\Autoload\includeFile;
use Yii;
use app\models\admin\{
    AboutUsModel, OrdersModel, ShipmentModel, ShipmentsModel, StockModel, WeBuyModel
};
use app\models\StanLoginForm;
use yii\filters\{AccessControl,VerbFilter};
use yii\web\{Controller,Response};


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

        $users = UsersOnline::find()->asArray()->all();
        $uniqueUsers = count($users);
        $totalViews = 0;
        foreach ($users as $user)
            $totalViews += $user['views_count'];

        $stock = Stock::find()
            ->select('id, short_name_ru, short_name_en, views')
            ->asArray()
            ->all();

        $topMachine = 0;
        $topMachineViews = 0;
        foreach ($stock as $machine)
        {
            if( $machine['views'] > $topMachineViews )
            {
                $topMachineViews = $machine['views'];
                $topMachine = $machine;
            }
        }

        $ordersCount = Orders::find()->count();

        $compact = ['uniqueUsers','totalViews','topMachine','ordersCount'];
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
        $shipmentID = (new ShipmentsModel())->getFromStockID($id);
        $machine = $stockM->getMachine();
        $images = $machine['images'];

        $compact = ['machine','images','shipmentID'];
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
        //debugAjax($loaded,"loaded",1);

        if ( isset($loaded['removeImage']) && !empty($loaded['removeImage']) )
        {
            $stockM = new StockModel();
            if ( $stockM->deleteImage( (int)$loaded['removeImage'] ) )
                exit(json_encode(['ok'=>1]));
        }

        if ( isset($loaded['removeImageSp']) && !empty($loaded['removeImageSp']) )
        {
            $s = new ShipmentsModel($loaded['rowID']);
            if ( $s->removeImg( $loaded['removeImageSp'] ) )
                exit(json_encode(['ok'=>1]));
        }


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

    public function actionShipments()
    {
        $this->actionCheckSession();
        $session = Yii::$app->session;
        $response = yii::$app->response;


        $shipments = new ShipmentsModel();
        $all = $shipments->getAll();
        //debug($all,'$all',1);

        $compact = ['all'];
        return $this->render('shipments', compact($compact));
    }

    /**
     * @param $id
     * @return string|\yii\console\Response|Response
     * @throws \Exception
     */
    public function actionShipment( $id=null )
    {
        $this->actionCheckSession();
        $session = Yii::$app->session;
        $response = yii::$app->response;
        $request = yii::$app->request;

        if ( $request->isAjax )
        {
            $resp = [];
            if ( $shipID = $request->post('shipmentID') )
            {
                $shipment = new ShipmentsModel($shipID);
                if ( $errors = $shipment->uploadImages() )
                {
                    if ( is_array($errors) )
                    {
                        $session->setFlash('uplFiles_error','Some image files are not uploaded: ' . implode('; ', $errors) );
                    } elseif ($errors) {
                        $session->setFlash('uplFiles_success','Image files are success uploaded!');
                    } else {
                        $session->setFlash('uplFiles_error','An error has occurred! Image files are no uploaded.');
                        $resp['errors'] = "An error has occurred! Image files are no uploaded.";
                        exit( json_encode($resp) );
                    }
                    $resp['files'] = $shipment->getUploadedFiles();
                }
            }

            exit( json_encode($resp) );
        }
        $action = '';
        $shipment = null;
        if ( $request->isPost )
        {
            $action = 'edit';
            $shipment = new ShipmentsModel($id);

            if ( $shipment->update($request->post()) )
            {
                $session->setFlash('success_upd','Text data are success edited!');
            } else {
                $session->setFlash('no_upd','Text data are not updated!');
            }
        }

        if ($request->isGet)
            $action = $request->get('a');

        switch ( $action )
        {
            case "add":
                $shipment = new ShipmentsModel();
                $newID = $shipment->newOne($request->get('pos_id'));
                return $response->redirect(['/stan-admin/shipment/'.$newID,'a'=>'edit']);
                break;
            case "edit":
                if ( !$shipment )
                    $shipment = new ShipmentsModel($id);

                $one = $shipment->getOne();
                //debug($one,'$one',1);
                break;
            default :
                return $response->redirect('/stan-admin/shipments/');
                break;
        }

        $compact = ['one','action'];
        return $this->render('shipment', compact($compact));
    }

    /**
     * @param int $id
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteshipment(int $id)
    {
        $this->actionCheckSession();
        $session = Yii::$app->session;
        $response = yii::$app->response;

        $s = new ShipmentsModel($id);
        if ( $s->remove() )
        {
            $session->setFlash('success','Shipment was successfully deleted.');
        } else {
            $session->setFlash('error','An error has occurred!');
        }

        $response->redirect('/stan-admin/shipments');
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