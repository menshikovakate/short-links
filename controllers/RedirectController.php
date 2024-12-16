<?php

namespace app\controllers;

use app\models\Links;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class RedirectController
 * Контроллер обработки переходов по коротким ссылкам
 *
 * @package app\controllers
 */
class RedirectController extends Controller
{
    /**
     * @param $token
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex($token)
    {
        $model = Links::find()
            ->where(['token' => $token])
            ->one();

        if ($model) {
            /* Фиксируем в логе IP, с которого направлен запрос */
            $ip = Yii::$app->request->getUserIP();
            Yii::info($ip, 'ips');

            /* Обновляем счетчик переходов */
            try {
                Yii::$app->db->createCommand(
                    'UPDATE ' . Links::tableName() . ' SET counter = counter + 1 WHERE id = :id',
                    ['id' => $model->id]
                )->execute();
            } catch (\Exception $e) {
                Yii::error('Не удалось обновить счетчик переходов:' . $e->getMessage());
            }

            return $this->redirect($model->full_link);
        } else {
            throw new NotFoundHttpException('Ссылка недействительна');
        }
    }
}