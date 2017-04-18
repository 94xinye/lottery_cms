<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 15:15
 */

namespace app\models;

use app\components\AppActiveRecord;
use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $nickname
 * @property string $headimgurl
 * @property integer $score
 * @property integer $status
 * @property string $password
 * @property string $salt
 * @property integer $created_at
 */
class Member extends AppActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password_hash'], 'required'],
            [['score', 'status', 'created_at','updated_at'], 'integer'],
            [['headimgurl', 'salt', 'nickname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => '手机号',
            'nickname' => '昵称',
            'headimgurl' => '头像',
            'score' => '积分',
            'status' => '状态',
            'created_at' => '创建时间',
        ];
    }
}
