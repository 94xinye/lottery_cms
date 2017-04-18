<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2016/12/9
 * Time: 17:19
 * Email:liyongsheng@meicai.cn
 */

namespace app\modules\backend\models;

use app\models\Member;
use yii\base\Model;
use Yii;

class ResetPasswordForm extends Model
{
    public $newPassword;
    public $passwordRepeat;

    /** @var  AdminUser */
    public $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['newPassword','passwordRepeat'], 'required'],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'newPassword'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function saveEdit()
    {
        if(!($this->user instanceof Member)){
            $this->addError('未设置member model');
            return false;
        }
        if($this->validate()){
            $this->user->password_hash = AdminUser::createPassword($this->newPassword.$this->user->salt);
            return $this->user->save(false);
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passwordRepeat' => '重复密码',
            'newPassword' => '新密码',
        ];
    }
}