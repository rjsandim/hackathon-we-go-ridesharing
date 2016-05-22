/**
 * imagefill.js
 * Author & copyright (c) 2013: John Polacek
 * johnpolacek.com
 * https://twitter.com/johnpolacek
 *
 * Dual MIT & GPL license
 *
 * Project Page: http://johnpolacek.github.io/imagefill.js
 *
 * The jQuery plugin for making images fill their containers (and be centered)
 *
 * EXAMPLE
 * Given this html:
 * <div class="container"><img src="myawesomeimage" /></div>
 * $('.container').imagefill(); // image stretches to fill container
 *
 * REQUIRES:
 * imagesLoaded - https://github.com/desandro/imagesloaded
 *
 */
 ;(function($) {

  $.fn.imagefill = function(options) {

    var $container = this,
        imageAspect = 1/1,
        containersH = 0,
        containersW = 0,
        defaults = {
          runOnce: false,
          target: 'img',
          throttle : 50  // 20fps
        },
        settings = $.extend({}, defaults, options);
        
    var $img = $container.find(settings.target).addClass('loading').css({'position':'absolute'});

    // make sure container isn't position:static
    var containerPos = $container.css('position');
    $container.css({'overflow':'hidden','position':(containerPos === 'static') ? 'relative' : containerPos});

    // set containerH, containerW
    $container.each(function() {
      containersH += $(this).outerHeight();
      containersW += $(this).outerWidth();
    });

    // wait for image to load, then fit it inside the container
    $container.imagesLoaded().done(function(img) {
      imageAspect = $img.width() / $img.height();
      $img.removeClass('loading');
      fitImages(false);
      if (!settings.runOnce) {
        checkSizeChange();
      }
    });

    function fitImages(timeClear) {
      containersH  = 0;
      containersW = 0;
      $container.each(function() {
        imageAspect = $(this).find(settings.target).width() / $(this).find(settings.target).height();
        var containerW = $(this).outerWidth(),
            containerH = $(this).outerHeight();
        containersH += $(this).outerHeight();
        containersW += $(this).outerWidth();

        var containerAspect = containerW/containerH;
        window.myOffset = (containerH*imageAspect-containerW)/2;
        if(timeClear == false){
          if (containerAspect < imageAspect) {
            // taller
            $(this).find(settings.target).css({
                width: 'auto',
                height: containerH,
                top:0,
                left:-(containerH*imageAspect-containerW)/2
              });
          } else {
            // wider
            $(this).find(settings.target).css({
                width: containerW,
                height: 'auto',
                top:-(containerW/imageAspect-containerH)/2,
                left:0
            });
          }
        }else{
           $(this).find(settings.target).css({
                width: containerW,
                height: 'auto',
                top:0,
                left:0
              });
        }
      });
    }

    function checkSizeChange() {
      var timeClear;
      var checkW = 0,
          checkH = 0;
      $container.each(function() {
        timeClear = this.myClear;
        //console.log(this+""+timeClear);
        checkH += $(this).outerHeight();
        checkW += $(this).outerWidth();
      });
      if (containersH !== checkH || containersW !== checkW) {
        fitImages(false);
      }
      myFuckingTimeout = setTimeout(checkSizeChange, settings.throttle);
      if(timeClear == true){//Varioavel para para timeout quando conveniente
          //console.log("it is true");
          fitImages(true);
      }
    }    
    return this;
  };

}(jQuery));
