$(function () {
  $("body").on("click.bslink",".basket-count, .basket-info", function(){
    location.href = $("#bs-link").attr("href");
  });
  $('.tablebodytext').detach();
  $('.drop-nav').each(function () {
    $(this).css('left', -9999).show();
    var _w = 0;
    $(this).find('.col').each(function () {
      _w += $(this).outerWidth(true);
    });
    $(this).removeAttr('style').width(_w + 27);
  });
  $('.place .link-place').click(function () {
    popupbg();
    $('.input-block').removeClass('active');
    $('.input-block .popup-input').removeAttr('style');
    $('.block-feedback').removeClass('active');
    $('body > .bg').fadeIn(300);
    $('.place').addClass('active');
    return false;
  });
  $('.place .btn-close-type01, .input-block .btn-close-type01, body > .bg, .block-feedback .btn-close-type01').click(function (e) {
    $('body > .bg').fadeOut(300);
    $('.place, .input-block, .block-feedback').removeClass('active');
    $('.input-block .popup-input').removeAttr('style');
    e.preventDefault();
  });
  $('.input-block .link-input').click(function () {
    popupbg();
    $('.place').removeClass('active');
    $('.block-feedback').removeClass('active');
    $('body > .bg').fadeIn(300);
    $('.input-block').addClass('active');
    return false;
  });
  $('.input-block .popup-enter .row-link .align-left').click(function () {
    $('.input-block .popup-enter').hide();
    $('.input-block .popup-registration').show();
    return false;
  });
  $('.input-block .popup-enter .row-link .align-right').click(function () {
    $('.input-block .popup-enter').hide();
    $('.input-block .popup-password').show();
    return false;
  });
  $('.input-block .popup-password .row-link a').click(function () {
    $('.input-block .popup-password').hide();
    $('.input-block .popup-enter').show();
    return false;
  });
  $('.input-block .link-authorized').click(function () {
    popupbg();
    $('.bg').fadeIn(300);
    $('.popup-authorized').show();
    $('.input-block').addClass('active');
    return false;
  });
  $('.block-feedback .link-feedback, .link-question').click(function () {
    popupbg();
    if ($(this).hasClass("link-question")) {
      var ware = $(".popup-feedback").find(".messages-qware").text();
      ware += $(this).parent().parent().parent().find(".description a").text();
      $(".popup-feedback").find("#message").val();
    }
    $('.input-block').removeClass('active');
    $('.input-block .popup-input').removeAttr('style');
    $('.place').removeClass('active');
    $('body > .bg').fadeIn(300);
    $('.block-feedback').addClass('active');
    return false;
  });

  /*Слайдер на главной ---------------------------*/
	if($('.slider').length) {
		$(window).on('load', function() {
		$('.slider').tilesSlider({
			x: 20,
  			y: 1,
			effect: 'up',
			bullets: false,
			backReverse: true,
			rewind: 80,
			auto: true,
			loop: true
		});
		});
		$('.slider').hover(function(){
			$('.slider').tilesSlider('stop');
		},
		function(){
			$('.slider').tilesSlider('start');
		});
		$('body').on('click', '.tiles-wrap-current', function(){
			var desc=$('.slider').find('.tiles-description-active a');
			var myLink=desc.attr('href');
			location.href = myLink;
		});
	}

  /*Разбиваем цену на разряды ---------------------------------------*/
  if ($('.my-digit').length) {
    var myOptions = {
      thousand: " "
    }
    $('.my-digit').each(function () {
      myLength = $(this).text();
      if (myLength.length > 4) {
        myLength = accounting.formatNumber(myLength, myOptions);
        $(this).text(myLength);
      }
    });
  }

  $('.scroll-pane').each(function () {
    $(this).jScrollPane();
    var api = $(this).data('jsp');
    var throttleTimeout;
    $(window).bind('resize', function () {
      $('.main-frame-type02 .scroll-pane').height(40 + (($('#content').height() > $('#sidebar').height()) ? $('#content').height() : $('#sidebar').height()));
      if (!throttleTimeout) {
        throttleTimeout = setTimeout(
          function ()
          {
            api.reinitialise();
            throttleTimeout = null;
          }, 50
          );
      }
    });
    $('.tab-list li a').on('click', function (e) {
      setTimeout(function () {
        api.scrollTo(0, 0);
        api.reinitialise();
      }, 50);
      e.preventDefault();
    });
    $(window).load(function () {
      $('.main-frame-type02 .scroll-pane').height(40 + (($('#content').height() > $('#sidebar').height()) ? $('#content').height() : $('#sidebar').height()));
      setTimeout(function () {
        api.reinitialise();
      }, 50);
    });
  });
  $('.tab-list2 li a').on('click', function (e) {
    if ($(this).is('.active'))
      return false;
    $(this).closest('.tab-list').find('.active').removeClass('active');
    $(this).addClass('active');
    $(this).closest('.tabset').children('.tab-holder').find('.tab.active').removeClass('active');
    $(this).closest('.tabset').children('.tab-holder').find('.tab').eq($(this).parent().index()).addClass('active');
  });
  $('.tab-list li a').on('click', function (e) {
    $(".tab-list li a").removeClass("active");
    $(this).addClass("active");
    var selector = '.' + $(this).data('selector');
    $('.pCat li').not(selector).addClass('myHide');
    $('.pCat').find(selector).removeClass('myHide').fadeIn(300);
    e.preventDefault();
  });
  $(window).scroll(function () {
    if ($(window).scrollTop() > 200) {
      $('.link-top-hold').addClass('active');
    } else {
      $('.link-top-hold').removeClass('active');
    }
  });
  $('.link-top-hold .link-top').click(function () {
    $('body, html').animate({scrollTop: 0}, 800);
    return false;
  });
  $('.gallery-vertical').vgalleryScroll();
  $('.gallery-vertical ul li a').click(function (e) {
    var _this = $(this);
    _this.closest('ul').find('li.active').removeClass('active');
    _this.parent().addClass('active');
    var _img_hold = $('.gallery-vertical-hold .visual');
    _img_hold.find('img').addClass('active');
    var image = new Image();
    image.onload = function () {
      _img_hold.append('<img class="next1" style="display:none;" src="' + _this.attr('href') + '" alt=""/>');
      _img_hold.find('.active').hide(0, function () {
        $(this).remove();
      });
      _img_hold.find('.next1').fadeIn(300, function () {
        $(this).removeClass('next1');
      });
    }
    image.src = $(this).attr('href');
    e.preventDefault();
  });

  $(window).on('load', function () {
    if ($('.hold .visual').length) {
		verticalAlign('.hold:not(".brand-block") .visual:not(".noAlign")', 'img:not(".noAlign")');
		  /*Выравниваем картинки брендов в блоке */
		verticalAlign('.brand-block', 'img');
    }
  });


  $('.btn-show').click(function () {
    $(this).closest('.btn-row').prev().slideDown(500);
    $(this).fadeOut(250);
    return false;
  });
  $('.phone-input').mask('+7 (999) 999-99-99');
  $('.more').click(function () {
    $(this).prev().slideToggle(300);
    $(this).toggleClass('active');
    return false;
  });
  $('.btn-basket').click(function () {
    if (!$(this).hasClass('active')) {
      $(this).addClass('active');
      return false;
    }
  });
	$(window).on('load', function() {
		if($('.main-frame-type03').length && $('.aside').length) {
			$('.aside').height($('.main-frame-type03').height());
		}
    });
  $(window).scroll(function () {
    _ws = $(window).scrollTop();
    _all_ws = $(document).height() - $(window).height();
    if (_ws > 330) {
      $('.aside .topics').addClass('fixed');
    }
	else {
      $('.aside .topics').removeClass('fixed');
    }
	  if((_ws + $('.aside .topic-block:visible').height()) > $('.info-wrapper').offset().top)  {
			$('.aside .topics').addClass('fixed-bottom');
		}
	  else {
		$('.aside .topics').removeClass('fixed-bottom');
	  }
    if (_ws < _all_ws / 3) {
      $('.aside .topics .topic-block').eq(1).fadeOut(300);
      $('.aside .topics .topic-block').eq(2).fadeOut(300);
      $('.aside .topics .topic-block').eq(0).fadeIn(300);
    } else if ((_ws >= _all_ws / 3) && (_ws < _all_ws / 3 * 2)) {
      $('.aside .topics .topic-block').eq(0).fadeOut(300);
      $('.aside .topics .topic-block').eq(2).fadeOut(300);
      $('.aside .topics .topic-block').eq(1).fadeIn(300);
    } else {
      $('.aside .topics .topic-block').eq(0).fadeOut(300);
      $('.aside .topics .topic-block').eq(1).fadeOut(300);
      $('.aside .topics .topic-block').eq(2).fadeIn(300);
    }
  });
  /*Auto-width dropdown-menu*/
  var conWidth = $("#nav").width(),
          dd2cWidth = Math.ceil(conWidth * 0.452),
          dd3cWidth = Math.ceil(conWidth * 0.678),
          navWidth = $('#nav').outerWidth();
  var otherWidth = 0;
  $('#nav > li:not(".last-child")').each(function () {
    otherWidth += $(this).width();
  });
  $('.last-child').width(navWidth - otherWidth);
  $(".dd3c").width(dd3cWidth);
  $(".dd2c").width(dd2cWidth).css({'z-index': 1500, 'width': dd2cWidth});
//	alert("pbWidth =" + pbWidth + "\n" + "dd3c =" + dd3cWidth);
  $(window).on('resize', function () {
    conWidth = $("#nav").width();
    dd2cWidth = Math.ceil(conWidth * 0.452);
    dd3cWidth = Math.ceil(conWidth * 0.678);
    $(".dd3c").width(dd3cWidth);
    $(".dd2c").css("{'z-index': 1500, 'width' : " + dd2cWidth + "}");
    navWidth = $('#nav').outerWidth();
    var otherWidth = 0;
    $('#nav > li:not(".last-child")').each(function () {
      otherWidth += $(this).width();
    });
    $('.last-child').width(navWidth - otherWidth - 1);
  });
  /* Cart-add animation */
  $('.link-basket, .add-basket').on('click', function (event) {
    if($(this).hasClass("no-animation")) return true;
    var cartX = Math.ceil($(".basket-footer").offset().left),
        cartY = Math.ceil($(".basket-footer").offset().top); //cart coordinates
    var offsetX, offsetY;
    offsetX = Math.ceil($(this).offset().left);
    offsetY = Math.ceil($(this).offset().top);	//current button coordinates
    var virtBtn;
    if ($(this).is('.link-basket')) {
      virtBtn = '#virtual';
    }
    else {
      virtBtn = "#virtual2";
    }
    $(virtBtn).css({"left": offsetX + "px", "top": offsetY + "px"}).show(1).delay(1).queue(function () {
      $(virtBtn).css({"top": cartY, "left": cartX, 'opacity': 0, 'transform': 'scale(0.3,0.3)'}).delay(800).queue(function () {
        $(virtBtn).css({"top": 0, "left": 0, 'opacity': 1, 'transform': 'scale(1,1)'}).hide(1);
        $("#addCart").fadeIn(600).delay(1500).fadeOut(400);
        $(".basket-footer > .text").text('1').addClass('basket-count');
        $(".basket-info").fadeIn(150);
        $(this).dequeue();
      });
      $(this).dequeue();
    });
    event.preventDefault();
  });
  /* Favorite Add & Sravnenie */
  $(".srav, .fav").on('change', function () {
    countAnimate(this);
  });

  if ($('.myProdCat').length) {
    $(window).on('load', function () {
      similarHeights('.myProdCat .hold');
      verticalAlign('.myProdCat .hold', 'h2');
    });
  }

  if ($('.leftmenu').length) {
    var colHeight = $('.leftmenu #nav').height() - 36;
    $('.drop-nav .col').height(colHeight);
  }

  /* Zatemnenie pri navedenii na menu */
  $("#nav").hover(function () {
      popupbg();
      $('.bg2').fadeIn(300);
    },
    function () {
      $('.bg2').clearQueue().fadeOut(300);
  });

  /*Obrabotka dop. options v kartochke tovara */
  $(".options input").on('change', optionsClicked());

  /* Tooltips */
  $('.tooltip-wrapper').hover(function () {
      $(this).find('.tooltip').fadeIn(200);
    },
    function () {
      $(this).find('.tooltip').hide();
  });

  $(".small-text a").on("click", function () {
    $(".popup-feedback").find("#message").val($(".popup-feedback").find(".messages-caller").text());
    $(".link-feedback").click();
    return false;
  });
});
function popupbg() {
  var heightSh = 0;
  $(".wrapper").each(function () {
    heightSh += $(this).outerHeight();
  });
  heightSh += $('#header').outerHeight() + $('.footer-row').outerHeight();
  $("body > .bg").css("height", heightSh);
  $("body > .bg2").css("height", heightSh);
}
jQuery.fn.vgalleryScroll = function (_options) {
  var _options = jQuery.extend({
    btPrev: 'a.prev',
    btNext: 'a.next',
    holderList: '.gallery',
    scrollElParent: 'ul',
    scrollEl: ' li',
    slideNum: '.switcher',
    duration: 300,
    step: 1,
    circleSlide: true,
    disableClass: 'disable',
    funcOnclick: null,
    autoSlide: false,
    innerMargin: 0,
    stepHeight: false
  }, _options);
  return this.each(function () {
    var _this = jQuery(this);
    var _holderBlock = jQuery(_options.holderList, _this);
    var _gHeight = _holderBlock.height();
    var _animatedBlock = jQuery(_options.scrollElParent, _holderBlock);
    var _liHeight = jQuery(_options.scrollEl, _animatedBlock).outerHeight(true);
    var _liSum = jQuery(_options.scrollEl, _animatedBlock).length * _liHeight;
    _liSum -= parseInt(jQuery(_options.scrollEl, _animatedBlock).css('margin-bottom'));
    var _margin = -_options.innerMargin;
    _animatedBlock.css("margin-top", 0);
    var f = 0;
    var _step = 0;
    var _autoSlide = _options.autoSlide;
    var _timerSlide = null;
    if (!_options.step)
      _step = _gHeight;
    else
      _step = _options.step * _liHeight;
    if (_options.stepHeight)
      _step = _options.stepHeight;

    if (!_options.circleSlide) {
      if (_options.innerMargin == _margin)
        jQuery(_options.btPrev, _this).addClass('prev-' + _options.disableClass);
    }
    if (_options.slideNum && !_options.step) {
      var _lastSection = 0;
      var _sectionHeight = 0;
      while (_sectionHeight < _liSum)
      {
        _sectionHeight = _sectionHeight + _gHeight;
        if (_sectionHeight > _liSum) {
          _lastSection = _sectionHeight - _liSum;
        }
      }
    }
    if (_autoSlide) {
      _timerSlide = setTimeout(function () {
        autoSlide(_autoSlide);
      }, _autoSlide);
      _animatedBlock.hover(function () {
        clearTimeout(_timerSlide);
      }, function () {
        _timerSlide = setTimeout(function () {
          autoSlide(_autoSlide)
        }, _autoSlide);
      });
    }
    jQuery(_options.btNext, _this).unbind('click');
    jQuery(_options.btPrev, _this).unbind('click');
    jQuery(_options.btNext, _this).bind('click', function (e) {
      jQuery(_options.btPrev, _this).removeClass('prev-' + _options.disableClass);
      if (!_options.circleSlide) {
        if (_margin + _step > _liSum - _gHeight - _options.innerMargin) {
          if (_margin != _liSum - _gHeight - _options.innerMargin) {
            _margin = _liSum - _gHeight + _options.innerMargin;
            jQuery(_options.btNext, _this).addClass('next-' + _options.disableClass);
            _f2 = 0;
          }
        } else {
          _margin = _margin + _step;
          if (_margin == _liSum - _gHeight - _options.innerMargin) {
            jQuery(_options.btNext, _this).addClass('next-' + _options.disableClass);
            _f2 = 0;
          }
        }
      } else {
        if (_margin + _step > _liSum - _gHeight + _options.innerMargin) {
          if (_margin != _liSum - _gHeight + _options.innerMargin) {

            _margin = _liSum - _gHeight + _options.innerMargin;
          } else {
            _f2 = 1;
            _margin = -_options.innerMargin;

          }
        } else {
          _margin = _margin + _step;
          _f2 = 0;
        }
      }

      _animatedBlock.animate({marginTop: -_margin + "px"}, {queue: false, duration: _options.duration});

      if (_timerSlide) {
        clearTimeout(_timerSlide);
        _timerSlide = setTimeout(function () {
          autoSlide(_options.autoSlide)
        }, _options.autoSlide);
      }

      if (_options.slideNum && !_options.step)
        jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this), _gHeight, _lastSection);
      if (jQuery.isFunction(_options.funcOnclick)) {
        _options.funcOnclick.apply(_this);
      }
      e.preventDefault();
    });
    var _f2 = 1;
    jQuery(_options.btPrev, _this).bind('click', function (e) {
      jQuery(_options.btNext, _this).removeClass('next-' + _options.disableClass);
      if (_margin - _step >= -_step - _options.innerMargin && _margin - _step <= -_options.innerMargin) {
        if (_f2 != 1) {
          _margin = -_options.innerMargin;
          _f2 = 1;
        } else {
          if (_options.circleSlide) {
            _margin = _liSum - _gHeight + _options.innerMargin;
            f = 1;
            _f2 = 0;
          } else {
            _margin = -_options.innerMargin
          }
        }
      } else if (_margin - _step < -_step + _options.innerMargin) {
        _margin = _margin - _step;
        f = 0;
      }
      else {
        _margin = _margin - _step;
        f = 0;
      }
      ;

      if (!_options.circleSlide && _margin == _options.innerMargin) {
        jQuery(this).addClass('prev-' + _options.disableClass);
        _f2 = 0;
      }

      if (!_options.circleSlide && _margin == -_options.innerMargin)
        jQuery(this).addClass('prev-' + _options.disableClass);
      _animatedBlock.animate({marginTop: -_margin + "px"}, {queue: false, duration: _options.duration});

      if (_options.slideNum && !_options.step)
        jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this), _gHeight, _lastSection);

      if (_timerSlide) {
        clearTimeout(_timerSlide);
        _timerSlide = setTimeout(function () {
          autoSlide(_options.autoSlide)
        }, _options.autoSlide);
      }

      if (jQuery.isFunction(_options.funcOnclick)) {
        _options.funcOnclick.apply(_this);
      }
      e.preventDefault();
    });

    if (_liSum <= _gHeight) {
      jQuery(_options.btPrev, _this).addClass('prev-' + _options.disableClass).unbind('click');
      jQuery(_options.btNext, _this).addClass('next-' + _options.disableClass).unbind('click');
    }
    // auto slide
    function autoSlide(autoSlideDuration) {
      //if (_options.circleSlide) {
      jQuery(_options.btNext, _this).trigger('click');
      //}
    }
    ;
    // Number list
    jQuery.fn.vgalleryScroll.numListCreate = function (_elNumList, _liSumHeight, _height, _section) {
      var _numListElC = '';
      var _num = 1;
      var _difference = _liSumHeight + _section;
      while (_difference > 0)
      {
        _numListElC += '<li><a href="">' + _num + '</a></li>';
        _num++;
        _difference = _difference - _height;
      }
      jQuery(_elNumList).html('<ul class="control">' + _numListElC + '</ul>');
    };
    jQuery.fn.vgalleryScroll.numListActive = function (_marginEl, _slideNum, _height, _section) {
      if (_slideNum) {
        jQuery('a', _slideNum).removeClass('active');
        var _activeRange = _height - _section - 1;
        var _n = 0;
        if (_marginEl != 0) {
          while (_marginEl > _activeRange) {
            _activeRange = (_n * _height) - _section - 1 + _options.innerMargin;
            _n++;
          }
        }
        var _a = (_activeRange + _section + 1 + _options.innerMargin) / _height - 1;
        jQuery('a', _slideNum).eq(_a).addClass('active');
      }
    };
    if (_options.slideNum && !_options.step) {

      jQuery.fn.vgalleryScroll.numListCreate(jQuery(_options.slideNum, _this), _liSum, _gHeight, _lastSection);
      jQuery.fn.vgalleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this), _gHeight, _lastSection);
      numClick();
    }
    ;
    function numClick() {
      jQuery(_options.slideNum, _this).find('a').click(function (e) {
        jQuery(_options.btPrev, _this).removeClass('prev-' + _options.disableClass);
        jQuery(_options.btNext, _this).removeClass('next-' + _options.disableClass);

        var _indexNum = jQuery(_options.slideNum, _this).find('a').index(jQuery(this));
        _margin = (_step * _indexNum) - _options.innerMargin;
        f = 0;
        _f2 = 0;
        if (_indexNum == 0)
          _f2 = 1;
        if (_margin + _step > _liSum) {
          _margin = _margin - (_margin - _liSum) - _step + _options.innerMargin;
          if (!_options.circleSlide)
            jQuery(_options.btNext, _this).addClass('next-' + _options.disableClass);
        }
        _animatedBlock.animate({marginTop: -_margin + "px"}, {queue: false, duration: _options.duration});

        if (!_options.circleSlide && _margin == 0)
          jQuery(_options.btPrev, _this).addClass('prev-' + _options.disableClass);
        jQuery.fn.vgalleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this), _gHeight, _lastSection);
        if (_timerSlide) {
          clearTimeout(_timerSlide);
          _timerSlide = setTimeout(function () {
            autoSlide(_options.autoSlide)
          }, _options.autoSlide);
        }
        e.preventDefault();
      });
    }
    ;
  });
}

