/*
  Script: lt3 Accordion
  Version: 1
  Notes:
  - Requires jQuery 7.2.1
  - Usage: $('.accordion').lt3Accordion();
------------------------------------------------ */
(function($){
  $.extend($.fn, {
    lt3Accordion: function(){
      $speed = 300;
      $elements = $(this);
      $elements.each(function(){
        var $dl = $(this);
        var $dd = $dl.find('dd');
        $dd.filter(':nth-child(n+4)').addClass('hide');
        $dl.on('click', 'dt', function() {
          $this = $(this);
          if(!$this.hasClass('down')){
            $this.addClass('down')
              .next()
                .slideDown($speed)
                  .siblings('dd')
                    .slideUp($speed);
            $this.siblings('dt').removeClass('down');
          } else {
            $this.removeClass('down').next().slideUp($speed);
            $this.siblings('dt').removeClass('down');
          }
        });
      });
    }
  });
})(jQuery);