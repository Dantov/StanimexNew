<?php

namespace app\models;

use app\models\tables\Users;
use Yii;


/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class StanLoginForm
{
    protected $login;
    protected $password;

    private $users = [];
    private $_user = [];

    protected $validationErrors = [];

    protected $badChars = ['\'', '\\', '/', '"','*','|',':',';','`'];

    public function __construct( string $login = null, string $password = null )
    {
        if ( $login )
            $this->login = trim( htmlentities($login) );

        if ( $password )
            $this->password = trim( htmlentities($password) );
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            'password' => [
                'string' => true,
                'required' => true,
                'min' => 5,
                'max' => 12,
                'badChars' => true,
            ],
            'login' => [
                'string' => true,
                'required' => true,
                'min' => 5,
                'max' => 33,
                'badChars' => true,
            ],
        ];
    }

    public function admSessionKey( string $key )
    {
        switch ( $key )
        {
            case "set":
                return yii::$app->session->set('st_adm',password_hash("xx123",PASSWORD_DEFAULT));
                break;
            case "has":
                if ( yii::$app->session->has('st_adm') )
                    return password_verify("xx123", yii::$app->session->get('st_adm'));
                return false;
                break;
            case "dell":
                if ( yii::$app->session->has('st_adm') )
                    return yii::$app->session->remove('st_adm');
                break;
            default :
                return false;
        }

        return false;
    }


    /**
     */
    public function validateLogin()
    {
        if (!$this->validate('login', $this->login))
            return false;

        foreach ( $this->getUsers() as $user )
        {
            if ( $user['login'] === $this->login )
            {
                $this->_user = $user;
                return true;
            }
        }

        $this->validationErrors['login'] = "Нет такого пользователя.";
        return false;
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        //password_hash('12345',PASSWORD_DEFAULT);
        //$ph = password_hash($this->password,PASSWORD_DEFAULT);

        if (!$this->validate('password', $this->password))
            return false;

        if ( password_verify($this->password, $this->_user['password']) )
            return true;

        $this->validationErrors['password'] = "Нет такого пользователя.";
        return false;
    }

    protected function validate( string $field, $data )
    {
        $rules = $this->rules();
        if ( !isset($rules[$field]) )
        {
            $this->validationErrors['error'] = "Нет такого поля '". $field ."' для валидации";
            return false;
        }

        $data = trim($data);

        foreach ( $rules[$field] as $ruleName => $rule )
        {
            switch ( $ruleName )
            {
                case "string":
                    if ( !is_string($data) )
                        $this->validationErrors[$field] = "Поле должно быть строкой!";
                    break;
                case "required":
                    if ( empty($data) )
                        $this->validationErrors[$field] = "Поле не должно быть пустым!";
                    break;
                case "min":
                    if ( mb_strlen($data) < $rule )
                        $this->validationErrors[$field] = "Слишком мало сиволов.";
                    break;
                case "max":
                    if ( mb_strlen($data) > $rule )
                        $this->validationErrors[$field] = "Слишком много сиволов.";
                    break;
                case "badChars":
                    $symbols = $arrChars = preg_split('//u',$data,-1,PREG_SPLIT_NO_EMPTY);
                    foreach ( $symbols as $symbol )
                    {
                        if ( in_array($symbol, $this->badChars) )
                        {
                            $this->validationErrors[$field] = "Поле содержит не допустимые символы.";
                            break;
                        }
                    }
                    break;
            }
        }

        /** Была записана ошибка */
        if ( isset( $this->validationErrors[$field] ) )
            return false;

        return true;
    }


    /**
     *
     */
    public function getUsers()
    {
        if ( !empty($this->users) )
            return $this->users;

        return $this->users = Users::find()->asArray()->all();
    }


    public function getError( string $errorName )
    {
        if ( isset( $this->validationErrors[$errorName] ) )
            return $this->validationErrors[$errorName];

        return null;
    }


    public function getAllErrors()
    {
        return $this->validationErrors;
    }
}