/*Функция выравнивания высоты элементов -----------------------------------*/
function similarHeights(elem) {
  if ($(elem).length > 0) {
    var heights = [], currHeight;

    $(elem).each(function (k, v) {
      $(v).removeAttr('style').queue(function () {
        currHeight = $(v).height() * 1;
        heights.push(currHeight);
        $(this).dequeue();
      });
    });
    heights.sort(function (a, b) {
      return a - b;
    });
    var l = heights.length - 1;
    var max = heights[l];
    $(elem).height(max);
  }
  ;
}

/*Вертикальное выравнивание блочных элементов -----------------------------*/
function verticalAlign(container, elem) {
  if ($(container).length) {
    var cHeight, eHeight, offHeight;
    $(container).each(function () {
      cHeight = $(this).height();
      eHeight = $(this).find(elem).height();
      offHeight = (cHeight - eHeight) / 2;

      $(this).find(elem).css({"margin-top": offHeight + "px"});
    });
  }
}

/*Прячем и показываем лоадер---------------------------------------------*/
function showLoader() {
  $('.loader_bg').fadeIn(0);
}

function hideLoader() {
  setTimeout(function () {
    $('.loader_bg').fadeOut(300);
  }, 600);
}

/*Скрываем блоки с опциями в умном фильтре, если все опции недоступны----*/
function checkFilterOpt() {
  if ($('.smartfilter').length) {
    $('.smartfilter .blck').each(function () {
      var fOptions = $(this).find('.row').length,
              disFoptions = $(this).find('.disabled').length;
      if (fOptions == disFoptions)
        $(this).hide();
      else
        $(this).show();
    })
  }
}
/**
 * Анимация "полета"
 */
