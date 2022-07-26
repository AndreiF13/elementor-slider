const swiperCarousel = document.getElementById('elementor-slider-wmt'); 
const userSettings = JSON.parse(swiperCarousel.getAttribute("data-settings"));
console.log('[LOG]  -  file: app.js -  line 3 -  userSettings', userSettings);
 
const swiper = new Swiper('.elementor-slider-wrapper', {
  init: true,
  enabled: true,
  autoplay: userSettings.autoplay || 1,
  loop: userSettings.loop || 1,
  speed: userSettings.speed || 500,
  pauseOnHover: userSettings.pauseOnHover || 1,
  spaceBetween: userSettings.margin || 0,
  watchSlidesProgress: true,
  fade: userSettings.fade || false,
  effect: userSettings.effect || 'slide',
  slidesPerView: 1,
  slidesPerGroup: 1,
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    474: {
      slidesPerView: userSettings.itemsMobile || 1,
      slidesPerGroup: userSettings.slidesToShowMobile || 1,
      spaceBetween: userSettings.marginMobile || 0
    },
    // when window width is >= 480px
    992: {
      slidesPerView: userSettings.itemsTablet || 2,
      slidesPerGroup: userSettings.slidesToShowTablet || 2,
      spaceBetween: userSettings.marginTablet || 0
    },
    // when window width is >= 640px
    1280: {
      slidesPerView: userSettings.slidesToShowDesktop || 3.5,
      slidesPerGroup: userSettings.slidesToShowDesktop || 3.5,
      spaceBetween: userSettings.marginDesktop || 0
    }
  },
  dots: userSettings.dots,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
