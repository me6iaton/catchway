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
    ,setCookie: function (name, value, options) {
      options = options || {};

      if(!options.domain){
        var parts = location.hostname.split('.');
        var upperLevelDomain = parts.join('.');
        options.domain = upperLevelDomain;
      }

      var expires = options.expires;
      if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(date.getDate() + expires);
        expires = options.expires = d;
      }
      if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
      }

      value = encodeURIComponent(value);

      var updatedCookie = name + "=" + value;

      for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
          updatedCookie += "=" + propValue;
        }
      }

      document.cookie = updatedCookie;
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