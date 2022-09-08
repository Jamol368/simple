<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property int $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord
{

    public $img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'slug'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'status' => 'Status',
            'image' => 'Img',
            'img' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function beforeSave($insert){

        $this->img = UploadedFile::getInstance($this,'img');
        $forTime = time();

        if($this->img != null && $this->img->saveAs(Yii::getAlias('@uploads/'.$forTime.'.'.$this->img->extension))){
            $this->image = $forTime.'.'.$this->img->extension;
        }

        return true;

    }

    public function afterDelete(){
        if(file_exists(Yii::getAlias('@uploads/'.$this->image))) {
            unlink(Yii::getAlias('@uploads/' . $this->image));
        }
        return true;
    }

    public function getImage(){
        return Yii::getAlias('@uploads/'.$this->image);
    }
}
