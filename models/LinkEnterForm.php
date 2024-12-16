<?php

namespace app\models;

use yii\base\Model;

/**
 * Class LinkEnterForm
 * Форма ввода ссылки для перобразования
 *
 * @package app\models
 */
class LinkEnterForm extends Model
{
    /** @var $content string Содержимое ссылки */
    public $content;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['content'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['content'], 'string', 'max' => 500, 'tooLong' => 'Длина ссылки не должна превышать 500 символов'],
            [['content'], 'url', 'message' => 'Данный URL невалиден'],
            [['content'], function ($attribute, $params) {
                try {
                    $available = file_get_contents($this->$attribute, false, null, 0, 1);
                } catch (\Exception $e) {
                    $available = false;
                }

                if ($available === false) $this->addError($attribute, 'Данный URL недоступен');
            }]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'content' => 'Ссылка'
        ];
    }
}