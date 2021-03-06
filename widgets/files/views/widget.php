<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use zrk4939\modules\files\widgets\files\assets\FilesWidgetAsset;

/* @var $this \yii\web\View */
/* @var $model \yii\db\ActiveRecord */
/* @var $attribute string */
/* @var $multiple boolean */
/* @var $files \zrk4939\modules\files\models\File[] */
/* @var array $types */
/* @var $staticHost string */

$inputName = ($multiple) ? Html::getInputName($model, $attribute) . '[]' : Html::getInputName($model, $attribute);
$inputId = Html::getInputId($model, $attribute);
$containerName = "container_{$attribute}";
$frameUrl = Url::to(['/files/manage/index', 'types' => \yii\helpers\Json::encode($types), 'frame' => true, 'containerName' => $containerName]);

FilesWidgetAsset::register($this);

echo Html::activeHiddenInput($model, $attribute, ['class' => 'modal-files-input', 'value' => '']);

$filesView = $this->render("_files", [
    'files' => $files,
    'inputName' => $inputName,
    'multiple' => $multiple,
    'staticHost' => $staticHost,
]);

echo Html::tag('div', $filesView, ['id' => $inputId . '-preview', 'class' => 'form-group']);

echo Html::a(Yii::t('files', 'Select files'), '#', [
    'id' => $inputId . '-frame',
    'class' => 'btn btn-primary',
]);

$script = <<<JS
$containerName = new filesContainer("{$frameUrl}", "{$inputId}", "{$inputName}", "{$multiple}");
JS;
$this->registerJs($script);