function countAnimate(elem) {
  var target = $(elem).data("count"),
          targetNewClass = target + "--active";
  target = "." + target;
  var coordX = Math.ceil($(target).offset().left), //position of target element
          coordY = Math.ceil($(target).offset().top),
          offsetX = Math.ceil($(elem).parent().find('.myChb').offset().left), //currentPosition
          offsetY = Math.ceil($(elem).parent().find('.myChb').offset().top);
  if ($(elem).is(':checked')) {
    $("#virt_checked").css({"left": offsetX + "px", "top": offsetY + "px"}).show(1).delay(1).queue(function () {
      $("#virt_checked").css({"top": coordY, "left": coordX, 'opacity': 0, 'transform': 'scale(0.3,0.3)'}).delay(500).queue(function () {
        $("#virt_checked").css({"top": 0, "left": 0, 'opacity': 1, 'transform': 'scale(1,1)'}).hide(1);
        $(target).next('.new').fadeIn(600).delay(1000).fadeOut(400);
        var count = $(target).text();
        count++;
        $(target).text(count).addClass(targetNewClass); //update number of items
        $(this).dequeue();
      });
      $(this).dequeue();
    });
  }
}
function subsFav(){
  var count = parseInt($(".favCount--active").text());
  if(count>0){
    count--;
    $(".favCount--active").text(count);
    if(count == 0) $(".favCount--active").removeClass("favCount--active");
  }
}
function optionsClicked(){
  var currSum = $('.price-val').data("baseprice");
  var oldCurrSum = parseInt($('.price-val').text().replace(' ', ''));
  var dopSum = 0;
  $('.options input:checked').each(function () {
    dopSum += parseInt($(this).val());
  });
  var newCurrSum = currSum + dopSum;
  var separator = $.animateNumber.numberStepFactories.separator(' ');
  $('.price-val').prop("number", oldCurrSum).animateNumber({number: newCurrSum,numberStep:separator});
}