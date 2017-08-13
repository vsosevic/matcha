<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\EditSettingsForm;
use app\models\Users;
use app\models\Interests;
use app\models\Userstointerests;
use app\models\Cities;
use app\models\Avatars;
use yii\web\UploadedFile;

class UsersController extends \yii\web\Controller
{
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

     /**
     * Displays settings page.
     *
     * @return string
     */
    public function actionSettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        // $geoplugin = new geoPlugin;

        // print_r(yii::$app->geolocation->getInfo('173.194.118.22')); die();
        $model = Users::findByUsername(Yii::$app->user->identity->user_name);
        $avatars = Avatars::getAvatarsByUserId(Yii::$app->user->identity->Id);
        $interests = Userstointerests::getInterestsToStringByUserId(Yii::$app->user->identity->Id);
        return $this->render('settings', ['model' => $model, 'interests' => $interests, 'avatars' => $avatars]);
    }

    public function actionSaveCity()
    {
        // var_dump($_GET); die();
        $model = Users::findByUsername(Yii::$app->user->identity->user_name);
        if (isset($model->city_id))
        {
            die();
        }
        $userCity = yii::$app->geoplugin->locateCity()['geoplugin_city'];
        $cityInDB = Cities::getCityByName($userCity);
        if (!$cityInDB) {
            $cityInDB = new Cities;
            $cityInDB->city = $userCity;
            $cityInDB->save();
        }
        $model->city_id = $cityInDB->Id;
        $model->save();
        // echo $userCity;
    }

    public function actionEditsettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = Users::findByUsername(Yii::$app->user->identity->user_name);
        // $this->actionSaveCity();
        if (is_null($userCity = Cities::getCityToStringById($model->city_id)))
        {
            $userCity = "Worldwide";
        }
        // var_dump($userCity); die();
        // $avatars = Avatars::getAvatarsByUserId(Yii::$app->user->identity->Id);
        if ($model->load(Yii::$app->request->post())) 
        {
            // clear UsersToInterests table;
            $usersToInterests = Userstointerests::find()->where(['users_id' => Yii::$app->user->identity->Id])->all();
            foreach ($usersToInterests as $interest) {
                $interest->delete();
            }
            //split user input with all hastags
            preg_match_all('/(#)\w+/', $_POST['interests'], $matches);
            foreach ($matches[0] as $key => $value)
            {
                $interests = new Interests();
                if (!$interests->getInterestByName($value)) {
                    $interests->interest = $value;
                    $interests->save();
                }
                else
                {
                    $interests = $interests->getInterestByName($value);
                }
                $model->link('interests', $interests);
            }
            
            if (!empty($userCity = $_POST['userCity']))
            {
                $city = Cities::getCityByName($userCity);
                if (is_null($city))
                {
                    $city = new Cities;
                    $city->city = $userCity;
                    $city->save();
                }
                $model->link('city', $city);
                // $model->city_id = $city->Id;
            }
            $model->save();
            return $this->redirect(['users/settings']);
        }
        // $usersToInterests = new Userstointerests;
        $interests = Userstointerests::getInterestsToStringByUserId(Yii::$app->user->identity->Id);
        return $this->render('editsettings', ['model' => $model, 'interests' => $interests, 'userCity' => $userCity]);
    }

    public function actionUploadAvatar()
    {
        if (Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
        $avatars = Avatars::getAvatarsByUserId(Yii::$app->user->identity->Id);
        $avatars->scenario = 'upload-avatar';
        // var_dump($avatars->avatar1); die();
        if (Yii::$app->request->post()) 
        {
            //save input images
            $avatarId = $_GET['avatarId'];
            $new_image = UploadedFile::getInstance($avatars, $avatarId);
            // var_dump($avatars->$avatarId);die();
            $delete_image = $avatars->$avatarId;
            // echo $avatars->avatar1; die();
            $new_image_name = uniqid() . '.' . $new_image->extension;
            $avatars->$avatarId = 'uploads/' . $new_image_name;
            if($avatars->save()) 
            {
                if ($delete_image !== "uploads/no_image.png") 
                {
                    unlink($delete_image);
                }
                $new_image->saveAs('uploads/'.$new_image_name);
            }
            return $this->redirect(['users/settings']);
        }
        return $this->render('upload-avatar', ['avatars' => $avatars]);
    }

    /**
     * Displays signin page.
     *
     * @return string
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->signup()) {
                Yii::$app->getSession()->setFlash('signup.success', 'Signed up successfully! Now you can login!');
                $model->emailSignupSuccess();
                return $this->redirect('login');
            }
        }
        return $this->render('signup', [
            'model' => $model,
            ]);
    }
}
