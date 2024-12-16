<?php

namespace app\controllers;

use app\models\LinkEnterForm;
use app\models\Links;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Главная страница
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new LinkEnterForm();
        $result = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = Links::find()
                ->where(['full_link' => $model->content])
                ->one();

            if (!$result) {
                $result = new Links(['full_link' => $model->content]);

                try {
                    if (!$result->save()) {
                        throw new \Exception(print_r($result->errors, true));
                    }
                } catch (\Exception $e) {
                    Yii::error('Не удалось сохранить модель Links : ' . $e->getMessage());
                    $result = null;

                    $model->addError('content', 'Сервис временно недоступен, повторите попытку позднее');
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'result' => $result
        ]);
    }
}
