<?php
/**
 * DirectResize2 Plugin
 
 * Author: Stepan Prishepenko (Setest) <itman116@gmail.com>
 
 * Version: 1.1.4 (17.04.2013) Added new parameters in all lightboxes(min_width,min_height)
 * Version: 1.1.3 (17.04.2013) Fixed a bug check of imagesize
 * Version: 1.1.2 (16.04.2013) Fixed a bugs in parser html5 and html4 documents, fix css style, add FancyBox2 lightbox
 * Version: 1.0.2 (14.04.2013) Fixed a bugs in js and css paths, fix parameter style (colorbox part) in set of parameters.
 * Version: 1.0.1 (09.04.2013) Fixed a bugs in processing exception parameters
 * Version: 1.0.0 (08.04.2013) It`s must correctly work in ModX {REVO} 2.2 - 2.2.6
 
 * Events: OnWebPagePrerender
 * Required: PhpThumbOf snippet for resizing images

 * Based on: DirectResize by Adrian Cherry <github.com/apcherry/directresize>

   Description:   
		A modx revo plugin to apply the a selected image expander to any 
		images in modx Revo. The available packages are available for selection 
		via the plugin properties.

		* Highslide
		* Colorbox
		* prettyPhoto
 */
 

// if ($modx->user->get('id')!=1) {return;}
$e = &$modx->event;
// проверяем нужное событие
if ($e->name != 'OnWebPagePrerender') {return;}

$log = $modx->getOption('log', $scriptProperties,false);
// if ($modx->user->get('id')!=1) {$log=false;}
////////////////////////////////--=LOG=--///////////////////////////////////
class log{
	function __construct($modx,$debug) {
		$this->modx = &$modx;
		$this->debug = $debug; // принимает true,false
		if ($this->debug){
			$logFileName = $this->modx->event->activePlugin;
			$this->modx->setLogLevel(modX::LOG_LEVEL_INFO);
				$date = date('Y-m-d____H-i-s');  // использовать в выводе даты : - нельзя, иначе не создается лог в файл
				$this->modx->setLogTarget(array(
				   // 'target' => 'ECHO',
				   'target' => 'FILE',
				   'options' => array('filename' => "{$logFileName}_$date.log")				   
			));		
		} 
	}
	function write($info){
		if (!$this->debug){return;}
		$this->modx->log(modX::LOG_LEVEL_INFO, $info);
	}
}
$log=new log($modx,$log);	
////////////////////////////////--=LOG=--///////////////////////////////////
// $log->write(777); return;

// $modx->lexicon->load('directresize2:properties');

// $path = $modx->getOption('cache_path',$scriptProperties,'assets/components/directresize2/cache');

$thumb_key = $modx->getOption('thumb_key',$scriptProperties,''); // this parameter add in the filename of thumbnail
$thumbnail_dir = $modx->getOption('thumbnail_dir', $scriptProperties);
$thumbnail_dir = str_replace('//', '/', $thumbnail_dir);
$thumbnail_dir = str_replace(array("..","."), "", $thumbnail_dir);
if (empty($thumbnail_dir)) return;

