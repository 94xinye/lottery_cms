<?php

namespace app\models;

use yii\db\Expression;
use Yii;
use app\components\AppActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\db\ActiveQuery;
use app\components\behaviors\UploadBehavior;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $link partner
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $online_at
 * @property integer $offline_at
 * @method createUploadFilePath()
 * @method uploadImgFile()
 * @property array $statuses
 */
class Ad extends AppActiveRecord
{
    /**
     * 轮播图
     */
    const TYPE_CAROUSEL =101;
    /**
     * 友情链接
     */
    const TYPE_BLOGROLL =102;
    /**
     * 寻宝频道
     */
    const TYPE_TREASURE =103;

    /**
     * 当前类型
     * @var int
     */
    static $currentType = self::TYPE_CAROUSEL;

    static $types = [
        self::TYPE_CAROUSEL=>'轮播图',
        self::TYPE_BLOGROLL=>'友情链接',
        self::TYPE_TREASURE=>'寻宝频道',
    ];

    public function init()
    {
        parent::init();
        $this->setAttribute('type', static::$currentType);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }
    public function beforeSave($insert)
    {
        $res = parent::beforeSave($insert);
        if($res==false){
            return $res;
        }
        if (!$this->validate()) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }
        $file = $this->uploadImgFile();
        if(empty($file) && empty($this->image)){
            $this->addError('imageFile','图片不能为空');
            return false;
        }
        if(!empty($file)) {
            $this->image = $file;
        }
        return true;
    }
    /**
     * 转换时间
     * @return array|false|int
     */
    public function getDatetimeToAt($t)
    {
        if(empty($t)){
            return null;
        }
        $createAt = strtotime($t.':00');
        return $createAt;
    }
    /**
     * 转换时间
     * @return array|false|int
     */
    public function getAtToDatetime($t)
    {
        if(empty($t)){
            return null;
        }
        return date('Y-m-d H:i',$t);
    }
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'saveDir' => 'ad-img/'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','online_at','offline_at'], 'required'],
            [['imageFile'], 'file', 'extensions' => 'gif, jpg, png, jpeg','mimeTypes' => 'image/jpeg, image/png',],
            [['created_at', 'updated_at','sort','status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['image', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '广告名称',
            'image' => '图片',
            'imageFile' => '图片文件',
            'link' => '跳转链接',
            'created_at' => '创建时间',
            'updated_at' => '最后修改',
            'online_at' => '上线时间',
            'offline_at' => '下线时间',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
    /**
     * 获取状态
     * @return array
     */
    public function getStatuses()
    {
        return [
            '1'=>'已上线',
            '2'=>'待上线',
            '3'=>'已下线',
            '4'=>'禁用',
        ];
    }
    /**
     * @inheritdoc
     * @return \yii\db\ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
//        AdQuery::$type = static::$currentType;
        return Yii::createObject(AdQuery::className(), [get_called_class()]);
    }
}

class AdQuery extends ActiveQuery
{
    static $type = Ad::TYPE_CAROUSEL;

    public function init()
    {
//        $this->andWhere(['type' => self::$type]);
        return $this;
    }
    /**
     * Sets the WHERE part of the query.
     *
     * The method requires a `$condition` parameter, and optionally a `$params` parameter
     * specifying the values to be bound to the query.
     *
     * The `$condition` parameter should be either a string (e.g. `'id=1'`) or an array.
     *
     * @inheritdoc
     *
     * @param string|array|Expression $condition the conditions that should be put in the WHERE part.
     * @param array $params the parameters (name => value) to be bound to the query.
     * @return $this the query object itself
     * @see andWhere()
     * @see orWhere()
     * @see QueryInterface::where()
     */
    public function where($condition, $params = [])
    {
        parent::andWhere($condition, $params);
        return $this;
    }
}
