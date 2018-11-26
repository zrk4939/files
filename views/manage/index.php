<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $files \zrk4939\modules\files\models\File[] */
/* @var $searchModel \zrk4939\modules\files\models\FileSearch */
/* @var $pages \yii\data\Pagination */
/* @var $model \zrk4939\modules\files\forms\FilesForm */
/* @var $frame boolean */
/* @var $containerName string */

/* @var $CKEditor string */
/* @var $CKEditorFuncNum string */

/* @var $staticHost string */

$this->title = Yii::t('files', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('yii', 'View'),
                'content' => $this->render('_view', [
                    'files' => $files,
                    'searchModel' => $searchModel,
                    'pages' => $pages,
                    'frame' => $frame,
                    'CKEditor' => $CKEditor,
                    'CKEditorFuncNum' => $CKEditorFuncNum,
                    'containerName' => $containerName,
                    'staticHost' => $staticHost,
                ]),
            ],
            [
                'label' => Yii::t('files', 'Upload'),
                'content' => $this->render('_uploading', ['model' => $model]),
            ]
        ]
    ])
    ?>
</div>
