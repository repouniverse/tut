<?php
/*ESTA clase es una clase derivada del modulo
 * nemmo, se ha modificad esepcialmente el action 
 * download, para controlar 
 * quien puede descargar o no un link
 * de acuerdo a unas reglas.
 * 
 * Es cierto que podemos restringir en las vistas , los enleces 
 * a las descargas mediante reglas 
 * como por ejemlo
 *  if(checkAcess('myRol'))
 *  echo Html::a('descargar',$this->file->getUrl()); 
 * // href=common/file/download?id=34
 * 
 * Pero que pasa si alguien o un usuario  por ejemplo copia este
 * enlace y lo escribe directamente en el navegador 
 * podria ver un archivo que no le corresponde
 * 
 * 
 * 
 */
namespace common\controllers;

use nemmo\attachments\models\File;
use nemmo\attachments\models\UploadForm;
use nemmo\attachments\ModuleTrait;
use frontend\modules\access\models\AccessModelPermiso;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends nemmo\attachments\controllers\FileController
{
    use ModuleTrait;

    public function actionUpload()
    {
        $model = new UploadForm();
        $model->file = UploadedFile::getInstances($model, 'file');

        if ($model->rules()[0]['maxFiles'] == 1 && sizeof($model->file) == 1) {
            $model->file = $model->file[0];
        }

        if ($model->file && $model->validate()) {
            $result['uploadedFiles'] = [];
            if (is_array($model->file)) {
                foreach ($model->file as $file) {
                    $path = $this->getModule()->getUserDirPath() . DIRECTORY_SEPARATOR . $file->name;
                    $file->saveAs($path);
                    $result['uploadedFiles'][] = $file->name;
                }
            } else {
                $path = $this->getModule()->getUserDirPath() . DIRECTORY_SEPARATOR . $model->file->name;
                $model->file->saveAs($path);
                $result['uploadedFiles'][] = $model->file->name;
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'error' => $model->getErrors('file')
            ];
        }
    }

    public function actionDownload($id)
    {
        
        $file = File::findOne(['id' => $id]);
        
        $filePath = $this->getModule()->getFilesDirPath($file->hash) . DIRECTORY_SEPARATOR . $file->hash . '.' . $file->type;
        return Yii::$app->response->sendFile($filePath, "$file->name.$file->type");
        return Yii::$app->response->xSendFile($filePath, "$file->name.$file->type");
    }

    public function actionDelete($id)
    {
        if ($this->getModule()->detachFile($id)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionDownloadTemp($filename)
    {
        $filePath = $this->getModule()->getUserDirPath() . DIRECTORY_SEPARATOR . $filename;

        return Yii::$app->response->sendFile($filePath, $filename);
    }

    public function actionDeleteTemp($filename)
    {
        $userTempDir = $this->getModule()->getUserDirPath();
        $filePath = $userTempDir . DIRECTORY_SEPARATOR . $filename;
        unlink($filePath);
        if (!sizeof(FileHelper::findFiles($userTempDir))) {
            rmdir($userTempDir);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [];
    }
}
