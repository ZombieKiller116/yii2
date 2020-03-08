<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;

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
        if(!Yii::$app->user->isGuest) {
            if(!Yii::$app->user->identity->status)
            {
                $model = new \app\models\forms\ConfirmForm;
                if ($model->load(\Yii::$app->request->post())){
                    if($model->token == Yii::$app->user->identity->email_confirm_token) {
                        Yii::$app->user->identity->status = 1;
                        Yii::$app->user->identity->save();

                        return $this->render('index');
                    } else {
                        Yii::$app->getSession()->setFlash('info', 'Неправильный код подтверждения! Проверьте свою почту и введите код еще раз');
                    }
                };
                Yii::$app->mailer->compose()
                    ->setTo(Yii::$app->user->identity->email)
                    ->setFrom(['maximfix@yandex.ru' => 'Тестовый сайт'])
                    ->setSubject('Подтвердите адрес электронной почты')
                    ->setTextBody('Для подтверждения вашей электронной почты введите следующий код: ' . Yii::$app->user->identity->email_confirm_token)
                    ->send();

                return $this->render('confirm', compact('model'));

            }
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new \app\models\forms\LoginForm;

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne(['email' => $model->email]);
            if($user !== null && Yii::$app->getSecurity()->validatePassword($model->password, $user->password)) {
                Yii::$app->user->login($user, 3600 * 24 * 7);
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('login-error', 'Email или пароль неверны.');
            }
        }

        $this->view->title = 'Авторизация | ' . Yii::$app->params['site_name'];
        return $this->render('login', compact('model'));
    }

    public function actionRegister()
    {
        $model = new \app\models\forms\RegisterForm;

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User([
                'email' => $model->email,
                'password' => Yii::$app->getSecurity()->generatePasswordHash($model->password),
                'access_token' => Yii::$app->getSecurity()->generateRandomString(60),
                'name' => $model->name,
                'email_confirm_token' => Yii::$app->getSecurity()->generateRandomString(20)
            ]);
            if( $user->save() ) {
                Yii::$app->user->login($user, 3600 * 24 * 7);
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('register-error', $user->errors);
            }
        }

        $this->view->title = 'Регистрация | ' . Yii::$app->params['site_name'];
        return $this->render('register', compact('model'));
    }

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
