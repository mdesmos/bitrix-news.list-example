<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bas\Pict as Pict;


$fd = fopen($_SERVER['DOCUMENT_ROOT']."/local/templates/main/components/bitrix/news.list/contacts/script.js", 'w') or die("не удалось создать файл");
$str = '$(document).ready(function ($) {';
$str_map = '';
$IBLOCK_ID = 8;

CModule::IncludeModule('iblock');
$prop_cities = CIBlockElement::GetList(array("sort"=>"asc"), array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE"=>'Y'), false,false, array("ID", "NAME", "CODE", "PROPERTY_coords"));
while ($arC = $prop_cities->GetNext())
{
    $arrCitites[] = array($arC["ID"], $arC["NAME"], $arC["CODE"], $arC["PROPERTY_COORDS_VALUE"]);
}

?>


<div class="tabs">
    <ul class="tabs-list pt-0">
        <?foreach ($arrCitites as $key => $val):?>
            <li class="<?if($key == 0):?>active<?endif;?>"><a href="#contactTab<?=($key+1);?>"><?=$val[1]?></a></li>
            <?

            $str .=  'if ($("#map'.$val[2].'").length) {ymaps.ready(function () {mapInit("map'.$val[2].'", ['.$val[3].']);});}';
            ?>
        <?endforeach;?>
    </ul>
    <?
    $str .= 'function mapInit(mapId, mapCenterCoordinates) {
        $(".tabs").tabs();
        var zoom,
            iconImageSize,
            iconImageOffset;
        if ($(window).width() <= 767) {
            zoom = 9;
            iconImageSize = [40, 40];
            iconImageOffset = [-20, -20];
        } else {
            zoom = 11;
            iconImageSize = [66, 66];
            iconImageOffset = [-33, -33];
        }
        var myMap = new ymaps.Map(mapId, {center: mapCenterCoordinates,zoom: zoom}, {searchControlProvider: "yandex#search"}),';
    $i = 1;
    ?>


    <div class="tabs-content _mt-negative">
        <?foreach ($arrCitites as $key => $val):?>
        <div id="contactTab<?=($key+1);?>">
            <div class="tabs inner-tabs">
                <ul class="tabs-list _text-min-sm-right mobile-hidden">
                    <li class="active"><a href="#contactTab<?=($key+1);?>_1">Карта</a></li>
                </ul>
                <div id="contactTab<?=($key+1);?>_1" class="active">
                    <div class="map-wrap">
                        <div id="map<?=$val[2]?>"></div>
                    </div>
                </div>
            </div>


            <div class="tabs _max-sm-accordion">
                <ul class="tabs-list _subway-list mb-0 mobile-hidden">
                    <?$counter1 = 97;?>
                    <?foreach($arResult["ITEMS"] as $arItem):?>

                    <?if($arItem['DISPLAY_PROPERTIES']['city']['VALUE'] == $val[0]):?>
                    <?
                        if(!empty($arItem['DISPLAY_PROPERTIES']['metro']['VALUE'])) {
                            $metro = CIBlockElement::GetByID($arItem['DISPLAY_PROPERTIES']['metro']['VALUE'])->Fetch();
                        }
                        $str .= 'placemark'.$i.' = new ymaps.Placemark(['.$arItem['DISPLAY_PROPERTIES']['address']['VALUE'].'], {
                            balloonContentHeader: "'.$arItem['NAME'].'",
                            balloonContentBody: "'.$arItem['DISPLAY_PROPERTIES']['address_text']['VALUE'].'",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-'.$metro['CODE'].'@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });';
                        $i++;

                    ?>

                        
                    <?if(!empty($metro['NAME'])):?>
                    <li class="<?=($key > 0 ? '' : 'active')?>">
                        <a href="#contactTab<?=($key+1);?>_<?=chr($counter1)?>" class="subway-wrap">

                            <div class="subway-icon bg-subway-<?=$metro['CODE']?> tabs-list__subway-icon">
                                <svg class="icon icon-subway">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/i/sprite/sprite.svg#subway"></use>
                                </svg>
                            </div>
                            <span class="c-subway-<?=$metro['CODE']?>"><?=$arItem['NAME']?>
                            <?if($arItem['DISPLAY_PROPERTIES']['is_soon']['VALUE'] == 1):?>
                                <br> <span class="tabs-list__soon-text">Скоро открытие!</span>
                            <?endif;?>
                            </span>
                        </a>
                    </li>
                    <?endif;?>
                    <?endif;?>
                    <?$counter1++;?>
                    <?endforeach;?>
                </ul>

                <div class="max-sm-accordion tabs-content _bg-white">
                    <?$counter2 = 97;?>
                    <?foreach($arResult["ITEMS"] as $arItem):?>

                    <?if($arItem['DISPLAY_PROPERTIES']['city']['VALUE'] == $val[0]):?>
                    <?
                        if(!empty($arItem['DISPLAY_PROPERTIES']['metro']['VALUE'])) {
                            $metro = CIBlockElement::GetByID($arItem['DISPLAY_PROPERTIES']['metro']['VALUE'])->Fetch();
                        }
                    ?>
                    <div class="max-sm-accordion-opener _grey-bg mobile-visible">
                    <div class="subway-wrap">
                            <div class="subway-icon bg-subway-<?=$metro['CODE']?> tabs-list__subway-icon">
                                <svg class="icon icon-subway ">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/i/sprite/sprite.svg#subway"></use>
                                </svg>
                            </div><span class="c-subway-<?=$metro['CODE']?>"><?=$metro['NAME']?></span></div>
                    </div>

                        
                    <div id="contactTab<?=($key+1);?>_<?=chr($counter2)?>">
                        <?if($arItem['DISPLAY_PROPERTIES']['is_soon']['VALUE'] == 1):?>
                        <h2 class="tabs-content__title mb-0">
                        <a href="#" class="_<?=$metro['CODE']?>"><?=$arItem['NAME']?></a></h2>
                        <p class="_h3">Скоро открытие!</p>
                        <?else:?>

                        <h2 class="tabs-content__title"><a href="#" class="_purple"><?=$arItem['NAME']?></a></h2>
                        <div class="col-min-sm-7 mb-3">
                            <div class="contact-item tabs-content__contact-item">
                                <div class="contact-item__description">
                                    <dl class="contact-item__list _md">
                                        <?=(!empty($arItem['DISPLAY_PROPERTIES']['address_text']['VALUE']) ? "<dt>Адрес:</dt>
                            <dd>".$arItem['DISPLAY_PROPERTIES']['address_text']['VALUE']."</dd>" : '')?>

                            <?=(!empty($arItem['DISPLAY_PROPERTIES']['work_time']['VALUE']) ? "<dt>Режим работы:</dt>
                            <dd>".$arItem['DISPLAY_PROPERTIES']['work_time']['VALUE']."</dd>" : '')?>
                            

                            <?=(!empty($arItem['DISPLAY_PROPERTIES']['phone']['VALUE']) ? "<dt>Телефон:</dt>
                            <dd><a href='tel:".str_replace(array(" ","(",")","-"),"",$arItem['DISPLAY_PROPERTIES']['phone']['VALUE'])."' class='tel-link trackPhone'>".$arItem['DISPLAY_PROPERTIES']['phone']['VALUE']."</a></dd>" : '')?>
                                    </dl>
                                </div>

                                <?if(!empty($arItem['PREVIEW_PICTURE']['SRC'])):?>
                                <a href="<?=$arItem['DISPLAY_PROPERTIES']['tour_link']['VALUE']?>" target="_blank" class="link-3d-tour mt-0">
                                    <picture class="img-3d-tour">
                                    <?
                                    $pic = CFile::GetFileArray($arItem['PREVIEW_PICTURE']['ID']);
                                    $Webp = Pict::getResizeWebp($pic, $pic['WIDTH'], $pic['HEIGHT'], false, 90);
                                    $file = $arItem['PREVIEW_PICTURE']['SRC'];
                                ?>
                                        <source data-src="<?=$Webp['WEBP_SRC']?>" type="<?=SITE_TEMPLATE_PATH?>/i/mage/webp">
                                        <source data-src="<?=$file?>" type="<?=SITE_TEMPLATE_PATH?>/i/mage/jpg">
                                        <img data-src="<?=$file?>" alt="3d tour image" class="lazyload">
                                    </picture><span>3D-тур</span>
                                </a>
                                <?endif;?>


                            </div><a href="#appointmentPopup" class="btn _primary mobile-hidden popup-opener"><span class="btn__text">Записаться в клинику</span></a>
                        </div>
                        

                        <div class="max-sm-accordion">

                            <?if(!empty($arItem['DISPLAY_PROPERTIES']['walk']['VALUE'])):?>
                            <h3 class="max-sm-accordion-opener">
                                <a class="_text-base-dashed">Как пройти:</a></h3>
                            <div>
                                <p class="mw-md mb-2"><?=html_entity_decode($arItem['DISPLAY_PROPERTIES']['walk']['VALUE'])?></p>
                                <div class="columns mb-3">
                                    <div class="col col-min-sm-6 mobile-hidden">
                                        <div class="map-wrap _md">

                                            <div id="map<?=$arItem['CODE']?>Pedestrian"></div>
                                            <?
                                            $str_map .= 'if ($("#map'.$arItem['CODE'].'Pedestrian").length) {
                                                        ymaps.ready(function () {
                                                            mapBuildinit("map'.$arItem['CODE'].'Pedestrian", ['.$arItem['DISPLAY_PROPERTIES']['address']['VALUE'].'], ["метро '.$metro['NAME'].'", "'.$arItem['DISPLAY_PROPERTIES']['address_text']['VALUE'].'"], "pedestrian");
                                                        });
                                                    }';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col col-min-sm-6">
                                        <picture>
                                        <?
                                        $picW = CFile::GetFileArray($arItem['DISPLAY_PROPERTIES']['photo_walk']['VALUE']);
                                        $WebpW1 = Pict::getResizeWebp($picW, $picW['WIDTH']/2, $picW['HEIGHT']/2, false, 90);
                                        $WebpW2 = Pict::getResizeWebp($picW, $picW['WIDTH'], $picW['HEIGHT'], false, 90);

                                        $wf1 = Pict::resizePict($picW, $picW['WIDTH']/2, $picW['HEIGHT']/2, true, 90);
                                        $wf2 = Pict::resizePict($picW, $picW['WIDTH'], $picW['HEIGHT'], false, 90);

                                    ?>
                                            <source srcset="<?=$WebpW1['WEBP_SRC']?> 1x, <?=$WebpW2['WEBP_SRC']?> 2x" type="image/webp">
                                            <source srcset="<?=$wf1?> 1x, <?=$wf2?> 2x" type="image/png">
                                            <img src="<?=$wf1?>" alt="Contact image">
                                        </picture>
                                        <p class="pt-2 mb-0 mobile-visible"><a href="#">Посмотреть на карте</a></p>
                                    </div>
                                </div>
                            </div>
                            <?endif;?>

                            <?if(!empty($arItem['DISPLAY_PROPERTIES']['parking']['VALUE'])):?>
                            <h3 class="max-sm-accordion-opener"><a class="_text-base-dashed">Парковка</a></h3>
                            <div>
                                <div class="mw-md mb-2">
                                   <?=html_entity_decode($arItem['DISPLAY_PROPERTIES']['parking']['VALUE'])?>
                                </div>
                                <div class="columns">
                                    <div class="col col-min-sm-6">
                                        <picture>
                                        <?
                                        $picP = CFile::GetFileArray($arItem['DISPLAY_PROPERTIES']['photo_parking']['VALUE']);
                                        $WebpP1 = Pict::getResizeWebp($picP, $picP['WIDTH']/2, $picP['HEIGHT']/2, false, 90);
                                        $WebpP2 = Pict::getResizeWebp($picP, $picP['WIDTH'], $picP['HEIGHT'], false, 90);

                                        $Pf1 = Pict::resizePict($picP, $picP['WIDTH']/2, $picP['HEIGHT']/2, true, 90);
                                        $Pf2 = Pict::resizePict($picP, $picP['WIDTH'], $picP['HEIGHT'], false, 90);

                                    ?>
                                            <source srcset="<?=$WebpP1['WEBP_SRC']?> 1x, <?=$WebpP2['WEBP_SRC']?> 2x" type="image/webp">
                                            <source srcset="<?=$Pf1?> 1x, <?=$Pf2?> 2x" type="image/png">
                                            <img src="<?=$Pf1?>" alt="Contact image">
                                        </picture>
                                        <p class="pt-2 mb-0"><a target="_blank" href="/local/templates/main/i/contact/park-compres.jpg">Посмотреть фото въезда на парковку</a></p>
                                        <p class="pt-2 mb-0 mobile-visible"><a href="#">Посмотреть на карте</a></p>
                                    </div>
                                </div>
                            </div>
                            <?endif;?>

                        </div>
                        <?endif;?>
                    </div>
                    <?endif;?>
                    <?$counter2++;?>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <?endforeach;?>

    </div>
</div>


<?
$str .= 'myMap.geoObjects';
for($j=1; $j<$i; $j++)
{
    $str .= '.add(placemark'.$j.')';
}
$str .= ';';
$str .= 'myMap.behaviors.disable("drag");myMap.behaviors.disable("scrollZoom");}';
$str .= $str_map;


$str .= 'function mapBuildinit(mapId, mapCenterCoordinates, referencePoints, routingMode) {
        var multiRoute = new ymaps.multiRouter.MultiRoute({
            referencePoints: referencePoints,
            params: {
                routingMode: routingMode
            }
        }, {
            boundsAutoApply: true
        });

        var myMap = new ymaps.Map(mapId, {
            center: mapCenterCoordinates,
            zoom: 10,
        });

        // Добавляем мультимаршрут на карту.
        myMap.geoObjects.add(multiRoute);

        myMap.behaviors.disable("scrollZoom");
        if ($(window).width() <= 1025) myMap.behaviors.disable("drag");
    }
});';

fwrite($fd, $str);
fclose($fd);
?>
