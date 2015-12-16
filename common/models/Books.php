<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property integer $date_create
 * @property integer $date_update
 * @property string $preview
 * @property integer $date
 * @property integer $author_id
 *
 * @property Authors $author
 */
class Books extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'date', 'author_id'], 'required'],

            [['name'], 'trim'],

            [['name', 'preview'], 'string', 'max' => 255],
            [['author_id'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

            [['date'], 'date', 'format' => Yii::$app->params['dateFormat']],
            [['name', 'date', 'author_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата изменения',
            'preview' => 'Превью',
            'previewUrl' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function getPreviewUrl() 
    {
        return $this->preview ? DIRECTORY_SEPARATOR . $this->previewsFolder . DIRECTORY_SEPARATOR . $this->preview: null;
    }

    public function getPreviewsFolder()
    {
        $folderName = Yii::$app->params['previewsFolder'] . DIRECTORY_SEPARATOR . $this->id;
        BaseFileHelper::createDirectory($folderName);

        return $folderName;
    }

    public function upload()
    {
        if ($this->imageFile) {
            $this->imageFile->saveAs($this->previewsFolder . DIRECTORY_SEPARATOR . $this->imageFile->name);
            return true;
        }
        return false;
    }

    public function saveChanges()
    {
        if ($this->load(Yii::$app->request->post())) {
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            if ($this->imageFile) {
                $this->preview = $this->imageFile->name;
            }

            if ($this->validate() && $this->save()) {
                $this->upload();
                return true;
            }
        };
    }

    public function beforeSave($insert)
    {
        if ($insert) {
          $this->date_create = strtotime(date('Y-m-d H:m:s'));
          $this->date_update = strtotime(date('Y-m-d H:m:s'));
        } else {
          $this->date_update = strtotime(date('Y-m-d H:m:s'));
        }
        $this->date = strtotime($this->date);

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->preview)
                if (file_exists($this->previewsFolder . DIRECTORY_SEPARATOR . $this->preview)) {
                    unlink($this->previewsFolder . DIRECTORY_SEPARATOR . $this->preview);
                }
                if (($files = @scandir($this->previewsFolder)) && count($files) <= 2)  {
                    rmdir($this->previewsFolder);
                }
            return true;
        }

        return false;
    }
}
