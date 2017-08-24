<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 11.08.2017
 * Time: 12:46
 */

namespace domain\modules\files\forms;


use domain\modules\files\FilesModule;
use domain\modules\files\models\File;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class FilesForm extends Model
{
    public $files_arr;
    public $files_del;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['files_arr', 'files_del'], 'each', 'rule' => ['string']],
        ];
    }

    public function saveUploadFiles()
    {
        if (!$this->validate()) {
            return false;
        }

        $result = [
            'status' => 'ok',
            'errors' => [],
        ];

        if (!empty($this->files_arr)) {
            $tempDir = Yii::getAlias('@approot') . FilesModule::getTempDirectory(); // TODO в конфиг

            foreach ($this->files_arr as $fileName) {
                $filePath = $tempDir . $fileName;

                if (file_exists($filePath) && is_file($filePath)) {
                    $info = pathinfo($filePath);
                    $uploadDir = Yii::getAlias('@approot');

                    $model = new File();
                    $model->path = current(array_slice(mb_split(str_replace('/', '\/', $uploadDir), $info['dirname']), 1, 1));  // TODO Нужно что-то получше
                    $model->filename = $info['basename'];
                    $model->status = 1;
                    $model->mime = FileHelper::getMimeType($filePath);
                    $model->filesize = filesize($filePath);

                    if (!$model->save()) {
                        $result['errors'][$fileName] = $model->getErrors();
                    }
                }
            }
        }

        return $result;
    }

}