(function ($) {
  var WidgetElementorSliderHandler = function ($scope, $) {
    var carousel_elem = $scope.find(".elementor-slider").eq(0);

    if (carousel_elem.length > 0) {
      var settings = carousel_elem.data("slider_options");
      carousel_elem.slick({
        ...settings,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: true,
              centerMode: true,
              centerPadding: "30px",
              slidesToShow: 1,
            },
          },
        ],
      });
    }
  };

  // Make sure you run this code under Elementor..
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/elementor-slider.default",
      WidgetElementorSliderHandler
    );
  });
})(jQuery);
