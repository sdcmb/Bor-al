/**
 * infiniteSlider v2.0.4
 */

;(function($) {
  $.fn.infiniteSlider2 = function(options) {
    var settings = $.extend({}, $.fn.infiniteSlider2.defaults, options);
    return this.each(function() {
      var slider = $(this),
        slideQuantity = slider.children().length,
        sliderWidth = settings.width,
        sliderHeight = settings.height,
        sliderWrapperWidth = slideQuantity * 100,
        arrows = settings.arrows,
        toggles = settings.toggles,
        labels = settings.labels,

        slideBackgroundColor = settings.slideBackgroundColor,
        slideBackgroundImage = settings.slideBackgroundImage,

        arrowWidth = settings.arrowWidth,
        arrowHeight = settings.arrowHeight,
        arrowMargin = settings.arrowMargin,
        arrowBackgroundColor = settings.arrowBackgroundColor,
        arrowBackgroundImageRight = settings.arrowBackgroundImageRight,
        arrowBackgroundImageLeft = settings.arrowBackgroundImageLeft,
        arrowOpacity = settings.arrowOpacity,
        arrowFill = settings.arrowFill,
        arrowAnimate = settings.arrowAnimate,

        toggleShape = settings.toggleShape,
        toggleWidth = settings.toggleWidth,
        toggleHeight = settings.toggleHeight,
        toggleGutter = settings.toggleGutter,
        toggleOpacity = settings.toggleOpacity,
        toggleColor = settings.toggleColor,
        toggleActiveColor = settings.toggleActiveColor,
        toggleBorder = settings.toggleBorder,
        toggleActiveBorder = settings.toggleActiveBorder,
        toggleMargin = settings.toggleMargin - 10,
        togglePadding = '0 ' + toggleGutter / 2 + 'px 0',
        togglesWidth = slideQuantity * (toggleWidth + toggleGutter) + 30,
        togglesWrapperWidth = togglesWidth / 2,
        toggleAnimate = settings.toggleAnimate,

        slideLabelWidth = settings.slideLabelWidth,
        slideLabelHeight = settings.slideLabelHeight,
        slideLabelBorderWidth = settings.slideLabelBorderWidth,
        slideLabelBorderStyle = settings.slideLabelBorderStyle,
        slideLabelBorderColor = settings.slideLabelBorderColor,
        slideActiveLabelBorderColor = settings.slideActiveLabelBorderColor,
        slideLabelBackgroundColor = settings.slideLabelBackgroundColor,
        slideLabelImage = settings.slideLabelImage,

        autoplay = settings.autoplay,
        slideInterval = settings.slideInterval,
        slideDuration = settings.slideDuration,
        sliderTimer,
        cursor = settings.cursor,

        i;

      slider.children().wrapAll('<div class="inf-wrapper" data-current="0"></div>');

      var infWrapper = $('.inf-wrapper');

      infWrapper.children().addClass('inf-item');

      var infItem = $('.inf-item');

      if (slideBackgroundImage || slideBackgroundColor) {
        for (i = 0; i < slideQuantity; i++) {
          infItem.children()
            .eq(i)
            .addClass('slide-content-' + i)
            .css({
              'background-color': slideBackgroundColor[i],
              'background-image': slideBackgroundImage[i],
              'background-position': 'top center'
            });
        }
      }

      slider.css({
        'width': sliderWidth + '%',
        'margin': '0 auto',
        'position': 'relative',
        'overflow': 'hidden'
      });

      infWrapper.css({
        'width': sliderWrapperWidth + '%',
        'position': 'absolute',
        'top': 0,
        'left': 0
      });

      infItem.css({
        'display': 'block',
        'float': 'left',
        'width': infWrapper.outerWidth() / slideQuantity,
        'height': sliderHeight,
        'margin': 0
      });

      infItem.children('img').css({
        'display': 'block',
        'width': '100%',
        'height': '85%',
        'margin': 0
      });

      slider.css('height', infItem.outerHeight());

      if (arrows) {
        slider.append('<div class="inf-arrow-wrapper inf-arrow-left-wrapper"><div class="inf-arrow inf-arrow-left"></div></div><div class="inf-arrow-wrapper inf-arrow-right-wrapper"><div class="inf-arrow inf-arrow-right"></div></div>');

        var infArrowLeftWrapper = $('.inf-arrow-left-wrapper'),
          infArrowRightWrapper = $('.inf-arrow-right-wrapper'),
          infArrowWrapper = $('.inf-arrow-wrapper'),
          infArrow = $('.inf-arrow'),
          infArrowRight = $('.inf-arrow-right'),
          infArrowLeft = $('.inf-arrow-left');

        infArrowWrapper.css({
          'width': arrowWidth,
          'height': arrowHeight / 2,
          'position': 'absolute',
          'bottom': '50%'
        });

        if (arrowAnimate) {
          infArrowLeftWrapper.css({
            'left': 5,
            'opacity': 0
          });
          infArrowRightWrapper.css({
            'right': 5,
            'opacity': 0
          });
        } else {
          infArrowLeftWrapper.css({
            'left': arrowMargin,
            'opacity': arrowOpacity
          });
          infArrowRightWrapper.css({
            'right': arrowMargin,
            'opacity': arrowOpacity
          });
        }

        infArrow.css({
          'width': arrowWidth,
          'height': arrowHeight,
          'margin': 0,
          'background-color': arrowBackgroundColor,
          'cursor': cursor
        });

        if (arrowBackgroundImageRight || arrowBackgroundImageLeft) {
          infArrowRight.css({
            'margin': 0,
            'background-image': arrowBackgroundImageRight,
            'background-position': 'right center',
            'background-repeat': 'no-repeat'
          });
          infArrowLeft.css({
            'margin': 0,
            'background-image': arrowBackgroundImageLeft,
            'background-position': 'left center',
            'background-repeat': 'no-repeat'
          });
        } else {
          infArrowRight.append('<svg version="1.2" id="svg-arrow-right" class="svg-arrow svg-arrow-right" x="0px" y="0px" xml:space="preserve"><path d="M32,38.1L4.1,75.2C3.7,75.7,3.2,76,2.6,76c-1,0-1.9-0.9-1.9-1.9c0-0.4,0.1-0.7,0.4-1.1l26.2-34.9L1.1,3.2c-0.7-0.8-0.7-2,0.1-2.7c0.8-0.7,2-0.7,2.7,0.1L32,38.1z"/></svg>');
          infArrowLeft.append('<svg version="1.2" id="svg-arrow-left" class="svg-arrow svg-arrow-left" x="0px" y="0px" xml:space="preserve"><path d="M0,37.9L27.9,0.8C28.3,0.3,28.8,0,29.4,0c1,0,1.9,0.9,1.9,1.9c0,0.4-0.1,0.7-0.4,1.1L4.7,37.9l26.2,34.9c0.7,0.8,0.7,2-0.1,2.7c-0.8,0.7-2,0.7-2.7-0.1L0,37.9z"/></svg>');
          $('.svg-arrow').css({
            'width': arrowWidth,
            'height': arrowHeight,
            'fill': arrowFill
          });
        }
      }

      function bindLeftToggles() {
        var leftToggles = $('.inf-toggle-on').prevAll();
        leftToggles.each(function(indx, element) {
          var prevToggle = $(element);
          prevToggle.off('click');
          prevToggle.on('click', function() {
            for (var i = 0; i <= indx; i++) prevSlide();
          });
        });
      }

      function bindRightToggles() {
        var rightToggles = $('.inf-toggle-on').nextAll();
        rightToggles.each(function(indx, element) {
          var nextToggle = $(element);
          nextToggle.off('click');
          nextToggle.on('click', function() {
            for (var i = 0; i <= indx; i++) nextSlide();
          });
        });
      }

      function showLabels() {
        for (var j = 1; j <= slideQuantity; j++) {
          var stringToggleChild = '.inf-toggle:nth-child(' + j + ')';
          $(stringToggleChild)
            .off('mouseenter mouseleave')
            .hover(function() {
              if (!$(this).is('.inf-toggle-on')) {
                $('.slide-label-wrapper-' + $(this).index())
                  .stop()
                  .animate({
                    'opacity': 1,
                    'bottom': toggleHeight + 24
                  }, 150);
              }
            }, function() {
              $('.slide-label-wrapper-' + $(this).index())
                .stop()
                .animate({
                  'opacity': 0,
                  'bottom': toggleHeight + 17
                }, 150);
            });
        }
      }

      function bildTogglesBorder() {
        var currentSlideNumber = $('.inf-toggle-on').index() + 1;
        for (var k = 2; k <= slideQuantity + 1; k++) {
          var currentSlideLabel = '.inf-toggles-wrapper > .slide-label-wrapper:nth-child(' + k + ') > .slide-label';
          if (k === currentSlideNumber + 1) {
            $(currentSlideLabel).css('border-color', slideActiveLabelBorderColor)
              .children('.lable-triangle')
              .css('border-top-color', slideActiveLabelBorderColor);
          } else {
            $(currentSlideLabel).css('border-color', slideLabelBorderColor)
              .children('.lable-triangle')
              .css('border-top-color', slideLabelBorderColor);
          }
        }
        showLabels();
      }

      function prevSlide() {
        var currentSlide = parseInt(infWrapper.data('current'));
        currentSlide--;
        if (currentSlide < 0) {
          infWrapper.css('left', -(currentSlide + 2) * slider.outerWidth())
            .prepend(infWrapper.children().last().clone())
            .children()
            .last()
            .remove();
          currentSlide++;
        }
        infWrapper.stop()
          .animate({
            'left': -currentSlide * slider.outerWidth()
          }, slideDuration, 'swing', function() {
            $('.slide-label-wrapper-' + $('.inf-toggle-on').index())
              .stop()
              .animate({
                'opacity': 0,
                'bottom': toggleHeight + 17
              }, 150);
          })
          .data('current', currentSlide);
        infToggles.append(infToggles.children().first().clone())
          .children()
          .first()
          .remove();
        if (toggles) {
          bindLeftToggles();
          bindRightToggles();
          if (labels) bildTogglesBorder();
        }
      }

      function nextSlide() {
        var currentSlide = parseInt(infWrapper.data('current'));
        currentSlide++;
        if (currentSlide >= infWrapper.children().length) {
          infWrapper.css('left', -(currentSlide - 2) * slider.outerWidth())
            .append(infWrapper.children().first().clone())
            .children()
            .first()
            .remove();
          currentSlide--;
        }
        infWrapper.stop()
          .animate({
            'left': -currentSlide * slider.outerWidth()
          }, slideDuration, 'swing', function() {
            $('.slide-label-wrapper-' + $('.inf-toggle-on').index())
              .stop()
              .animate({
                'opacity': 0,
                'bottom': toggleHeight + 17
              }, 150);
          })
          .data('current', currentSlide);
        infToggles.prepend(infToggles.children().last().clone())
          .children()
          .last()
          .remove();
        if (toggles) {
          bindLeftToggles();
          bindRightToggles();
          if (labels) bildTogglesBorder();
        }
      }

      if (toggles) {
        slider.append('<div class=inf-toggles-wrapper><div class="inf-toggles"></div></div>');

        var infToggles = $('.inf-toggles'),
          infTogglesWrapper = $('.inf-toggles-wrapper');

        for (i = 0; i < slideQuantity; i++) {
          infToggles.append('<div class=inf-numb-' + i + '><div class="inf-toggle-shape"></div></div>')
            .children('[class^="inf-numb"]')
            .addClass('inf-toggle');
          infWrapper.children()
            .eq(i)
            .addClass('inf-slide-' + i);
        }

        var infToggleShape = $('.inf-toggle-shape');

        $('.inf-numb-0').addClass('inf-toggle-on');

        var infToggleOn = $('.inf-toggle-on');

        infTogglesWrapper.css({
          'position': 'absolute',
          'right': '50%',
          'width': togglesWrapperWidth
        });

        if (toggleAnimate) {
          infTogglesWrapper.css({
            'opacity': 0,
            'bottom': 5
          });
        } else {
          infTogglesWrapper.css({
            'opacity': 1,
            'bottom': toggleMargin
          });
        }

        var togglesPaddingTopBottom = 10,
          togglesPaddingLeftRight = 15;

        infToggles.css({
          'position': 'relative',
          'box-sizing': 'border-box',
          'width': togglesWidth,
          'height': toggleHeight + togglesPaddingTopBottom * 2,
          'margin': 0,
          'padding': togglesPaddingTopBottom + 'px ' + togglesPaddingLeftRight + 'px',
          'overflow': 'visible'
        });

        $('.inf-toggle').css({
          'position': 'relative',
          'float': 'left',
          'box-sizing': 'content-box',
          'width': toggleWidth,
          'height': toggleHeight,
          'margin': 0,
          'padding': togglePadding,
          'cursor': cursor
        });

        infToggleShape.css({
          'box-sizing': 'border-box',
          'border': toggleBorder,
          'height': '100%',
          'margin': 0,
          'background-color': toggleColor
        });

        infToggleOn.children(infToggleShape).css({
          'border': toggleActiveBorder,
          'background-color': toggleActiveColor
        });

        switch (toggleShape) {
          case 'circle':
            infToggleShape.css('border-radius', '50%');
            break;
          case 'square':
            infToggleShape.css('border-radius', 'inherit');
            break;
        }

        if (labels) {
          for (i = 0; i < slideQuantity; i++) {
            infTogglesWrapper.append('<div class="slide-label-wrapper slide-label-wrapper-' + i + '"><div class="slide-label slide-label-' + i + '"><div class="lable-triangle"></div></div></div>');
            $('.slide-label-' + i).css({
              'background-color': slideLabelBackgroundColor[i],
              'background-image': slideLabelImage[i],
              'background-position': 'center center',
              'background-repeat': 'no-repeat'
            });
          }
          var slideLabelWrapperLeft = togglesPaddingLeftRight + (toggleWidth + toggleGutter - slideLabelWidth) / 2;
          for (i = 0; i < slideQuantity; i++) {
            $('.slide-label-wrapper-' + i).css({
              'position': 'absolute',
              'bottom': toggleHeight + 17,
              'left': slideLabelWrapperLeft + (i * (toggleGutter + toggleWidth)),
              'opacity': 0
            });
          }
          $('.slide-label').css({
            'position': 'relative',
            'width': slideLabelWidth,
            'height': slideLabelHeight,
            'box-sizing': 'border-box',
            'border-width': slideLabelBorderWidth,
            'border-style': slideLabelBorderStyle,
            'border-color': slideLabelBorderColor,
            'border-radius': '50%'
          });
          if (slideLabelBorderWidth) {
            var lableTriangleWidth = 6,
              lableTriangleHeight = 10,
              toggleBorderFloat = parseFloat(slideLabelBorderWidth) || 0;
            $('.lable-triangle').css({
              'display': 'block',
              'box-sizing': 'border-box',
              'position': 'absolute',
              'bottom': -lableTriangleHeight - toggleBorderFloat,
              'left': ((slideLabelWidth - lableTriangleWidth) / 2) - toggleBorderFloat,
              'content': " ",
              'margin': 'auto',
              'width': 0,
              'height': 0,
              'border-top-width': '10px',
              'border-top-style': 'solid',
              'border-top-color': slideLabelBorderColor,
              'border-left': '3px solid transparent',
              'border-right': '3px solid transparent'
            });
          }
          var currentSlideNumber = infToggleOn.index() + 1,
            stringCurrentSlideLabel = '.inf-toggles-wrapper > .slide-label-wrapper:nth-child(' + (currentSlideNumber + 1) +') > .slide-label',
            currentSlideLabel = $(stringCurrentSlideLabel);
          currentSlideLabel.css('border-color', slideActiveLabelBorderColor)
            .children('.lable-triangle')
            .css('border-top-color', slideActiveLabelBorderColor);
          bildTogglesBorder();
        }
      }

      slider.hover(function() {
        if (autoplay) clearInterval(sliderTimer);
        if (arrows && arrowAnimate) {
          infArrowLeftWrapper.stop()
            .animate({
              'left': arrowMargin,
              'opacity': arrowOpacity
            }, 200);
          infArrowRightWrapper.stop()
            .animate({
              'right': arrowMargin,
              'opacity': arrowOpacity
            }, 200);
        }
        if (toggles && toggleAnimate) {
          infTogglesWrapper.stop()
            .animate({
              'opacity': toggleOpacity,
              'bottom': toggleMargin
            }, 200);
        }
      }, function() {
        if (autoplay) sliderTimer = setInterval(nextSlide, slideInterval);
        $(this).unbind('mousemove');
        if (arrows && arrowAnimate) {
          infArrowLeftWrapper.stop()
            .animate({
              'left': 5,
              'opacity': 0
            }, 200);
          infArrowRightWrapper.stop()
            .animate({
              'right': 5,
              'opacity': 0
            }, 200);
        }
        if (toggles && toggleAnimate) {
          infTogglesWrapper.stop()
            .animate({
              'opacity': 0,
              'bottom': 5
            }, 200);
        }
      });

      infArrowRight.on('click', function() {
        nextSlide();
      });

      infArrowLeft.on('click', function() {
        prevSlide();
      });

      if (toggles) {
        bindRightToggles();
        bindLeftToggles();
      }

      slider.on('mousemove', function() {
        infArrowLeftWrapper.css({
          'opacity': arrowOpacity,
          'left': arrowMargin
        });
        infArrowRightWrapper.css({
          'opacity': arrowOpacity,
          'right': arrowMargin
        });
        infTogglesWrapper.css({
          'opacity': toggleOpacity,
          'bottom': toggleMargin
        });
        slider.unbind('mousemove');
      });

      $(window).resize(function() {
        if (autoplay) clearInterval(sliderTimer);
        var sliderWidth = slider.outerWidth(),
          infWrapperLeft = -parseInt(infWrapper.data('current') * sliderWidth),
          infWrapperWidth = sliderWidth * slideQuantity;
        infWrapper.filter(':animated').stop(true, true);
        infWrapper.css({
          'width': infWrapperWidth,
          'left': infWrapperLeft
        }).children().css('width', infWrapper.outerWidth() / slideQuantity);
        slider.css('height', infWrapper.children(':first-child').outerHeight());
      });
    });
  };

  $.fn.infiniteSlider2.defaults = {
    // general defaults
    width: 100,
    height: 'auto',
    arrows: true,
    toggles: true,
    labels: true,

    // slide background defaults
    slideBackgroundColor: [],
    slideBackgroundImage: [],

    // arrow defaults
    arrowWidth: 32,
    arrowHeight: 76,
    arrowMargin: 20,
    arrowBackgroundColor: '',
    arrowBackgroundImageRight: '',
    arrowBackgroundImageLeft: '',
    arrowFill: 'white',
    arrowOpacity: 0.4,
    arrowAnimate: true,

    // toggle defaults
    toggleShape: 'circle',
    toggleWidth: 16,
    toggleHeight: 16,
    toggleGutter: 8,
    toggleOpacity: 1,
    toggleColor: '',
    toggleActiveColor: '',
    toggleBorder: '3px solid rgba(255, 255, 255, 0.4)',
    toggleActiveBorder: '3px solid white',
    toggleMargin: 30,
    toggleAnimate: true,

    // label defaults
    slideLabelWidth: 74,
    slideLabelHeight: 74,
    slideLabelBorderWidth: 3,
    slideLabelBorderStyle: 'solid',
    slideLabelBorderColor: 'rgba(255, 255, 255, 0.4)',
    slideActiveLabelBorderColor: 'white',
    slideLabelBackgroundColor: [
      '#2e2432',
      '#cca27e',
      '#7e4c39',
      '#83595e',
      '#2e2432'
    ],
    slideLabelImage: [],

    // advanced defaults
    autoplay: false,
    slideInterval: 6000,
    slideDuration: 600,
    cursor: 'pointer'
  }
})(jQuery);
