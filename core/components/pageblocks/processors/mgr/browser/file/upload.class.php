<?php

if (!class_exists('modBrowserFileUploadProcessor')) {
    require_once MODX_CORE_PATH . 'model/modx/processors/browser/file/upload.class.php';
}

class pageBlocksBrowserFileUploadProcessor extends modBrowserFileUploadProcessor {

    /** @var PageBlocks $pp */
    public $pb;

    public function process()
    {
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        if (!$this->getSource()) {
            return $this->failure($this->modx->lexicon('permission_denied'));
        }
        $this->source->setRequestProperties($this->getProperties());
        $this->source->initialize();
        if (!$this->source->checkPolicy('create')) {
            return $this->failure($this->modx->lexicon('permission_denied2'));
        }

        // Проверяем расширение файла
        $properties = $this->source->getPropertyList();
        $info = new SplFileInfo($_FILES[$this->properties['idFile']]['name']);
        $extension = strtolower($info->getExtension());
        $filename = $info->getFilename();
        $allowed_extensions = array();
        if (!empty($properties['allowedFileTypes'])) {
            $allowed_extensions = array_map('trim', explode(',', strtolower($properties['allowedFileTypes'])));
        }
        if (!empty($allowed_extensions) && !in_array($extension, $allowed_extensions)) {
            @unlink($this->file['tmp_name']);
            return $this->failure($this->modx->lexicon('file_err_ext_not_allowed2', [
                'ext' => $extension
            ]));
        }

        // Создаем папку
        $path = $this->pb->getSourcePath($this->properties['path']);
        $this->source->createContainer($path, '/');
        $this->source->errors = array();

        // Перемещаем файл
        $success = $this->source->uploadObjectsToContainer($path,$_FILES);

        if (empty($success)) {
            $msg = '';
            $errors = $this->source->getErrors();
            foreach ($errors as $k => $msg) {
                $this->modx->error->addField($k,$msg);
            }
            if(empty($msg)) $msg = 'Unknown error';
            return $this->failure($msg);
        }

        if($source_url = $this->source->getBaseUrl()) {
            $url = "{$source_url}{$path}{$filename}";
            $url = ltrim($url, '/');
            return $this->success('', ['url' => $url]);
        }

        return $this->failure($this->modx->lexicon('file_err_create2'));
    }

}

return  'pageBlocksBrowserFileUploadProcessor';