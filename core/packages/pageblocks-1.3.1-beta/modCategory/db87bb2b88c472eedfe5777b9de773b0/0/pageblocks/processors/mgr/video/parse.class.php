<?php

class blockVideoProcessor extends modProcessor
{

    public function process()
    {

        /** @var PageBlocks $PageBlocks */
        $PageBlocks = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        $data = $this->properties['data'];
        if (empty($data)) return $this->failure($this->modx->lexicon('pb_video_url_empty'));

        $data = json_decode($data,1);
        if ($data['mediaType'] !== 'video') return $this->failure($this->modx->lexicon('pb_video_url_invalid'));

        $output = [];
        switch ($data['provider']) {
            case 'youtube':
                // https://developers.google.com/youtube/v3/getting-started
                $youtube_api_key = $this->modx->getOption('pageblocks_youtube_api_key', '', 'AIzaSyCEIe9Y_s25uaEeY3qaFjlhckdvRE1MP1M', true);
                $hash = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=".$data['id']."&key=".$youtube_api_key.""));

                // thumbnail:
                // '120x90' => 'default',
                // '320x180' => 'medium',
                // '480x360' => 'high',
                // '640x480' => 'standard',
                // '1280x720' => 'maxres',

                $output = [
                    'provider'          => 'YouTube',
                    'title'             => $hash->items[0]->snippet->title,
                    'description'       => str_replace(array("", "<br/>", "<br />"), NULL, $hash->items[0]->snippet->description),
                    'description_nl2br' => str_replace(array("\n", "\r", "\r\n", "\n\r"), NULL, nl2br($hash->items[0]->snippet->description)),
                    'thumbnail'         => $hash->items[0]->snippet->thumbnails->standard->url,
                    'thumbnail_width'   => $hash->items[0]->snippet->thumbnails->standard->width,
                    'thumbnail_height'  => $hash->items[0]->snippet->thumbnails->standard->height,
                    'video'             => "https://www.youtube.com/watch?v=" . $data['id'],
                    'embed_video'       => "https://www.youtube.com/embed/" . $data['id'],
                    'video_id'          => $data['id'],
                ];
                break;
            case 'vimeo':
                // https://developer.vimeo.com/apps
                $vimeo_api_key = $this->modx->getOption('pageblocks_vimeo_api_key', '', '33fa5d8055bba5e10bad50efd9856c52', true);
                $options = array('http' => array(
                    'method'  => 'GET',
                    'header' => 'Authorization: Bearer '.$vimeo_api_key
                ));
                $context  = stream_context_create($options);
                $hash = json_decode(file_get_contents("https://api.vimeo.com/videos/{$data['id']}",false, $context));

                // thumbnail:
                // '100x75' => 0,
                // '200x150' => 1,
                // '295x166' => 2,
                // '640x360' => 3,
                // '960x540' => 4,
                // '1280x720' => 5,
                // '1920x1080' => 6,

                $output = [
                    'provider'          => 'Vimeo',
                    'title'             => $hash->name,
                    'description'       => str_replace(array("<br>", "<br/>", "<br />"), NULL, $hash->description),
                    'description_nl2br' => str_replace(array("\n", "\r", "\r\n", "\n\r"), NULL, $hash->description),
                    'thumbnail'         => $hash->pictures->sizes[3]->link,
                    'thumbnail_width'   => $hash->pictures->sizes[3]->width,
                    'thumbnail_height'  => $hash->pictures->sizes[3]->height,
                    'video'             => $hash->link,
                    'embed_video'       => "https://player.vimeo.com/video/" . $data['id'],
                    'video_id'          => $data['id'],
                ];
                break;
            default:
                return $this->failure($this->modx->lexicon('pb_video_provider_no_support', [
                    'name' => $data['provider']
                ]));
        }

        return $this->success('', $output);
    }

}

return 'blockVideoProcessor';