var productGridOptions = {
    // options
    itemSelector: '.products-flex-item',
    masonry: {
        columnWidth: 240
    },
    animationOptions: {
        duration: 0,
        easing: 'linear',
        queue: false
    }
};

var profileGridOptions = {
    itemSelector: '.profile-column-item',
    animationOptions: {
        duration: 0,
        easing: 'linear',
        queue: false
    },
    getSortData: {
        order: '[data-order]',
    },
    sortBy : 'order'
}

var breakpoints = {
    small: 0,
    medium: 518,
    large: 758,
    xlarge: 998,
    xxlarge: 1238,
}

function initOwl() {
    var $mainSlider      = $('.main-slider'),
        $mainBanner      = $('.main-banner'),
        $mainNews        = $('.main-news-carousel'),
        $mainBrand       = $('.main-brand-carousel'),
        $productPreview  = $('.product-slider'),
        $productPack     = $('.product-pack-carousel'),
        $productCompare  = $('.product-compare-carousel'),
        $productSeeIt    = $('.product-carousel'),
        $innerGallery    = $('.inner-carousel'),
        $innerTeam       = $('.inner-team');

    if ($mainSlider.length) {
        var itemLength = $mainSlider.find('.item').length,
            params = {
                items: 1,
                center: true,
                navText: [],
                autoplay: true
            },
            medium = $mainSlider.parent().hasClass('medium');
        if (itemLength > 1) {
            params['loop'] = true;
            params['nav'] = (medium) ? false : true;
        } else {
            params['loop'] = false;
            params['dots'] = false;
        }
        $mainSlider.owlCarousel(params);
    }
    if ($mainBanner.length) {
        $mainBanner.each(function(){
            var itemLength = $(this).find('.item').length,
                params = {
                    loop: true,
                    items: 1,
                    margin: 20,
                    navText: [],
                    responsive: {}
                };
            params['responsive'][breakpoints['large']] = {
                items: 2,
            };
            params['responsive'][breakpoints['xlarge']] = {
                items: 3,
                loop: false,
                dots: false,
            };
            switch (itemLength) {
                case 1:
                    params['loop'] = false;
                    params['dots'] = false;
                    break;
                case 2:
                    params['responsive'][breakpoints['large']]['loop'] = false;
                    params['responsive'][breakpoints['large']]['dots'] = false;
                    break;
            }
            $(this).owlCarousel(params);
        });
    }
    if ($mainNews.length) {
        $mainNews.each(function(){
            var $self = $(this),
                itemLength = $self.find('.item').length,
                params = {
                    items: 1,
                    margin: 23,
                    nav: true,
                    navText: [],
                    responsive: {},
                };
            params['responsive'][breakpoints['large']] = {
                items: 2,
            };
            params['responsive'][breakpoints['xlarge']] = {
                items: 3,
            };
            params['responsive'][breakpoints['xxlarge']] = {
                items: 4,
            };
            switch (itemLength) {
                case 1:
                    params['nav'] = false;
                    params['dots'] = false;
                    break;
                case 2:
                    params['responsive'][breakpoints['large']]['dots'] = false;
                    params['responsive'][breakpoints['xlarge']]['dots'] = false;
                    params['responsive'][breakpoints['xxlarge']]['dots'] = false;
                    break;
                case 3:
                    params['responsive'][breakpoints['xlarge']]['dots'] = false;
                    params['responsive'][breakpoints['xxlarge']]['dots'] = false;
                    break;
                case 4:
                    params['responsive'][breakpoints['xxlarge']]['dots'] = false;
                    break;
            }
            $self.owlCarousel(params);
        });
    }
    if ($mainBrand.length) {
        $mainBrand.each(function(){
            var itemLength = $(this).find('.item').length,
                params = {
                    items: 4,
                    loop: true,
                    navText: [],
                    responsive: {},
                };
            params['responsive'][breakpoints['large']] = {
                items: 6,
            };
            params['responsive'][breakpoints['xlarge']] = {
                items: 8,
                dots: false,
            };
            if (itemLength <= 4) {
                params['dots'] = false;
                params['loop'] = false;
            } else if (itemLength <= 6) {
                params['responsive'][breakpoints['large']]['dots'] = false;
                params['responsive'][breakpoints['large']]['loop'] = false;
            } else if (itemLength <= 8) {
                params['responsive'][breakpoints['xlarge']]['dots'] = false;
                params['responsive'][breakpoints['xlarge']]['loop'] = false;
            } else {
                params['responsive'][breakpoints['xlarge']]['nav'] = true;
            }
            $(this).owlCarousel(params);
        });
    }
    if ($productPreview.length) {
        $productPreview.each(function(){
            var params = {
                items: 2,
                nav: true,
                dots: false,
                navText: [],
                responsive: {},
            };
            params['responsive'][breakpoints['medium']] = {
                items: 4,
            };
            $(this).owlCarousel(params);
        });
    }
    if ($productSeeIt.length) {
        $productSeeIt.each(function(){
            var $self = $(this),
                variation = $self.parent().hasClass('product-pack-variation'),
                inner = $self.hasClass('product-carousel-inner'),
                itemLength = $self.children('.item').length,
                params = {
                    items: 1,
                    margin: -1,
                    dragEndSpeed: 100,
                    navText: [],
                    rewind: variation ? false : true,
                    responsive: {},
                    mouseDrag: false
                };

            params['responsive'][breakpoints['medium']] = {
                items: 2,
            };
            params['responsive'][breakpoints['large']] = {
                items: 3,
            };
            params['responsive'][breakpoints['xlarge']] = {
                items: inner ? 3 : 4,
                nav: true,
                dots: false,
            };
            params['responsive'][breakpoints['xxlarge']] = {
                items: inner ? 4 : 5,
                nav: true,
                dots: false,
            };
            if (!variation) {
                switch (itemLength) {
                    case 1:
                        params['loop'] = false;
                        params['dots'] = false;
                    case 2:
                        params['responsive'][breakpoints['medium']]['loop'] = false;
                        params['responsive'][breakpoints['medium']]['dots'] = false;
                    case 3:
                        params['responsive'][breakpoints['large']]['loop'] = false;
                        params['responsive'][breakpoints['large']]['dots'] = false;
                    case 4:
                        params['responsive'][breakpoints['xlarge']]['loop'] = false;
                        params['responsive'][breakpoints['xlarge']]['nav'] = false;
                    case 5:
                        params['responsive'][breakpoints['xxlarge']]['loop'] = false;
                        params['responsive'][breakpoints['xxlarge']]['nav'] = (itemLength == 5 && inner) ? true : false;
                        break;
                }
            }
            $self.owlCarousel(params);
        });
    }
    if ($productPack.length) {
        var itemLength = $productPack.children('.item').length,
            params = {
            items: 1,
            margin: -1,
            responsive: {},
        };
        params['responsive'][breakpoints['xlarge']] = {
            items: 2,
        };
        params['responsive'][breakpoints['xxlarge']] = {
            items: 3,
        };
        switch (itemLength) {
            case 1:
                params['dots'] = false;
            case 2:
                params['responsive'][breakpoints['xlarge']]['dots'] = false;
            case 3:
                params['responsive'][breakpoints['xxlarge']]['dots'] = false;
                break;
        }
        $productPack.owlCarousel(params);
    }
    if ($productCompare.length) {
        var itemLength = $productCompare.children('.item').length,
            $compareTd = $('.compare-table-td'),
            heightArr = [],
            params = {
            items: 1,
            margin: -1,
            navText: [],
            responsive: {},
            mouseDrag: false,
        };
        params['responsive'][breakpoints['medium']] = {
            items: 2,
        };
        params['responsive'][breakpoints['xlarge']] = {
            items: 3,
            nav: true,
            dots: false,
        };
        params['responsive'][breakpoints['xxlarge']] = {
            items: 4,
            nav: true,
            dots: false,
        };
        switch (itemLength) {
            case 1:
                params['dots'] = false;
            case 2:
                params['responsive'][breakpoints['medium']]['dots'] = false;
                break;
        }
        
        $compareTd.each(function(){
            var $td = $(this),
                index = $td.index(),
                heightColumn = $td.find('.column:not(.transparent)').outerHeight();

            if ((heightColumn > heightArr[index]) || (heightArr[index] === undefined)) {
                heightArr[index] = heightColumn;
            }
        });
        $compareTd.each(function(){
            var $td = $(this),
                index = $td.index(),
                $column = $td.find('.column:not(.transparent, .hide-for-large)');

            if ($column.length) {
                $column.css('height', heightArr[index]);
            }
        });
        
        $productCompare.owlCarousel(params);
    }
    if ($innerGallery.length) {
        $innerGallery.each(function() {
            var $self = $(this),
                itemLength = $self.children('.item').length,
                params = {
                    items: 2,
                    margin: 15,
                    loop: true,
                    navText: [],
                    responsive: {},
                };

            params['responsive'][breakpoints['large']] = {
                nav: true,
                dots: false,
            };
            params['responsive'][breakpoints['xxlarge']] = {
                items: 3,
                nav: true,
                dots: false,
            };
            switch (itemLength) {
                case 1:
                case 2:
                    params['loop'] = false;
                    params['dots'] = false;
                    params['responsive'][breakpoints['large']]['nav'] = false;
                case 3:
                    params['responsive'][breakpoints['xxlarge']]['nav'] = false;
                    break;
            }
            $self.owlCarousel(params);
        });
    }
    if ($innerTeam.length) {
        $innerTeam.each(function() {
            var $self = $(this),
                itemLength = $self.children('.item').length,
                params = {
                    items: 1,
                    loop: true,
                    navText: [],
                    responsive: {},
                };

            params['responsive'][breakpoints['medium']] = {
                items: 2,
            };
            params['responsive'][breakpoints['large']] = {
                items: 3,
            };
            params['responsive'][breakpoints['xxlarge']] = {
                items: 4,
                nav: true,
                dots: false,
            };
            switch (itemLength) {
                case 1:
                case 2:
                    params['loop'] = false;
                    params['dots'] = false;
                case 4:
                    params['responsive'][breakpoints['xxlarge']]['nav'] = false;
                    break;
            }
            $self.owlCarousel(params);
        });
    }
}

