<?php

/**
 * This is the model class for table "{{tasks}}".
 *
 * The followings are the available columns in table '{{tasks}}':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $project_id
 */
class Tasks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tasks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tasks}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, project_id', 'required'),
			array('project_id,done', 'numerical', 'integerOnly'=>true),
			array('name,status,deadline', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status, project_id, deadline', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
                        'done' => 'Done',
			'status' => 'Status',
			'project_id' => 'Project',
                        'deadline'=>    "Deadline"
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
                $criteria->compare('done',$this->done);
		$criteria->compare('project_id',$this->project_id);
                $criteria->compare('deadline',$this->deadline);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}