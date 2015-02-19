(function () {
  var catchway = {
    config: {
      vendorUrl: '/assets/components/catchway/vendor/'
    }
    ,cityName: ''
    ,getCityName: function(){
      ymaps.ready(function () {
        // Данные о местоположении, определённом по IP
        ymaps.geolocation.get({
          // Выставляем опцию для определения положения по ip
          provider: 'yandex'
          , autoGeocode: true
        }).then(function (result) {
          catchway.cityName = result.geoObjects.get(0).properties.getAll().name;
          catchway.whenAll();
        });
      });
    }
    ,showModal: function(){
      console.log('showModal')
      $('#catchwayModal').modal()
    }
    ,whenAll: function () {
      if (jQuery().modal && catchway.cityName) {
        catchway.showModal()
      }
    }
  };


  curl('js!http://api-maps.yandex.ru/2.1/?lang=ru_RU').then(function(){
    catchway.getCityName();
  });
  if (typeof jQuery == "undefined") {
    curl('js!' + catchway.config.vendorUrl + 'jquery/dist/jquery.min.js').then(function () {
      curl('js!' + catchway.config.vendorUrl + 'bootstrap/js/modal.js').then(function(){
        catchway.whenAll();
      })
    })
  } else {
    if (!jQuery().modal) {
      curl('js!' + catchway.config.vendorUrl + 'bootstrap/js/modal.js').then(function () {
        catchway.whenAll();
      })
    }
  }


})();