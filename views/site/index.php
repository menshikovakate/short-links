<?php

/** @var yii\web\View $this */
/** @var \app\models\LinkEnterForm $model */
/** @var \app\models\Links $result */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

$this->title = 'Сервис коротких ссылок + QR';
?>
<div class="site-index container">
    <?php Pjax::begin([
        'formSelector' => '#link-enter-form',
        'linkSelector' => 'a:not(.target_blank)',
    ]); ?>

    <?php $form = ActiveForm::begin(['id' => 'link-enter-form']); ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'content')
                ->textInput(['maxlength' => true, 'placeholder' => 'Ссылка'])
                ->label(false); ?>
        </div>
        <div class="col-auto">
            <?= Html::submitButton('OK', ['class' => 'btn btn-dark']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php if ($result) {
        $short = $result->getShortLink();
    ?>
        <div class="row text-center">
            <div class="col">
                <img src="<?= $result->getQr(); ?>" height="250px" width="250px">
                <p>
                    Короткая ссылка: <?= Html::a($short, $short, [
                        'target' => '_blank',
                        'class' => 'target_blank',
                    ]); ?>
                </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php Pjax::end();?>
</div>