$config_default_thumb_param = $modx->getOption('thumb_param', $scriptProperties, "
'zc'=1,'bg'='#fff','q'=80");
// 'w'=200,'h'=150,'zc'=1,'bg'='#fff','q'=70");
$config_default_thumb_param = str_replace(array("'"," "),"",$config_default_thumb_param);


// $r = $modx->getOption('method',$scriptProperties,0);
// $q_jpg = $modx->getOption('jpg_quality',$scriptProperties,85);
// $q_png = $modx->getOption('png_quality',$scriptProperties,8);

$default_thumb_path = $modx->getOption('default_thumb_path',$scriptProperties,null); // assets/images/thumbs

// if enabled then insert special JS for lighbox 
$insert_expander = $modx->getOption('insert_expander',$scriptProperties,true);
// if enabled then insert JS code of components such as: jquery.js, colorbox.js etc.
$insert_expander_js = $modx->getOption('insert_expander_js',$scriptProperties,true);
// if enabled then insert CSS code of components such as: colorbox.css, highslide.css etc.
$insert_expander_css = $modx->getOption('insert_expander_css',$scriptProperties,true);
// rewrite thubmnail image if it exist, you can off it to add speed this plugin
$rewrite_image_on_exist = $modx->getOption('rewrite_image_on_exist',$scriptProperties,false);

/*===================--THUMBNAIL PARAMETERS--====================*/
// $lightbox = $modx->getOption('enable',$scriptProperties,true);
$expander = $modx->getOption('expander',$scriptProperties,'highslide');
$lightbox_w = $modx->getOption('max_width',$scriptProperties,800);
$lightbox_h = $modx->getOption('max_height',$scriptProperties,600);

$lightbox_w_min = $modx->getOption('min_width',$scriptProperties,100);
$lightbox_h_min = $modx->getOption('min_height',$scriptProperties,100);


$slideshow = ($modx->getOption('slideshow',$scriptProperties,false))? 'true' : 'false';
$duration = $modx->getOption('slide_duration',$scriptProperties,2500);
$opacity = number_format($modx->getOption('opacity',$scriptProperties,50)/100,2);

// FancyBox2
$fb2_closeClick = $modx->getOption('fb2_closeClick',$scriptProperties,true);
$fb2_closeClick = $fb2_closeClick ? 'true' : 'false';

$fb2_closeEffect = $modx->getOption('fb2_closeEffect',$scriptProperties,'elastic');
$fb2_openEffect = $modx->getOption('fb2_openEffect',$scriptProperties,'elastic');
$fb2_openSpeed = $modx->getOption('fb2_openSpeed',$scriptProperties,150);
$fb2_closeSpeed = $modx->getOption('fb2_closeSpeed',$scriptProperties,150);
$fb2_padding = $modx->getOption('fb2_padding',$scriptProperties,0);
$fb2_autoPlay = $modx->getOption('fb2_autoPlay',$scriptProperties,false);
$fb2_autoPlay = $fb2_autoPlay ? 'true' : 'false';

$fb2_playSpeed = $modx->getOption('fb2_playSpeed',$scriptProperties,3000);


// Highslide
$captionPosition = $modx->getOption('caption_position',$scriptProperties,'below');
$hs_captionEval = $modx->getOption('caption_source',$scriptProperties,'this.thumb.alt');
$largeCaption = $modx->getOption('large_caption',$scriptProperties,120);
$hs_outlineType = $modx->getOption('outline_type',$scriptProperties,'rounded-white');
$hs_credit = $modx->getOption('hs_credit',$scriptProperties,'Highslide JS');
// Colorbox
$cb_style = $modx->getOption('style',$scriptProperties,'style1');
if (empty($cb_style)) $cb_style='style1';
$cb_transition = $modx->getOption('transition',$scriptProperties,'elastic');
// PrettyPhoto
$pp_theme = $modx->getOption('theme',$scriptProperties,'pp_default');

/*===================--EXCLUDE--====================*/
$templates = $modx->getOption('templates', $scriptProperties, '');
$exclude_templates = $modx->getOption('exclude_templates', $scriptProperties, '');
$exclude_dirs = $modx->getOption('exclude_dirs', $scriptProperties, null);	// папки исключения
if ($exclude_dirs) $exclude_dirs=explode(",",$exclude_dirs);

$exclude_dirs_suffix = $modx->getOption('exclude_dirs_suffix', $scriptProperties, "{ExChild}");	// суффикс папки исключения, при наличии, которого дочерние папки исключаются
$exclude_dirs_children = $modx->getOption('exclude_dirs_children', $scriptProperties, null);	// исключать ли дочерние директории?
$exclude_text_in_elements = $modx->getOption('exclude_text_in_elements', $scriptProperties, "noresize");	// исключает из проверки изображения которые содержат данный текст в элементах alt, class, id, tittle
$exclude_extensions = $modx->getOption('exclude_extensions', $scriptProperties, null);	// исключаем файлы с раширением ... содержащиеся в exclude_extensions, перечисленные через запятую

// подключаем собственную функцию уменьшения картинок
// require_once MODX_CORE_PATH.'components/directresize2/elements/plugins/plugin.directresize.php';
// подключаем phpthumb
require_once MODX_CORE_PATH.'model/phpthumb/phpthumb.class.php';

$o = &$modx->resource->_output; // get a reference to the output
$cur_output = $modx->resource->get('content');
$foundImage = false; // if no image found then don't insert javascript

// working only in templates
$cur_param_res_template = $modx->resource->get('template');
if (!empty($templates) and $cur_param_res_template and !in_array($cur_param_res_template, explode(',', str_replace(" ","",$templates)))){
	// если документ не попадает в шаблон то изменения не проиводятся
	// in_array($cur_param_res_template, explode(',', $templates))
	return;
}	

// exclude templates
if (!empty($exclude_templates) and $cur_param_res_template and in_array($cur_param_res_template, explode(',', str_replace(" ","",$exclude_templates)))){
	// если документ попадает в шаблон то изменения не проиводятся
	return;
}	

$output_dom=new DOMDocument();

// рабочий вариант, но при нем функция asXml() возвращает данные в ASCII
// которые никак не хотят конвертироваться в родную кодировку
// $output_dom->loadHTML('xml encoding="UTF-8">' . $cur_output);

$charset=$modx->getOption('modx_charset');
if (!$charset) $charset="UTF-8";
$cur_output="<html>
 <head>
    <meta http-equiv='content-type' content='text/html; charset={$charset}'>
  </head>
<body>{$cur_output}</body>
</html>";
$output_dom->loadHTML($cur_output);


$xml=simplexml_import_dom($output_dom); // just to make xpath more simple
$images=$xml->xpath('//img');
// print_r($images);

if (!function_exists('css_parse')) {
	function css_parse($styles){
		// parse css and get all the key:value pair styles
		$css_array = array(); // master array to hold all values
		if (isset($styles) and $styles = explode(';', strtolower($styles)) and !empty($styles)){
			foreach ($styles as $style) {
				$value = explode(':', $style);
				// build the master css array
				if (!empty($value[0]))	$css_array[$value[0]] = $value[1];
			}
		}
		return $css_array;
	}
}
// функция разбивает строку вида "'param1'='value1',..." и возвращает массив
if (!function_exists('getconfigparam')) {
	// function getconfigparam($config_default_param, $type){
	function getconfigparam($config_default_param){
		foreach (explode(",",$config_default_param) as $parametr) {
			$param_arr=explode("=",$parametr);
				// $param[$type][$param_arr[0]]=$param_arr[1];
				$param[$param_arr[0]]=$param_arr[1];
		}
		return $param;
	}
}

$count_imgs=0;

if (!empty($images)) {
	// get version modx
	$log->write("ModX version:".$modx->getOption('settings_version'));
	// приводим к общему виду все img
	$o = preg_replace('/<img\s+(([a-z]+=".*?")+\s*)>/' , "<img $1 />", $o);
}
if (strpos("<!DOCTYPE html>")) $html5=true; // в связи с различной обработкой тегов в html4 и 5 версии
// хотя можно поиграться и с normalizeDocument()

foreach ($images as $imgs) {
	$imgstring = $imgs->asXML(); // так как при этом возврате у нас происходит замена " />" на "/>" то нам нужно вернуть этот пробел иначе мы не получим замену в итоге
	if ($html5==true) {
		$imgstring=str_replace(array(' />','/>'), '>', $imgstring);
	}
	else {
		$imgstring=str_replace('/>', ' />', $imgstring);
	}

	$path_img  = $imgs['src'];   
	$id        = $imgs['id'];
	$alt       = $imgs['alt'];
	$title     = $imgs['title'];
	// $class     = explode(" ",$imgs['class']);
	$class     = $imgs['class']; /*Fix by Setest 2013-04-09*/
	
	$path_img = urldecode($path_img); // Fix by Fi1osof
	// $path_img = $path_img; // Fix by Fi1osof
	$log->write(print_r($path_img,true));
	
	if (file_exists($path_img)) {
		// echo "|".substr($path_img,0,strlen($path_base))."|".PHP_EOL;
		// echo "$path_img".PHP_EOL;
		// echo "$path_base".PHP_EOL;
		// echo "=====".PHP_EOL;
		$count_imgs++;
		$log->write("==========---IMG №{$count_imgs}---==========");
		if (strpos("{$id} {$alt} {$title} {$class}",$exclude_text_in_elements)!== false){
			$log->write("Exclude image: $path_img, because 'id', 'class', 'title' or 'id' is contains '$exclude_text_in_elements'");
			continue;
		}

		
		$img_dir=dirname($path_img);
		$path_img_full = MODX_BASE_PATH.$path_img;
// echo "@@@$path_img_full@@@";
		$img_name = pathinfo($path_img, PATHINFO_FILENAME);
		$ext = pathinfo($path_img, PATHINFO_EXTENSION);	
		// получаем конфигурацию по умолчанию
		$config_default = getconfigparam($config_default_thumb_param);	

		// проверяем исключение расширение файла exclude_extensions
		/*Fix by Setest 2013-04-09*/
		if ($exclude_extensions and $exclude_extensions=str_replace(' ', '', $exclude_extensions) and ($exclude_extensions=explode(",",$exclude_extensions)) and (in_array($ext, $exclude_extensions))){
			$log->write("except extension of file ({$ext}), return;");
			continue;	
		}
		
		// проверяем на исключения директории
		// if ($exclude_dirs and $exclude_dirs=str_replace(' ', '', $exclude_dirs) and (in_array($cur_dir,explode(",",$exclude_dirs)))){
		$excl=false;
		if ($exclude_dirs){
			// $log->write("EXCL");
			// return;
			if ($exclude_dirs_children) {
			
				foreach ($exclude_dirs as $path) {
						if (strpos($img_dir, $path) !== false) //return;
						{
							$log->write("except children, return;");
							$excl=true; break;
						}
				}
			}
			else {
				foreach ($exclude_dirs as $path) { 
					$log->write("EXCLUDE DIRS CONDITIONS: curdir ($img_dir), exclude dir ($path)");
					/*Fix by Setest 2013-04-09*/
					// так как пользователь может указать папку исключения в двух видах к примеру:
					// images/{ExChild} или images{ExChild}, то нужно это учесть
					if ((strpos($path, $exclude_dirs_suffix) !== false) && (
						strpos($img_dir, substr($path,0,-1*(strlen($exclude_dirs_suffix)))) !== false
						or
						strpos($img_dir, substr($path,0,-1*((strlen($exclude_dirs_suffix))+1))) !== false
					)) {
						// если содержит в строке &ExChild
						$log->write("except {$exclude_dirs_suffix} in: {$path}, return;");
						$excl=true; break;
					}
					else {
						if ($img_dir==str_replace($exclude_dirs_suffix, '', $path)) {
							$log->write("except dir, return;");
							$excl=true; break;
						}
					}
				// return $modx->error->failure("Записать в данную директорию нельзя она находится в исключениях плагина");
				// return $modx->error->failure("parent");
				}
			}
		}
		if ($excl==true) continue;


		// для определения реального пути дабы исключить картинки из веба realpath
		// dirname(__FILE__); basename pathinfo
		// $img = strtolower($imgstring);
		$verif_balise = sizeof(explode("width",$imgstring)) + sizeof(explode("height",$imgstring)) - 2;
		
		if (empty($verif_balise)) continue; // если нет ширины или высоты игнорируем
											// ведь эти параметры зачастую появляются при изменении высоты и ширины

		$height=(int)$imgs['height'];
		$width=(int)$imgs['width'];
		// $log->write("before: $height - $width");
		// get size from style if it exist
		if ($style=css_parse($imgs['style'])) {
			if 	((int)$style['height']>0) $height=(int)str_replace('px',"",$style['height']);
			if 	((int)$style['width']>0)  $width=(int)str_replace('px',"",$style['width']);
		}
		$log->write("image tag size: $width(w) - $height(h)");
		
		// check if the real size bigger than in HTML then create thubnail
		$real_size_of_img = getimagesize($path_img_full);
		$img_src_w  = (int)$real_size_of_img[0];
		$img_src_h  = (int)$real_size_of_img[1];
		$log->write("realsize: ".$real_size_of_img[0]." - ".$real_size_of_img[1]);
		$log->write("realsize_array: ".print_r($real_size_of_img,true));
		
		if ($img_src_w <= $width || $img_src_h <= $height) {continue;}
		
		$foundImage = true; // if needed to add ligtbox to image

		$thumb_dir = MODX_BASE_PATH.$img_dir."/".$thumbnail_dir."/";
		if ($default_thumb_path) {
			if (substr($default_thumb_path, -1, 1)!="/") $default_thumb_path.="/";
			$thumb_dir = MODX_BASE_PATH.$default_thumb_path;
		}
		$log->write("Thumbnail full path: {$thumb_dir}");
		if(!is_dir($thumb_dir)) {
			$log->write("Thumbnail dir not exist");
			if (!mkdir($thumb_dir,0755)){
				$log->write("Thumbnail error:".$modx->lexicon('dirres_error_createdir'));
				// return $modx->error->failure($modx->lexicon('dirres_error_createdir'));
			}
			else{
				$log->write("Thumbnail dir created successfull");
			}
		}
		else {
			$log->write("Thumbnail dir already exist");
		}
		// $filename = $thumb_dir.$name;
		$imgName = "{$thumb_dir}{$img_name}{$thumb_key}_w{$width}_h{$height}.{$ext}";
		
		if ($rewrite_image_on_exist or !file_exists($imgName)) {
			// old method
			// $imgName = directResize($path_img,$path,$thumb_key,$width,$height,$r,$q_jpg,$q_png);

			// new method
			// создаем объект phpThumb..
			$phpThumb = new phpThumb();
			$phpThumb->setSourceFilename($path_img_full);
			if (empty($config_default['f'])){
				$config_default['f']=$ext; // без этого мы не увидим прозрачности в png и gif
			}
			if (!empty($config_default)){
				$config_default['h']=$height;
				$config_default['w']=$width;
				$log->write("setParameter:  {$config_default_thumb_param}");
				$log->write("itogParameter: ".implode(", ",$config_default));
				foreach ($config_default as $k => $v) {
					$phpThumb->setParameter($k, $v);
				}
			}
		   
			// генерируем файл
			if ($phpThumb->GenerateThumbnail()) {
				$log->write("GenerateThumbnail - OK");
				if ($phpThumb->RenderToFile($imgName)) {
					$log->write("RenderToFile - OK");
					// устанавливаем права на файл, это опционально, зависит от сервера
					chmod($imgName, 0666);
				}
				else {
					$log->write("Error: RenderToFile: $imgName");
					continue;
				}
			}
			else {
				$log->write("Error: GenerateThumbnail");
				continue;
			}		
		}
		// возвращаем нормальный путь к файлу чтобы можно было передать его пользователю
		$imgName=str_replace(MODX_BASE_PATH, '', $imgName);
		$log->write("Itog thumb filename: $imgName");
		//-------------------
		// в этой строке происходит замена начинки src на новую ужатую картинку
		// $new_link = $path_g[0].$pathRedim.$path_d[0];
		$log->write("Replace string in output: 
			search:  {$path_img}
			replace: {$imgName}
			subject: {$imgstring}
		");
		
		$new_link = str_replace($path_img,$imgName,$imgstring);

		###############################
		// непонятная строка разобраться и что за verif_light
		// preg_match("/directresize2/",strtolower($imgstring),$verif_light);
		// if ($lightbox == 1 && $verif_light[0] == "directresize") {
		// if ($lightbox) {
		// create the expanded image legend from the title and alt tags, for colorbox and prettyPhoto
		$log->write("Create the legend for $expander");

		if ($alt <> "" || $title <> "") {
			$legende = " title=\"$alt";
			if ($alt <> "" && $title <> "") $legende .= "<br />";
			if ($title <> "") $legende .= "<span style='font-weight:normal; font-size: 9px'>$title</span>";
			$legende .= "\" ";
		} else {
			$legende = "";
		}
		// work out if the caption is large enough to go into the right hand panel
		if ($largeCaption > 0 && ( strlen($title) > $largeCaption || strlen($alt) > $largeCaption )) {
			$override = ', { captionOverlay: { position: \'rightpanel\', width: \'250px\' } }';
		} else {
			$override = '';
		}

		
		// select which expander to apply to the graphical element
		switch ($expander) {
			case "fancybox2" :
				$group="";	if ($fb2_autoPlay=='true') $group="rel='group'";
				$new_link = "<a class='fancybox2' {$group} ".$legende." href='".$path_img."' >".$new_link."</a>";
				break;		
			case "colorbox" :
				$new_link = "<a class='colorbox cboxElement' ".$legende." href='".$path_img."' >".$new_link."</a>";
				break;
			case "prettyphoto" :
				$new_link = "<a rel='prettyPhoto[[pp_gal]]' ".$legende." href='".$path_img."' >".$new_link."</a>";
				break;
			default : //use highslide as the default
				$new_link = "<a class='highslide' onclick=\"return hs.expand(this".$override.")\" href='".$path_img."' >".$new_link."</a>";
		}
		// } // end lightbox highslide test
		$log->write("Replace in output:
			ImageString: {$imgstring}
			NewLink:     {$new_link}
		");

		$o = str_replace($imgstring,$new_link,$o);
	} // end path_base test
} // end for loop

// only add style sheet and javascript if there is an image to resize
if ( $insert_expander and $foundImage ) {
	// select which expander style sheet and java script is required
	switch ($expander) {
		case "fancybox2" :
			$drStyle = "
				<link rel='stylesheet' type='text/css' href='assets/components/directresize2/fancybox2/jquery.fancybox.css?v=2.1.4' media='screen' />\n
				<link rel='stylesheet' type='text/css' href='assets/components/directresize2/fancybox2/helpers/jquery.fancybox-buttons.css?v=1.0.5' media='screen' />\n
				<link rel='stylesheet' type='text/css' href='assets/components/directresize2/fancybox2/helpers/jquery.fancybox-thumbs.css?v=1.0.7' />\n
			";
			$jsCall =  "
				<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script>
				<script type='text/javascript' src='assets/components/directresize2/fancybox2/jquery.mousewheel-3.0.6.pack.js'></script>
				<script type='text/javascript' src='assets/components/directresize2/fancybox2/jquery.fancybox.pack.js?v=2.1.4'></script>
				<script type='text/javascript' src='assets/components/directresize2/fancybox2/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>
				<script type='text/javascript' src='assets/components/directresize2/fancybox2/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>
				<script type='text/javascript' src='assets/components/directresize2/fancybox2/helpers/jquery.fancybox-media.js?v=1.0.5'></script>
			";
			$js 	=  "<script>
							jQuery('a.fancybox2').fancybox({
								padding: {$fb2_padding},

								minWidth: {$lightbox_w_min},
								minHeight: {$lightbox_h_min},

								maxWidth: {$lightbox_w},
								maxHeight: {$lightbox_h},
								
								autoPlay: {$fb2_autoPlay},
								playSpeed: {$fb2_playSpeed},

								openEffect : '{$fb2_openEffect}',
								openSpeed  : {$fb2_openSpeed},

								closeEffect : '{$fb2_closeEffect}',
								closeSpeed  : {$fb2_closeSpeed},

								closeClick : {$fb2_closeClick},

								helpers : {
									overlay : null
								}
							});
						</script>\n";
		break;	
		case "colorbox" :
			$drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize2/colorbox/".$cb_style."/colorbox.css' />\n";
			$jsCall =  "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
						<script type='text/javascript' src='assets/components/directresize2/js/jquery.colorbox-min.js'></script>";
			$js 	=  "<script>
							jQuery('a.colorbox').colorbox({
								rel:'colorbox',
								opacity:".$opacity.",
								transition:'".$cb_transition."',
								slideshow:".$slideshow.",
								slideshowSpeed:".$duration.",
								
								initialWidth: {$lightbox_w_min},
								initialHeight: {$lightbox_h_min},

								maxWidth:".$lightbox_w.",
								maxHeight:".$lightbox_w."});
						</script>\n";
		break;

		case "prettyphoto" :
			$drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize2/css/prettyPhoto.css' />\n";
			$jsCall  = "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
						<script type='text/javascript'src='assets/components/directresize2/js/jquery.prettyPhoto.js'></script>";
			$js		 = "<script>
							$(document).ready(function(){
							$(\"a[rel^='prettyPhoto']\").prettyPhoto({
								theme:'".$pp_theme."',
								default_width: {$lightbox_w},
								default_height: {$lightbox_w},
								opacity:".$opacity.",
								autoplay_slideshow:".$slideshow.",
								slideshow:".$duration."
							});});
						</script>\n";
		break;
		
		default :// default to highslide settings
			$drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize2/highslide/highslide.css' />\n";
			$jsCall  = "<script type='text/javascript' src='assets/components/directresize2/js/highslide-with-gallery.min.js'></script>";
			$js		 = "<script type='text/javascript'>
							hs.graphicsDir = 'assets/components/directresize2/highslide/graphics/'; // path to the graphical elements of highslide
							hs.outlineType = '".$hs_outlineType."';
							hs.captionEval = '".$hs_captionEval."';
							hs.captionOverlay.position = '".$captionPosition."';
							hs.dimmingOpacity = ".$opacity.";
							hs.numberPosition = 'caption';
							hs.lang.number = 'Image %1 of %2';
							hs.minWidth = {$lightbox_w_min};
							hs.minHeight = {$lightbox_h_min};
							hs.maxWidth = '".$lightbox_w."';
							hs.maxHeight = '".$lightbox_h."';
							hs.lang.creditsText = '".$hs_credit."';
						</script>\n";
			if ( $slideshow == 'true' ) {
				$js = $js."
						<script type='text/javascript'>
							hs.addSlideshow({
								interval: ".$duration.",
								repeat: false,
								useControls: true,
								fixedControls: true,
								overlayOptions: {
									opacity: ".$opacity.",
									position: 'top center',
									hideOnMouseOut: true,
								}
							});
				</script>\n";
			}
		break;
	}
	
	if ($insert_expander_css){
		$log->write("Insert expander css");

		// add the style sheet to the head of the html file
		$o = preg_replace('~(</head>)~i', $drStyle . '\1', $o);
	}
	if ($insert_expander_js){ $js=$jsCall.$js;}
	$log->write("Insert expander JS"); 
	// add the javascript to the bottom of the page 
	$o = preg_replace('~(</body>)~i', $js . '\1', $o);
	
}
return;
return;
