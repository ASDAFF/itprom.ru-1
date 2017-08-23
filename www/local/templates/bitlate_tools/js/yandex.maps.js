function createPlacemark(params){
    return new ymaps.Placemark(params['coords'], {
        hintContent: params['title'],
        balloonContent: params['content'],
        iconContent: '<svg class="icon yandex-maps-placemark"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-placemark"></use></svg>',
    }, {
        balloonMaxWidth: 310,
    });
}

function initYmap(id, points){
    ymaps.ready(function(){
        var count = Object.keys(points).length;
        if (count) {
            var mapParams = (count == 1) ? {
                    center: points[0]['coords'],
                    zoom: 15,
                    controls: []
                } : {
                    center: [55.75, 37.61],
                    zoom: 7,
                    controls: []
                },
                map = new ymaps.Map(id, mapParams),
                geoCollection = new ymaps.GeoObjectCollection(),
                geoObject;

            for (var i in points) {
                if (points[i]['cluster'] === undefined) {
                    geoObject = createPlacemark(points[i]);
                } else {
                    var placemarks = [];
                    for (var j in points[i]['cluster']) {
                        placemarks.push(createPlacemark(points[i]['cluster'][j]));
                    }
                    geoObject = new ymaps.Clusterer({
                        clusterIconColor: colors['secondary'],
                        clusterIconContentLayout: ymaps.templateLayoutFactory.createClass('<div class="yandex-maps-cluster">$[properties.geoObjects.length]</div>')
                    });
                    geoObject.add(placemarks);
                }
                geoCollection.add(geoObject);
            }
            map.geoObjects.add(geoCollection);
            if (count > 1) {
                map.setBounds(geoCollection.getBounds());
            }
        }
    });
}