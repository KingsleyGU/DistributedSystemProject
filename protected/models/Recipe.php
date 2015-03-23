<?php

/**
 * This is the model class for table "Recipe".
 *
 * The followings are the available columns in table 'Recipe':
 * @property integer $id
 * @property string $recipeId
 * @property string $title
 * @property string $webUrl
 * @property string $imageUrl
 */
class Recipe extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Recipe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipeId, title, webUrl, imageUrl', 'required'),
			array('recipeId', 'length', 'max'=>16),
			array('title', 'length', 'max'=>120),
			array('webUrl, imageUrl', 'length', 'max'=>180),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, recipeId, title, webUrl, imageUrl', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'recipeId' => 'Recipe',
			'title' => 'Title',
			'webUrl' => 'Web Url',
			'imageUrl' => 'Image Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('recipeId',$this->recipeId,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('webUrl',$this->webUrl,true);
		$criteria->compare('imageUrl',$this->imageUrl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recipe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
