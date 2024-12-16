<?php

namespace app\models;

use Yii;
use Da\QrCode\QrCode;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $full_link
 * @property string $token
 * @property int|null $counter
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['counter'], 'safe'],
            [['full_link'], 'string', 'max' => 500],
            /* Создание токена для короткой ссылки */
            [['token'], 'default', 'value' => Yii::$app->security->generateRandomString(15)],
            [['token'], 'unique'],
            [['token', 'full_link'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_link' => 'Полная ссылка',
            'token' => 'Токен',
            'counter' => 'Счетчик переходов',
        ];
    }

    /**
     * Получение короткой ссылки из токена
     * @return string
     */
    public function getShortLink()
    {
        return Yii::$app->urlManager->createAbsoluteUrl(['redirect/index', 'token' => $this->token]);
    }

    /**
     * Получение QR-кода на короткую ссылку
     * @return string
     */
    public function getQr()
    {
        return (new QrCode($this->getShortLink()))->writeDataUri();
    }
}
