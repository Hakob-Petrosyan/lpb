<?php

class PageBlocksFileUploadProcessor extends modObjectCreateProcessor
{
    public $classKey = 'blockFile';
    public $languageTopics = array('default');
//    public $permission = 'pageblocksfile_save';
    /** @var modMediaSource $mediaSource */
    public $mediaSource;
    /** @var PageBlocks $pb */
    public $pb;

    public $beforeSaveEvent = 'pbBeforeSaveImage';
    public $afterSaveEvent = 'pbAfterSaveImage';

    public $file;
    public $message = '';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        // initialize mediaSource
        if(!$this->mediaSource = $this->pb->files->getSource($this->properties['source'])) {
            return $this->modx->lexicon('pb_gallery_err_no_source', [
                'source' => $this->properties['source']
            ]);
        }

        return parent::initialize();
    }

    /**
     * Process the Object create processor
     * {@inheritDoc}
     * @return mixed
     */
    public function process()
    {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($this->message);
        }
        $this->object->fromArray($this->properties);

        /* run the before save logic */
        $canSave = $this->beforeSave();
        if ($canSave !== true) {
            return $this->failure($this->message);
        }

        /* run object validation */
        if (!$this->object->validate()) {
            /** @var modValidator $validator */
            $validator = $this->object->getValidator();
            if ($validator->hasMessages()) {
                foreach ($validator->getMessages() as $message) {
                    $this->addFieldError($message['field'],$this->modx->lexicon($message['message']));
                }
            }
        }

        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        /* save element */
        if ($this->object->save() == false) {
            $this->modx->error->checkValidation($this->object);
            return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
        }

//        $this->afterSave();
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }

    /**
     * @return bool
     */
    public function beforeSet()
    {
        if (!$this->file = $this->handleFile()) {
            if(!empty($_FILES['file']['name'])) {
                $this->message = $this->modx->lexicon('pb_gallery_filename_err_upload', [
                    'name' => $_FILES['file']['name']
                ]);
            }
            return false;
        }

        $properties = $this->mediaSource->getPropertyList();
        $info = new SplFileInfo($this->file['name']);
        $extension = strtolower($info->getExtension());
        $filename = strtolower($info->getFilename());
        $name = strtolower($info->getBasename('.' . $extension));

        $image_extensions = $allowed_extensions = array();
        if (!empty($properties['imageExtensions'])) {
            $image_extensions = array_map('trim', explode(',', strtolower($properties['imageExtensions'])));
        }
        if (!empty($properties['allowedFileTypes'])) {
            $allowed_extensions = array_map('trim', explode(',', strtolower($properties['allowedFileTypes'])));
        }
        if (!empty($allowed_extensions) && !in_array($extension, $allowed_extensions)) {
            @unlink($this->file['tmp_name']);
            return false;
        } else {
            if (in_array($extension, $image_extensions)) {
                $type = 'image';
            } else {
                $type = $extension;
            }
        }

        $this->properties['type'] = $type;
        $this->properties['name'] = $name;
        $this->properties['filename'] = $filename;
        $this->properties['extension'] = $extension;

        // Проверяем дубль
        if($this->doubleСheck()) {
            $this->message = $this->modx->lexicon('pb_gallery_filename_err_upload', [
                'name' => $filename
            ]);
            return false;
        }

        return true;
    }

    /**s
     * @return bool
     */
    public function beforeSave()
    {
        // Создаем папку
        $path = $this->pb->getSourcePath($this->properties['source_path']);
        $this->mediaSource->createContainer($path, '/');
        $this->mediaSource->errors = array();
        if ($this->mediaSource instanceof modFileMediaSource) {
            $upload = $this->mediaSource->createObject($path, $this->object->filename, file_get_contents($this->file['tmp_name']));
        } else {
            $this->file['name'] = $this->object->filename;
            $upload = $this->mediaSource->uploadObjectsToContainer($path, array($this->file));
        }
        @unlink($this->file['tmp_name']);

        if (!$upload) {
            $this->message = $this->modx->lexicon('pb_gallery_file_err_upload', [
                'name' => $this->object->filename
            ]);
            return false;
        }

        $this->object->set('path', $path);

        $url = $this->mediaSource->getObjectUrl($path . $this->object->filename);
        $url = ltrim($url, '/');
        $this->object->set('url', $url);
        $this->object->set('rank', $this->pb->files->getRank([
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'],
        ]));

        return true;

    }


    /**
     * @return array|bool
     */
    public function handleFile()
    {
        $tf = tempnam(MODX_BASE_PATH, 'pb_');

        if (!empty($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $name = $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $tf);
        } else {
            $file = $this->properties['file'];
            if (!empty($file) && (strpos($file, '://') !== false || file_exists($file))) {
                $tmp = explode('/', $file);
                $name = end($tmp);
                if ($stream = fopen($file, 'r')) {
                    if ($res = fopen($tf, 'w')) {
                        while (!feof($stream)) {
                            fwrite($res, fread($stream, 8192));
                        }
                        fclose($res);
                    }
                    fclose($stream);
                }
            }
        }

        clearstatcache(true, $tf);
        if (file_exists($tf) && !empty($name) && $size = filesize($tf)) {
            $data = array(
                'name' => $name,
                'tmp_name' => $tf,
                'properties' => array(
                    'size' => $size,
                ),
            );

            $tmp = getimagesize($tf);
            if (is_array($tmp)) {
                $data['properties'] = array_merge(
                    $data['properties'],
                    array(
                        'width' => $tmp[0],
                        'height' => $tmp[1],
                        'bits' => $tmp['bits'],
                        'mime' => $tmp['mime'],
                    )
                );
            } elseif (strpos($data['name'], '.webp') !== false) {
                $img = imagecreatefromwebp($tf);
                $width = imagesx($img);
                $height = imagesy($img);

                $data['properties'] = array_merge(
                    $data['properties'],
                    array(
                        'width' => $width,
                        'height' => $height,
                        'mime' => 'image/webp',
                    )
                );
            }
            return $data;
        } else {
            unlink($tf);
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function doubleСheck()
    {
        return $this->modx->getCount($this->classKey, [
            'resource_id' => $this->properties['resource_id'],
            'context_key' => $this->properties['context_key'],
            'cultureKey' => $this->properties['cultureKey'],
            'block_id' => $this->properties['block_id'],
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'],
            'filename' => $this->properties['filename'],
        ]);
    }

}

return 'PageBlocksFileUploadProcessor';