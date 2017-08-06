<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;
use app\models\Avatars;

/**
 * SignupForm is the model behind the signup form.
 */
class SignupForm extends Model
{
    public $user_name;
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $password_repeat;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_name', 'email', 'first_name', 'last_name', 'password'], 'required'],
            [['user_name', 'email', 'first_name', 'last_name'], 'string', 'max' => 50],
            // email has to be a valid email address
            ['email', 'email'],
            // ['email', 'unique', 'targetClass' => 'app\models\Users'],
            // ['user_name', 'unique', 'targetClass' => 'app\models\Users'],
            // verifyCode needs to be entered correctly
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'string', 'min' => 1]
        ];
    }

    public function signup() {
        $user = new Users;
        $avatars = new Avatars();
        $user->user_name = $this->user_name;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->hashPassword($this->password);
        // $user->generateAuthKey(); // for saving and autentification over cookies. should be auth_key col in DB
        $user->save();
        $avatars->users_id = $user->Id;
        $avatars->save();
        return $user->save();
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'user_name' => 'User Name',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password_repeat' => 'Password again',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function emailSignupSuccess()
    {
        $subject = "Success sign up to Matcha";
        $body = "Hi there, ". $this->first_name . "! \n\n You are successfully registered to Matcha. To find more relevant people you should fill more data about yourself in Settings->Edit settings. \n\n Good luck!";
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();

            return true;
        }
        return false;
    }
}
