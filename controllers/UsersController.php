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
use app\models\Likes;
use app\models\Blocks;
use app\models\Notifications;
use app\models\Visits;
use yii\web\UploadedFile;
use yii\db\Expression;

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
            // $user = Users::findByUsername(Yii::$app->user->identity->user_name);
            // $user->last_connection = new Expression('NOW()');
            // $user->save();

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionUser($user_name)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = Users::findByUsername($user_name);
        $avatars = Avatars::getAvatarsByUserId($model->Id);
        $interests = Userstointerests::getInterestsToStringByUserId($model->Id);

        // For visit history
        $visit = new Visits;
        $visit->visit_from = Yii::$app->user->identity->Id;
        $visit->visit_to = $model->Id;
        $visit->save();

        // Save this visit to notification table
        $notification = new Notifications;
        $notification->users_id = $model->Id;
        $notification->notification_type = 4; // 4 stands for notification type - Visits
        $notification->save();

        $myself = "''"; // to avoid select error if myself would be NULL
        $likes = array();

        if (isset(Yii::$app->user->identity->Id)) {
            $myself = Yii::$app->user->identity->Id;

            $queryLikes = Likes::find(['like_to'])
                ->where(['like_from' => Yii::$app->user->identity->Id])
                ->asArray()
                ->all();

            foreach ($queryLikes as $value) {
                $likes[] = $value['like_to'];
            }
        }

        $blocked = Blocks::find('block_to')
            ->where(['block_from' => Yii::$app->user->identity->Id, 'block_to' => $model->Id])
            ->asArray()
            ->count();

        return $this->render('userpage', ['model' => $model, 'avatars' => $avatars, 'interests' => $interests,
            'likes' => $likes, 'blocked' => $blocked]);
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
                if ($delete_image !== "sources/no_image.png") 
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

    /**
     * AJAX callback from client.
     */
    public function actionLike() {
        $user_id = $_POST['likeUserId'];
        json_decode($user_id);

        $like = new Likes;

        $like->like_from = Yii::$app->user->identity->Id;
        $like->like_to = $user_id;
        $like->save();

        // Checking if like from that usesr exists so that notification would be "you have a like back"
        $like_exists = Likes::checkLike($user_id, Yii::$app->user->identity->Id);

        $notification = new Notifications;
        $notification->users_id = $user_id;
        $notification->notification_type = $like_exists ? 3 : 1;
        $notification->save();
    }

    /**
     * AJAX callback from client.
     */
    public function actionUnlike() {
        $user_id = $_POST['likeUserId'];
        json_decode($user_id);

        Yii::$app
        ->db
        ->createCommand()
        ->delete('Likes', ['like_from' => Yii::$app->user->identity->Id, 'like_to' => $user_id])
        ->execute();

        $notification = new Notifications;
        $notification->users_id = $user_id;
        $notification->notification_type = 2;
        $notification->save();
    }

    /**
     * AJAX callback from client.
     */
    public function actionBlock() {
        $user_id = $_POST['blockUserId'];
        json_decode($user_id);

        $block = new Blocks;

        $block->block_from = Yii::$app->user->identity->Id;
        $block->block_to = $user_id;
        $block->save();
    }

    public function actionUnblock() {
        $user_id = $_POST['blockUserId'];
        json_decode($user_id);

        Yii::$app
            ->db
            ->createCommand()
            ->delete('Blocks', ['block_from' => Yii::$app->user->identity->Id, 'block_to' => $user_id])
            ->execute();
    }

    public function actionFake() {
        $user_id = $_POST['fakeUserId'];
        json_decode($user_id);

        $user = Users::findIdentity($user_id);

        $user->fake_reported = 1;
        $user->save();
    }

    /**
     * AJAX callback from client.
     */
    public function actionGetOnlineStatus() {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $user_name = $_GET['user'];
        json_decode($user_name);

        $user = Users::findByUsername($user_name);

        $timeFromLastConnection = time() - strtotime($user->last_connection);

        if ($timeFromLastConnection < 10) {
            echo "data: (online)\n\n";
        } else {
            $last_seen_time = date($user->last_connection);
            echo "data: (offline. last seen $last_seen_time)\n\n";
        }
        flush();
    }

    /**
     * AJAX callback from client.
     */
    public function actionSetOnlineStatus() {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        if (Yii::$app->user->isGuest) {
            echo "data: \n\n";
            flush();
            return 0;
        }

        $user = Users::findIdentity(Yii::$app->user->identity->Id);
        $user->last_connection = date('Y-m-d H:i:s');
        $user->save();

        echo "data: saved\n\n";
        flush();
    }

}
