<?php

/**
 * This is the model class for table "attributes".
 *
 * The followings are the available columns in table 'attributes':
 * @property integer $id
 * @property integer $type
 * @property integer $validator
 * @property integer $required
 * @property string  $title
 * @property string  $measure
 * @property integer cId
 */
class Attribute extends EActiveRecord {

	const TYPE_TEXT = 0;
	const TYPE_DROPDOWN = 1;
	const TYPE_RADIO = 2;
	const TYPE_CHECKBOX = 3;
	const TYPE_RADIO_YES_NO = 4;
	const TYPE_TEXTAREA = 5;

	public $cacheTime = 3600;

	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @param string $className active record class name.
	 *
	 * @return Category the static model class
	 */
	public static function model ( $className = __CLASS__ ) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName () {
		return 'attributes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules () {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(
				'cId, type, title',
				'required'
			),
			array(
				'type',
				'in',
				'range' => array_keys($this->typeLabels())
			),
			array(
				'title, measure',
				'length',
				'max' => 255
			),
			array(
				'required, common, separate',
				'safe'
			),
			array(
				'type, title, measure, validator, required, common, cId',
				'safe',
				'on' => 'adminSearch'
			)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations () {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return CMap::mergeArray(parent::relations(),
			array(
			     'chars' => array(
				     self::HAS_MANY,
				     'CategoryAttrChars',
				     'attrId'
			     )
			));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels () {
		return array(
			'id'        => Yii::t('CategoryAttributesModule', 'ID'),
			'title'     => Yii::t('CategoryAttributesModule', 'Название'),
			'type'      => Yii::t('CategoryAttributesModule', 'Тип'),
			'validator' => Yii::t('CategoryAttributesModule', 'Валидатор'),
			'required'  => Yii::t('CategoryAttributesModule', 'Обязательное'),
			'measure'   => Yii::t('CategoryAttributesModule', 'Ед. измерения'),
			'common'    => Yii::t('CategoryAttributesModule', 'Общий'),
			'cId'       => Yii::t('CategoryAttributesModule', 'Категория'),
		);
	}

	public function typeLabels () {
		return array(
			self::TYPE_TEXTAREA     => Yii::t('CategoryAttributesModule', 'Большое текстовое поле'),
			self::TYPE_TEXT         => Yii::t('CategoryAttributesModule', 'Текстовое поле'),
			self::TYPE_DROPDOWN     => Yii::t('CategoryAttributesModule', 'Выпадающий список'),
			self::TYPE_RADIO        => Yii::t('CategoryAttributesModule', 'Радио'),
			self::TYPE_CHECKBOX     => Yii::t('CategoryAttributesModule', 'Чекбокс'),
			self::TYPE_RADIO_YES_NO => Yii::t('CategoryAttributesModule', 'Радио Да/Нет'),
		);
	}

	public function excludeIds ( array $notIn ) {
		if ( sizeof($notIn) ) {
			$this->getDbCriteria()->mergeWith(array(
			                                       'condition' => 'id NOT IN(' . implode(', ', $notIn) . ')',
			                                  ));
		}
		return $this;
	}

	public function includeIds ( array $in ) {
		if ( sizeof($in) ) {
			$this->getDbCriteria()->mergeWith(array(
			                                       'condition' => 'id IN(' . implode(', ', $in) . ')',
			                                  ));
		}
		else {
			$this->getDbCriteria()->mergeWith(array(
			                                       'condition' => 'id = 0',
			                                  ));
		}
		return $this;
	}


	public function forCat ( $id ) {
		$this->getDbCriteria()->mergeWith(array(
		                                       'condition' => 'cId = ' . (int) $id,
		                                  ));
		return $this;
	}

	public function afterDelete () {
		foreach ( $this->chars AS $char ) {
			$char->delete();
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search () {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('measure', $this->measure, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('required', $this->required);
		$criteria->compare('cId', $this->cId);

		return new CActiveDataProvider($this, array(
		                                           'criteria' => $criteria,
		                                      ));
	}

	public function getId () {
		return $this->id;
	}

	public function getTitle () {
		return $this->title;
	}

	public function isCharacteristicsNeeded () {
		return in_array($this->type,
			array(
			     self::TYPE_DROPDOWN,
			     self::TYPE_RADIO,
			     self::TYPE_CHECKBOX
			));
	}

	public function getInputField ( $value = null, $hasErrors = false, $nameAppend = false ) {
		$name = 'Attribute' . ($nameAppend !== false ? '[' . $nameAppend . ']' : '') . '[' . $this->id . ']';
		$class = ($hasErrors ? 'error' : '');
		switch ( $this->type ) {
			case self::TYPE_TEXTAREA:
				return CHtml::textArea($name, $value, array('class' => $class));
				break;

			case self::TYPE_TEXT:
				return CHtml::textField($name, $value, array('class' => $class));
				break;

			case self::TYPE_DROPDOWN:
				return CHtml::dropDownList($name,
					$value,
					CHtml::listData($this->chars, 'title', 'title'),
					array(
					     'empty' => '',
					     'class' => $class
					));
				break;

			case self::TYPE_RADIO:
				return CHtml::radioButtonList($name,
					$value,
					CHtml::listData($this->chars, 'title', 'title'),
					array('class' => $class));
				break;

			case self::TYPE_CHECKBOX:
				return CHtml::checkBoxList($name,
					$value,
					CHtml::listData($this->chars, 'title', 'title'),
					array('class' => $class));
				break;

			case self::TYPE_RADIO_YES_NO:
				return CHtml::radioButtonList($name,
					$value,
					array(
					     0 => Yii::t('common', 'Нет'),
					     1 => Yii::t('common', 'Да')
					),
					array('class' => $class));
				break;
		}
	}
}