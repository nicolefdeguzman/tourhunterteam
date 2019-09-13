<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\History;
use app\models\User;
use app\models\UserSearch;

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

    public function actionTransfer($receiver_id)
    {
        // retrieve sender info
        $modelSender = User::findOne(Yii::$app->user->getId());
        // retrieve receiver info
        $modelReceiver = User::findOne($receiver_id);

        $model = new History();
        $model->sender_user_id = Yii::$app->user->getId();
        $model->receiver_user_id = $receiver_id;
        $model->created_date = date('Y-m-d h:i:a');
        $model->sender_old_balance = $modelSender->balance;
        $model->receiver_old_balance = $modelReceiver->balance;

        if ($model->load(Yii::$app->request->post())) {
            $old_balance = doubleval($modelSender->balance);
            $new_balance = $old_balance - doubleval($model->amount);
            $model->sender_new_balance = doubleval($new_balance);

            $old_balance1 = doubleval($modelReceiver->balance);
            $new_balance1 = $old_balance1 + doubleval($model->amount);
            $model->receiver_new_balance = doubleval($new_balance1);

            if ($new_balance < -1000) {
                Yii::$app->getSession()->setFlash('warning', Yii::t('app', 'Sorry! Insufficient balance for transaction.'));
            }else{
                if ($model->save()) {
                    $modelReceiver->balance = doubleval($new_balance1);
                    
                    if ($modelReceiver->save()) {
                        $modelSender->balance = $new_balance;
                        
                        if ($modelSender->save()) {
                            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'You sucessfull transferred '.doubleval($model->amount).' into other account ('.$model->receivers->username.').'));
                        }else{
                            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Success! You already transferred in other account.'));
                        }
                    }else{
                        Yii::$app->getSession()->setFlash('info', Yii::t('app', 'Your balance is not updated'));
                    }
                }
            }
            return $this->redirect('index');
        }
 
        return $this->render('transfer', [
            'model' => $model,
        ]);
    }
    public function actionSignup()
    {
        $model = new SignupForm();
 
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionAddAdmin() {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@devreadwrite.com';
            $user->setPassword('admin');
            $user->generateAuthKey();
            if ($user->save()) {
            }
        }
        return $this->redirect('login');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        if ($model->load(Yii::$app->request->post()) && $model->login($model->username)) {
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
