(function () {
  var catchway = {
    config: {
      vendorUrl: '/assets/components/catchway/vendor/'
      ,cookieExpires: 30
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
    ,showModal: function (){
        $('#catchwayModal').modal()
    }
    ,whenAll: function () {
      if (jQuery().modal && catchway.cityName) {
        catchway.addListeners();
        catchway.showModal();
      }
    }
    ,addListeners: function(){
      $("#catchwayModalButtonNo").click(function () {
        $("#catchwayModalFind").fadeOut();
        $("#catchwayModalChoice").fadeIn();
      });
      $("#catchwayModalButtonYes").click(function () {
        window.location.replace('/?catchway_city=' + catchway.cityName);
      });
      $('#catchwayModal').on('hidden.bs.modal', function (e) {
        window.location.replace('/?catchway_city=default');
      });
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