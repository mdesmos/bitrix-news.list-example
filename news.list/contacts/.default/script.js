$(document).ready(function ($) {if ($("#mapMoscow").length) {ymaps.ready(function () {mapInit("mapMoscow", [55.755814,37.617635]);});}if ($("#mapStPetersburg").length) {ymaps.ready(function () {mapInit("mapStPetersburg", [59.939095,30.315868]);});}if ($("#mapYekaterinburg").length) {ymaps.ready(function () {mapInit("mapYekaterinburg", [56.838011,60.597465]);});}function mapInit(mapId, mapCenterCoordinates) {
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
        var myMap = new ymaps.Map(mapId, {center: mapCenterCoordinates,zoom: zoom}, {searchControlProvider: "yandex#search"}),placemark1 = new ymaps.Placemark([55.758462862885,37.555308415344], {
                            balloonContentHeader: "Клиника на Шмитовском",
                            balloonContentBody: "Шмитовский проезд, д. 3, стр. 2",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-7@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });placemark2 = new ymaps.Placemark([55.821339378275,37.641315449737], {
                            balloonContentHeader: "Клиника на ВДНХ",
                            balloonContentBody: "СКОРО ОТКРЫТИЕ!",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-6@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });placemark3 = new ymaps.Placemark([59.906257671143,30.317832804221], {
                            balloonContentHeader: "Клиника на Фрунзенской",
                            balloonContentBody: "СКОРО ОТКРЫТИЕ!",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-3@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });placemark4 = new ymaps.Placemark([59.94455830454,30.359472590212], {
                            balloonContentHeader: "Клиника на Чернышевской",
                            balloonContentBody: "СКОРО ОТКРЫТИЕ!",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-1@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });placemark5 = new ymaps.Placemark([56.857589799524,60.599768540311], {
                            balloonContentHeader: "Клиника на Уральской",
                            balloonContentBody: "",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-2@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });placemark6 = new ymaps.Placemark([56.807684749581,60.610433138421], {
                            balloonContentHeader: "Клиника на Чкаловской",
                            balloonContentBody: "",
                        }, {
                            iconLayout: "default#image",
                            iconImageHref: "/local/templates/main/i/contact/placemark-subway-2@2x.png",
                            iconImageSize: iconImageSize,
                            iconImageOffset: [-33, -33],
                            hideIconOnBalloonOpen: false
                        });myMap.geoObjects.add(placemark1).add(placemark2).add(placemark3).add(placemark4).add(placemark5).add(placemark6);myMap.behaviors.disable("drag");myMap.behaviors.disable("scrollZoom");}if ($("#mapMoscowShmidthPedestrian").length) {
                                                        ymaps.ready(function () {
                                                            mapBuildinit("mapMoscowShmidthPedestrian", [55.758462862885,37.555308415344], ["метро Улица 1905 года", "Шмитовский проезд, д. 3, стр. 2"], "pedestrian");
                                                        });
                                                    }function mapBuildinit(mapId, mapCenterCoordinates, referencePoints, routingMode) {
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
});
