// Generated by CoffeeScript 1.9.3
(function() {
  (function($) {
    return $(function() {
      return $('.menu-toggle').click(function() {
        var $p, $t;
        $t = $(this);
        $p = $t.parent();
        if ($t.hasClass('clicked')) {
          if (!$p.hasClass('parent')) {
            return $p.addClass('clicked');
          }
        } else {
          if ($p.hasClass('clicked')) {
            return $p.removeClass('clicked');
          }
        }
      });
    });
  })(jQuery);

}).call(this);