$(document).ready(function() {
    $(document).foundation();

    var $productGrid = $('.products-flex-grid').isotope(productGridOptions);

    var windowWidth = $(window).width(),
        widthHeight = $(window).height(),
        foundationScreenOld = Foundation.MediaQuery.current,
        slideout = new Slideout({
            'panel': document.getElementById('page'),
            'menu': document.getElementById('mobile-menu'),
            'padding': 260,
            'tolerance': 70
        }),
        scrTop = 0,
        $scrollUpDown = $(".scroll-up-down");
    window['colors'] = {
        primary: '#264f85',
        secondary: '#d8192b',
    };
    
    initOwl();
    
    //Все, что связано с шаблоном
    
    initSelect('select');
    $('input.phone').mask('+7 (000) 000-0000');
    $('input.zip').mask('000 000');
    $('.fancybox:not([disabled],.disabled)').fancybox({
        padding: 0,
    });
    
    $(document).on('click', '.fancybox-cancel', function(e){
        $.fancybox.close();
        e.preventDefault();
    });
    
    $(document).on('click', '.preview-button', function(e){
        var $self = $(this);
        $.fancybox({
            type: 'ajax',
            href: $self.attr('data-href'),
            padding: 0,
        });
        e.preventDefault();
    });
    
    $(document).on('click', '.show-href', function(e){
        var $self = $(this);
        $self.closest('.fancybox-block').hide();
        $($self.attr('href')).show();
        e.preventDefault();
    });
    
    $(document).click(function(e){
        $dropdown = $('.dropdown-custom.is-open');
    
        if ($dropdown.length && !$dropdown.has(e.target).length) {
            $dropdown.removeClass('is-open');
        }
    });
    
    function mainMenuArrowPosition(){
        var $menu = $('.header-main-menu-other'),
            left = $menu.offset().left,
            width = $menu.width();
        $('.header-main-menu-other .header-main-menu-dropdown-arrow').css({'left': left + width/2 - 10});
    }
    
    function hsMainMenuItems(action) {
        var $mainMenu = $('.header-main-menu');
        if ($mainMenu.is(':visible')) {
            var $menuBlock = $('.header-main-menu-block'),
                $menuBase = $('.header-main-menu-base'),
                $menuFull = $('#header-main-menu-full .container'),
                $menuOther = $('.header-main-menu-other'),
                maxWidth = parseInt($menuBlock.css('maxWidth')),
                baseWidth = $menuBase.width() - 16;
            if (action == 'hide') {
                if (baseWidth > maxWidth) {
                    if ($menuOther.hasClass('hide')) {
                        $menuOther.removeClass('hide');
                    }
                    var $replaceItem = $menuBase.find('.header-main-menu-category:last-child');
                    if ($replaceItem.length) {
                        $menuFull.prepend($replaceItem);
                        hsMainMenuItems('hide');
                    }
                }
            }
            if (action == 'show') {
                if (baseWidth <= maxWidth) {
                    var $replaceItem = $menuFull.find('.header-main-menu-category:first-child');
                    if ($replaceItem.length) {
                        $menuBase.append($replaceItem);
                        hsMainMenuItems('show');
                    }
                } else {
                    hsMainMenuItems('hide');
                }
            }
            mainMenuArrowPosition();
        }
    }
    
    hsMainMenuItems('hide');
    
    function hideCustomMenu()
    {
        var $cMenu = $('#custom-menu');
        if ($cMenu.length) {
            var $toggle = $cMenu.find('.toggle');
    
            $cMenu.removeClass('active');
            if ( $toggle.attr('data-toggle') !== undefined) {
                $toggle.foundation('hide');
            }
        }
    }
    
    function menuFilterToggle(inMobile)
    {
        var $mobileMenu = $('#mobile-menu');
        $('#catalog-filter').appendTo((inMobile) ? $mobileMenu : $('#catalog-filter-wrapper'));
        $mobileMenu.find('.mobile-menu-wrapper').toggleClass('hide');
        $('html').toggleClass('slideout-filter');
    }
    
    function menuFilterToggleOnce()
    {
        menuFilterToggle(true);
        slideout.open();
        slideout.once('close', function(){
            menuFilterToggle();
        });
    }
    
    $('.header-mobile-toggle').on('click', function() {
        var $mobileMenu = $('#mobile-menu');
    
        hideCustomMenu();
        if (slideout.isOpen() && $('html').hasClass('slideout-filter')) {
            slideout.close();
            slideout.once('close', function(){
                slideout.open();
            });
        } else {
            slideout.toggle();
        }
    });
    
    $(document).on('click', '.filter-mobile-toggle', function(e){
        var $mobileMenu = $('#mobile-menu');
    
        hideCustomMenu();
        if (slideout.isOpen()) {
            if ($('html').hasClass('slideout-filter')) {
                slideout.close();
            } else {
                slideout.close();
                slideout.once('close', function(){
                    menuFilterToggleOnce();
                });
            }
        } else {
            menuFilterToggleOnce();
            initSlider();
        }
        e.preventDefault();
    });
    
    $(document).on('open.zf.drilldown', function(e){
        $('#mobile-menu').animate({scrollTop: 0}, 200);
    });
    
    $scrollUpDown.click(function(e){
        $("body,html").animate({scrollTop: 0}, 200);
        e.preventDefault();
    });
    
    $(window).resize(function() {
        var windowWidthNew = $(this).width(),
            foundationScreenNew = Foundation.MediaQuery.current;
        if (windowWidthNew > windowWidth) {
            hsMainMenuItems('show');
        }
        if (windowWidthNew < windowWidth) {
            hsMainMenuItems('hide');
        }
        if (foundationScreenOld != foundationScreenNew) {
            if (slideout.isOpen()
                && ($.inArray(foundationScreenOld, ['small', 'medium', 'large']) != -1)
                && ($.inArray(foundationScreenNew, ['xlarge', 'xxlarge']) != -1)) {
                slideout.close();
            }
            foundationScreenOld = foundationScreenNew;
        }
        windowWidth = windowWidthNew;
    
        $('.tracker').data('largeimage', false);
        checkAccordionTabs(foundationScreenNew);
    });
    
    $(window).scroll(function() {
        scrTop = $(window).scrollTop();
        if (scrTop > 250) {
            $scrollUpDown.fadeIn();
        } else {
            $scrollUpDown.fadeOut();
        }
    });
    
    //Позиционирование блоков в ЛК
    
    var $profileGrid = $('.profile-column-container').isotope(profileGridOptions);
    
    //Сетка продуктов на главной
    
    $('.main-product-tabs .tabs').on('change.zf.tabs', function(e, $tab) {
        var index = $tab.index();
    
        $tab.closest('.main-product-tabs').find('.select-tabs option').eq(index).prop('selected', true).trigger('refresh');
        $productGrid.isotope();
    });
    
    $(document).on('change', '.main-product-tabs select.select-tabs', function(){
        var target = $(this).find('option:selected').val();
        $('.main-product-tabs .tabs').foundation('selectTab', $(target));
    });
    
    // Сворачивание блоков в блоке Фильтров в Каталоге
    $('.catalog-filters__block .heading').click(function (e) {
        e.preventDefault();
        $(this).parents('.catalog-filters__block').toggleClass('showed').find('.body').slideToggle();
        if (!$(this).hasClass('showed')) {
            initSlider();
        }
    });
    
    /*$('#catalog-filter .slider').on('changed.zf.slider', function(e, $handle){
        var $target = $(e.target),
            changed = $target.data('changed');

        if (changed > 0) {
            fadeFilterLoading($('#' + $handle.attr('aria-controls')));
        }
        $target.data('changed', changed + 1);
    });*/

    $('body').on('click', function(e){
        var $target = $(e.target),
            $filterTip = $('.filter-tip');

        if (!$target.closest('.filter-tip').length && $filterTip.length) {
            $filterTip.hide();
        }
    });
    
    function removeOwlItem($self){
        var $owlCarousel = $self.closest('.owl-carousel'),
            $item = $self.closest('.owl-item'),
            index = $item.index();
    
        $item.find('.product-pack-change').toggleClass('remove add');
        var item = $item.html();
        $owlCarousel.trigger('remove.owl.carousel', index);
        $owlCarousel.trigger('refresh.owl.carousel');
        $owlCarousel.trigger('next.owl.carousel');
        return item;
    }
    
    //Все, что связано с карточкой товара
    
    initProductPreviewZoom();
    
    initTimer();
    
    initSlider();
    
    $(document).on('click', '.product-preview-zoom', function(e){
        var previews = [],
            activeIndex = 0;
        $('.product-slider .item').each(function(){
            var $self = $(this);
            previews.push($self.attr('href'));
            if ($self.hasClass('active')) {
                activeIndex = $self.parent().index();
            }
        });
        $.fancybox(previews, {
            index: activeIndex,
            helpers	: {
                thumbs	: {
                    width	: 61,
                    height	: 61
                }
            }
        });
        e.preventDefault();
    });
    
    $(document).on('click', '.product-slider .item', function(e){
        var $self = $(this);
        if (!$self.hasClass('active')) {
            $self.parents('.product-preview').find('.product-slider .item').removeClass('active');
            $self.parents('.product-preview').find('.product-preview-main img').attr('src', $self.attr('href'));
            $self.addClass('active');
        }
        e.preventDefault();
    });
    
    $(document).on('click', '.product-info-social a', function(e){
        $('.' + $(this).attr('href')).click();
        e.preventDefault();
    });
    
    //Синхронизация Аккардиона и Табов
    
    function checkAccordionTabs(foundationScreen){
        var $content = $('.product-accordion-tabs-content'),
            $items   = $('.product-accordion-tabs-item'),
            $wraps   = $('.product-accordion-tabs-wrap');
    
        if ($.inArray(foundationScreen, ['small', 'medium', 'large']) != -1) {
            if ($content.hasClass('tabs-content')) {
                $content.removeClass('tabs-content').addClass('accordion').attr('data-accordion');
                $items.addClass('accordion-item').removeClass('tabs-panel');
                $wraps.addClass('accordion-content').hide();
                $items.filter('.is-active').children('.product-accordion-tabs-wrap').show();
            }
        } else {
            if ($content.hasClass('accordion')) {
                $content.removeAttr('data-accordion').removeClass('accordion').addClass('tabs-content');
                $items.removeClass('accordion-item').addClass('tabs-panel');
                $wraps.removeClass('accordion-content').show();
            }
        }
    }
    
    checkAccordionTabs(foundationScreenOld);
    
    $(document).on('click', '.product-accordion-tabs .accordion-title', function(){
        var $self = $(this),
            $tabsTitle  = $('.product-accordion-tabs .tabs-title'),
            $activeLink = $tabsTitle.children('a[href="#' + $self.attr('id') + '"]');
        $tabsTitle.removeClass('is-active');
        $tabsTitle.children().removeAttr('aria-selected');
        $activeLink.attr('aria-selected', 'true');
        $activeLink.parent().addClass('is-active');
        setTimeout(function(){
            $("body,html").animate({scrollTop: $self.offset().top}, 200);
        }, 250);
    });

});