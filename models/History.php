<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $sender_user_id
 * @property int $receiver_user_id
 * @property double $amount
 * @property double $old_balance
 * @property double $new_balance
 * @property string $created_date
 *
 * @property User $senderUser
 * @property User $receiverUser
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_user_id', 'receiver_user_id', 'created_date'], 'required'],
            [['sender_user_id', 'receiver_user_id'], 'integer'],
            [['amount', 'sender_old_balance', 'sender_new_balance', 'receiver_old_balance', 'receiver_new_balance'], 'double'],
            [['amount'],'compare','compareValue'=>'0','operator'=>'>','message'=>'Amount must be greater than 0'],
            [['created_date'], 'safe'],
            [['sender_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_user_id' => 'id']],
            [['receiver_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_user_id' => 'id']],
        ];
    }
    public function greaterThanZero($attribute,$params)
   {
      if ($this->$attribute>=0)
         $this->addError($attribute, 'The amount has to be greater than 0');

    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_user_id' => 'Sender User ID',
            'receiver_user_id' => 'Receiver User ID',
            'amount' => 'Amount',
            'sender_old_balance' => 'Old Balance',
            'sender_new_balance' => 'New Balance',
            'receiver_old_balance' => 'Old Balance',
            'receiver_new_balance' => 'New Balance',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSenderUser()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivers()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_user_id']);
    }
}
