<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var popupcontent $popupcontent */

/* including */
$fancycsspath = $modx->getOption('popupcontent_fancycsspath');
$fancyjspath = $modx->getOption('popupcontent_fancyjspath');
$cookiejspath = $modx->getOption('popupcontent_cookiejspath');
$defaultjspath = $modx->getOption('popupcontent_defaultjspath');
$scrolltojspath = $modx->getOption('popupcontent_scrolltojspath');

$modx->regClientHTMLBlock('
        <link rel="stylesheet" type="text/css" href="'.$fancycsspath.'">
        <script src="'.$fancyjspath.'"></script>
        <script src="'.$cookiejspath.'"></script>
        <script src="'.$defaultjspath.'"></script>
        <script src="'.$scrolltojspath.'"></script>
    ');
/* end including */

$popupcontent = $modx->getService('popupcontent', 'popupcontent', MODX_CORE_PATH . 'components/popupcontent/model/', $scriptProperties);
if (!$popupcontent) {
    return 'Could not load popupcontent class!';
}
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return ;}
    if (empty($_POST['action'])) {return;}
    
    switch ($_POST['action']) {
        case 'getpopup':
            $res = '';
            $tpl = "tpl.popupcontent";
            $id = $modx->resource->get("id");
            //
                // Build query
                $c = $modx->newQuery('popupcontentItem');
                
                $c->where(['active' => 1]);
                //if($id){$c->where(['id' => $id]);}
                $c->limit(0);
                $items = $modx->getIterator('popupcontentItem', $c);
                
                // Iterate through items
                $list = [];
                
                foreach ($items as $item) {
                    $item_array = $item->toArray();
                    
                   
                    if($item_array["wheretoplay"] == "some"){
                        $ids = $item_array["wheretoplayid"];
                        $exp = explode(",",$ids);
                        foreach($exp as $ex){
                            if($id == $ex){
                                $list[] = $modx->getChunk($tpl, $item_array);
                            }
                        }
                    }else{
                        //
                        if(empty($item_array["notplayid"])){
                            $list[] = $modx->getChunk($tpl, $item_array);
                        }
                        else{
                            $notplayid = $item_array["notplayid"];
                            $npi = explode(",",$notplayid);
                            foreach($npi as $notid){
                                if($notid != $id){
                                    $list[] = $modx->getChunk($tpl, $item_array);
                                }
                            }
                        }
                        //
                        
                    }
                }
                
                // Output
                $res = implode($outputSeparator, $list);
                $res = substr($res, 0, -1);
            //
            if (!empty($res)) {
              die("[".$res."]");
            }
        break;
    }