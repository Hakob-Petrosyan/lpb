<?php

class PageBlockFiles
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pp */
    public $pb;
    /** @var modMediaSource $mediaSource */
    public $mediaSource;

    public $cache;
    public $classKey = 'blockFile';


    /**
     * PageBlockFiles constructor.
     * @param modX $modx
     * @param $pageblocks
     */
    function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;
        $this->cache = $this->modx->getCacheManager();
    }


    /**
     * @param array $where
     * @return array
     */
    public function getValues(array $where = [])
    {
        $values = [];
        $files = $this->pb->getFetchAll($this->classKey, $where);
        foreach ($files as $file) {
            $values[] = [
                'name' => $file['name'],
                'title' => $file['title'],
                'description' => $file['description'],
                'path' => $file['path'],
                'filename' => $file['filename'],
                'url' => $file['url'],
                'type' => $file['type'],
                'extension' => $file['extension'],
            ];
        }

        return $values;
    }

    /**
     * @param array $where
     * @return array
     */
    public function getRows(array $where = [])
    {
        $rows = $this->pb->getCollection($this->classKey, $where);

        return $rows;
    }

    /**
     * @param array $where
     * @param array $new_data
     */
    public function copy(array $where, array $new_data = [])
    {
        $files = $this->pb->getCollection($this->classKey, $where);
        foreach ($files as $file) {
            $newFile = $this->modx->newObject($this->classKey);
            $newFile->fromArray(array_merge($file->toArray(), $new_data), '', false, true);
            $newFile->save();
        }
    }


    /**
     * @param array $where
     * @return mixed
     */
    public function remove(array $where = [])
    {
        return $this->modx->removeCollection($this->classKey, $where);
    }


    /**
     * @param string $old_path
     * @param string $new_path
     * @param int $source
     * @return bool
     */
    public function copyFiles(string $old_path, string $new_path, int $source)
    {
        // Получаем источник файлов
        if ($mediaSource = $this->modx->getObject('sources.modMediaSource', $source)) {
            $properties = $mediaSource->getPropertyList();

            // Копируем папку
            $old_path = MODX_BASE_PATH . "{$properties['baseUrl']}{$old_path}/";
            $new_path = MODX_BASE_PATH . "{$properties['baseUrl']}{$new_path}/";
            if ($this->cache->copyTree($old_path, $new_path)) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param $source
     * @param array $where
     */
    public function removeFiles($source, array $where = [])
    {
        $files = $this->modx->getCollection($this->classKey, $where);
        foreach ($files as $file) {
            $this->removeFile($source, $file->path . $file->filename);
        }
    }


    /**
     * @param $source
     * @param $objectPath
     * @return bool
     */
    public function removeFile($source, $objectPath)
    {
        if (!$mediaSource = $this->getSource($source)) {
            $this->modx->log(1, $this->modx->lexicon('pb_gallery_err_no_source', [
                'source' => $this->properties['source']
            ]));
            return false;
        }

        $properties = $mediaSource->getPropertyList();
        $objectPath = str_replace($properties['basePath'], '', $objectPath);
        if (file_exists(MODX_BASE_PATH . $properties['basePath'] . $objectPath)) {
            if (!$mediaSource->removeObject($objectPath)) {
                $this->modx->log(1, $this->modx->lexicon('pb_gallery_file_err_delete', [
                    'name' => $objectPath
                ]));
            }
        }

        return true;
    }


    /**
     * @param $source
     * @return false|modMediaSource
     */
    public function getSource($source)
    {
        $mediaSource = $this->mediaSource;
        if (!$mediaSource) {
            $mediaSource = $this->modx->getObject('sources.modMediaSource', (int) $source);
            if (!$mediaSource) {
                $this->modx->log(1, $this->modx->lexicon('pb_gallery_err_no_source', [
                    'source' => $source
                ]));
                return false;
            }

//            $mediaSource->set('ctx', 'web');
            if ($mediaSource->initialize()) {
                $this->mediaSource = $mediaSource;
            }
        }

        return $mediaSource;
    }

    /**
     * @param $object
     * @param $params
     * @param string $new_path
     * @return array|false
     */
    public function generateThumbnail($object, $params, $new_path = '')
    {
        $phpThumb = $this->modx->getService('modphpthumb','modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/');
        if (!$phpThumb) {
            $this->modx->log(1, 'Could not load phpThumb class!');
            return false;
        }

        // Получаем источник файлов
        $mediaSource = $this->getSource($object->source);
        $properties = $mediaSource->getPropertyList();

        // Создаем новую папку
        if(!empty($new_path)) {
            $mediaSource->createContainer($new_path, '/');
        } else {
            $new_path = trim($object->path, '/');
        }

        $filename = $object->name . '.' . ($params['f'] ?: $object['extension']);
        $old_file = MODX_BASE_PATH . "{$properties['baseUrl']}{$object->path}/{$object->filename}";
        $new_file = MODX_BASE_PATH . "{$properties['baseUrl']}{$new_path}/{$filename}";

        // Указываем оригинальный файл
        $phpThumb->setSourceFilename($old_file);
        // Указываем параметры
        foreach ($params as $k => $v) {
            $phpThumb->setParameter($k, $v);
        }

        // Генерируем картинку
        if(!$phpThumb->generate()) {
            $this->modx->log(1, print_r($phpThumb->debugmessages, 1));
            return false;
        }
        // Сохраняем картинку
        if (!$phpThumb->renderToFile($new_file)) {
            $this->modx->log(1, 'Could not save rendered image to'. $new_file);
            return false;
        }

        return [
            'filename' => $filename,
            'path' => $new_path . '/',
            'url' => "{$properties['baseUrl']}{$new_path}/{$filename}",
            'extension' => $params['f'],
        ];
    }


    /**
     * @param $object
     * @param $new_name
     * @return bool
     */
    public function renameFile($object, $new_name)
    {
        $mediaSource = $this->getSource($object->source);
        if (!$mediaSource->renameObject($object->path . $object->filename, $new_name . '.' . $object->extension)) {
            return false;
        }

        $object->set('url', str_replace($object->filename, $new_name . '.' . $object->extension, $object->url));
        $object->set('filename', $new_name . '.' . $object->extension);
        $object->set('name', $new_name);

        return true;
    }


    /**
     * @param $object
     * @param $to
     * @return bool
     */
    public function moveFile($object, $to)
    {
        $mediaSource = $this->getSource($object->source);
        $from = $object->path . $object->filename;

        // Если папки нет, то создаем ее
        if (!file_exists($to)) {
            $mediaSource->createContainer($to, '/');
        }

        if (!$mediaSource->moveObject($from, $to)) {
            $this->modx->log(1, print_r($mediaSource->errors,1));
            return false;
        }
        $path = trim($to, '/') . '/';
        $url = $mediaSource->getObjectUrl($path . $object->filename);
        $url = ltrim($url, '/');

        $object->set('path', $path);
        $object->set('url', $url);

        return true;
    }


    /**
     * @param $object
     * @param $format
     * @param string $new_path
     * @return bool|void
     */
    public function changeFormat($object, $format, $new_path = '')
    {
        if (empty($format)) return;

        $params = ['f' => $format];
        if (!$res = $this->generateThumbnail($object, $params, $new_path)) {
            return false;
        }

        foreach ($res as $key => $value) {
            $object->set($key, $value);
        }

        return true;
    }


    /**
     * @param $source
     * @param $source_path
     * @return mixed
     */
    public function getSourceFiles($source, $source_path)
    {
        $mediaSource = $this->getSource($source);
        $source_path = $this->pb->getSourcePath($source_path);
        $files = $mediaSource->getObjectsInContainer($source_path);

        return $files;
    }

    /**
     * @param $where
     * @return int|mixed
     */
    public function getRank($where)
    {
        return $this->pb->getRank($this->classKey, $where);
    }

}