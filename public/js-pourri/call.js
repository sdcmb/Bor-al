;jQuery(document).ready(function($) {
  $('#infinite-slider2').infiniteSlider2({
    // general settings
    width: 100,
    height: '500',
    arrows: true,
    toggles: true,
    labels: false,

    // slide background settings
    slideBackgroundColor: [],
    slideBackgroundImage: [],

    // arrow settings
    arrowWidth: 32,
    arrowHeight: 76,
    arrowMargin: 20,
    arrowBackgroundColor: '',
    arrowBackgroundImageRight: '',
    arrowBackgroundImageLeft: '',
    arrowFill: 'rgba(0, 0, 0, 0.4)',
    arrowOpacity: 1,
    arrowAnimate: true,

    // toggle settings
    toggleShape: 'circle',
    toggleWidth: 18,
    toggleHeight: 18,
    toggleGutter: 10,
    toggleOpacity: 1,
    toggleColor: 'rgba(128, 128, 128, 0.4)',
    toggleActiveColor: 'rgba(0, 0, 0, 0.4)',
    toggleBorder: '',
    toggleActiveBorder: '',
    toggleMargin: 30,
    toggleAnimate: true,

    // label settings
    slideLabelWidth: 74,
    slideLabelHeight: 74,
    slideLabelBorderWidth: 3,
    slideLabelBorderStyle: 'solid',
    slideLabelBorderColor: 'rgba(128, 128, 128, 0.4)',
    slideActiveLabelBorderColor: 'rgba(0, 0, 0, 0.4)',
    slideLabelBackgroundColor: [],
    slideLabelImage: [],

    // advanced settings
    autoplay: true,
    slideInterval: 3000,
    slideDuration: 400,
    cursor: 'pointer'
  });
});
