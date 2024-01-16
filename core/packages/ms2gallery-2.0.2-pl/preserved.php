<?php return array (
  'abe6b41f6a900eaec9ab269e0c964ab7' => 
  array (
    'criteria' => 
    array (
      'name' => 'tpl.ms2Gallery',
    ),
    'object' => 
    array (
      'id' => 120,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'tpl.ms2Gallery',
      'description' => '',
      'editor_type' => 0,
      'category' => 0,
      'cache_type' => 0,
      'snippet' => '<div class="ms2Gallery">
    {if $files?}
        <div class="fotorama"
             data-nav="thumbs"
             data-thumbheight="45"
             data-allowfullscreen="true"
             data-swipe="true"
             data-autoplay="5000">
            {foreach $files as $file}
                <a href="{$file[\'url\']}" target="_blank">
                    <img src="{$file[\'small\']}" alt="{$file[\'name\']}" title="{$file[\'name\']}">
                </a>
            {/foreach}
        </div>
    {else}
        <img src="{(\'assets_url\' | option) ~ \'components/ms2gallery/img/web/ms2_medium.png\'}" alt="" title=""/>
    {/if}
</div>',
      'locked' => 0,
      'properties' => NULL,
      'static' => 0,
      'static_file' => 'core/components/ms2gallery/elements/chunks/chunk.ms2gallery.tpl',
      'content' => '<div class="ms2Gallery">
    {if $files?}
        <div class="fotorama"
             data-nav="thumbs"
             data-thumbheight="45"
             data-allowfullscreen="true"
             data-swipe="true"
             data-autoplay="5000">
            {foreach $files as $file}
                <a href="{$file[\'url\']}" target="_blank">
                    <img src="{$file[\'small\']}" alt="{$file[\'name\']}" title="{$file[\'name\']}">
                </a>
            {/foreach}
        </div>
    {else}
        <img src="{(\'assets_url\' | option) ~ \'components/ms2gallery/img/web/ms2_medium.png\'}" alt="" title=""/>
    {/if}
</div>',
    ),
  ),
);