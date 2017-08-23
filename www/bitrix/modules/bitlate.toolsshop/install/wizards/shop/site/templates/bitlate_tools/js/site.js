function getNewsItems(elem, containerName, reload) {
    if (!$(elem).hasClass('ajax-loading')) {
        $(elem).addClass('ajax-loading');
    } else {
        return false;
    }
    $.ajax({
        type: 'GET',
        url: $(elem).attr('data-ajax'),
        success: function(data) {
            if (reload === true) {
                $('#' + containerName).html(data);
            } else {
                $('#' + containerName).append(data);
            }
            $(elem).removeClass('ajax-loading');
        }
    });
}

function showFilterLoading() {
    $('#catalog-content').addClass('loading');
    $('#catalog-preloader').show();
    $('.filter-tip').hide();
}
function hideFilterLoading() {
    $('#catalog-content').removeClass('loading');
    $('#catalog-preloader').hide();
}

function getCatalogItems(elem, block, reload, tab) {
    if (!$(elem).hasClass('ajax-loading')) {
        $(elem).addClass('ajax-loading');
    } else {
        return false;
    }
    var url = $(elem).attr('data-ajax');
    if (!url) {
        url = $(elem).attr('href');
    }
    var isHistory = true;
    var urlHistory = url.replace('&load=Y', '');
    urlHistory = urlHistory.replace('?load=Y&', '?');
    urlHistory = urlHistory.replace('?load=Y', '');
    if (tab !== true) {
        if (!(window.history && history.pushState)) {
            isHistory = false;
        }
    }
    if (isHistory === true) {
        if (reload === true) {
            showFilterLoading();
        }
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                if (tab !== true) {
                    history.replaceState(null, null, urlHistory);
                }
                if (reload === true) {
                    $(block).html(data).foundation();
                    initSelect(block + ' select');
                    hideFilterLoading();
                } else {
                    if (tab === true) {
                        $(block).append($(data).html());
                    } else {
                        $(block).append($(data).find(block).html());
                    }
                    if ($('#catalog-content .catalog-footer').length > 0) {
                        $('#catalog-content .catalog-footer').html($(data).find('.catalog-footer').html());
                    }
                }
                if ($('.products-flex-grid').length > 0) {
                    if (reload !== true) {
                        $('.products-flex-grid').isotope('destroy');
                    }
                    $('.products-flex-grid').isotope(productGridOptions);
                }
                if ($('.product-list-item .dropdown-pane').length > 0) {
                    $('.product-list-item .dropdown-pane').foundation();
                }
                $(elem).removeClass('ajax-loading');
                updateAdd2Basket();
                updateAdd2Liked();
                updateAdd2Compare();
                initTimer();
            }
        });
        return false;
    } else {
        window.location.href = urlHistory;
    }
}

function initValidateOrder(formId, rulesArray) {
   $(formId).validate({
        rules: rulesArray,
        onsubmit: false,
        highlight: function( element ){
            $(element).addClass('error');
        },
        unhighlight: function( element ){
            $(element).removeClass('error');
        },
        submitHandler: function( form ){
            return true;
        },
        errorPlacement: function( error, element ){
            $.fancybox.hideLoading();
            $.fancybox.helpers.overlay.close();
            return false;
        }
    });
}

function initValidateWithRules(formId, rulesArray) {
   $(formId).validate({
        rules: rulesArray,
        highlight: function( element ){
            $(element).addClass('error');
        },
        unhighlight: function( element ){
            $(element).removeClass('error');
        },
        submitHandler: function( form ){
            switch (formId) {
                case "#registration-static form":
                case "#registration form":
                    var login = $(form).find('input[name=USER_LOGIN]').val();
                    $(form).find('input[name=USER_EMAIL]').val(login);
                    var fullName = $(form).find('input[name=USER_FULL_NAME]').val().split(' ');
                    $(form).find('input[name=USER_LAST_NAME]').val(fullName[0].trim());
                    delete fullName[0];
                    $(form).find('input[name=USER_NAME]').val(fullName.join(' ').trim());
                    break;
            }
            return true;
        },
        errorPlacement: function( error, element ){
            return false;
        }
    });
}

function initValidate(formId) {
    var rulesArray = false;
    switch (formId) {
        case "#main-feedback-form":
            var rulesArray = {
                user_name: {
                    required: true,
                    minlength: 2
                },
                user_email: {
                    required: true,
                    email: true,
                    minlength: 2
                },
                captcha_word: {
                    required: true
                },
                MESSAGE: {
                    required: true,
                    minlength: 4
                }
            };
            break;
        case "#login-static form":
        case "#login form":
            var rulesArray = {
                USER_LOGIN: {
                    required: true
                },
                USER_PASSWORD: {
                    required: true
                }
            };
            break;
        case "#registration-static form":
        case "#registration form":
            var rulesArray = {
                USER_FULL_NAME: {
                    required: true
                },
                USER_LOGIN: {
                    required: true,
                    email: true
                },
                USER_PASSWORD: {
                    required: true,
                    minlength: 6
                },
                USER_CONFIRM_PASSWORD: {
                    required: true,
                    minlength: 6,
                    equalTo: '.registration-form input[name=USER_PASSWORD]'
                },
                captcha_word: {
                    required: true,
                }
            };
            break;
        case "#confirmation form":
            var rulesArray = {
                login: {
                    required: true,
                    email: true
                },
                confirm_code: {
                    required: true
                }
            };
            break;
        case "#forgot form":
            var rulesArray = {
                USER_EMAIL: {
                    required: true,
                    email: true
                }
            };
            break;
        case "#change form":
            var rulesArray = {
                USER_LOGIN: {
                    required: true
                },
                USER_CHECKWORD: {
                    required: true
                },
                USER_PASSWORD: {
                    required: true,
                    minlength: 6
                },
                USER_CONFIRM_PASSWORD: {
                    required: true,
                    minlength: 6,
                    equalTo: '.forgot-form input[name=USER_PASSWORD]'
                }
            };
            break;
        case "#profile-pass form":
            var rulesArray = {
                NEW_PASSWORD: {
                    required: true,
                    minlength: 6
                },
                NEW_PASSWORD_CONFIRM: {
                    required: true,
                    minlength: 6,
                    equalTo: '#profile-pass input[name=NEW_PASSWORD]'
                }
            };
            break;
        case "#profile-data form":
            var rulesArray = {
                LAST_NAME: {
                    required: true
                },
                NAME: {
                    required: true
                },
                EMAIL: {
                    required: true,
                    email: true
                },
                PERSONAL_PHONE: {
                    required: true
                }
            };
            break;
        case "#buy-to-click-form":
            var rulesArray = {
                NAME: {
                    required: true,
                    minlength: 3,
                },
                PHONE: {
                    required: true
                }
            };
            break;
        default:
            break;
    }
    if (rulesArray !== false) {
        initValidateWithRules(formId, rulesArray);
    }
}

function initTimer() {
    var $actionTimer = $('.product-action-banner.timer');
    if ($actionTimer.length) {
        $actionTimer.each(function(){
            var $self = $(this),
                $hour = $self.find('.hour strong'),
                $min = $self.find('.min strong'),
                $sec = $self.find('.sec strong'),
                today = new Date();
                timeEnd = new Date(today.getFullYear(), today.getMonth(), today.getDate(), 23, 59, 59);

            function timer($hour, $min, $sec, timeEnd) {
                var timeNow = new Date(),
                    timeLeft = new Date(timeEnd - timeNow),
                    timeLeftSec = parseInt(timeLeft / 1000),
                    timeLeftMin = parseInt(timeLeftSec / 60),
                    timeLeftHour = parseInt(timeLeftMin / 60);

                $hour.text(int2num(timeLeftHour));
                $min.text(int2num(timeLeftMin - (timeLeftHour * 60)));
                $sec.text(int2num(timeLeftSec - (timeLeftMin * 60)));
            }
            setInterval(function(){
                timer($hour, $min, $sec, timeEnd);
            }, 1000);
        });
    }
}

function initProductPreviewZoom() {
    if ($(".product-preview-main img.zoom").length) {
        $(".product-preview-main img.zoom").each(function(){
            var $self = $(this);
    
            if ($self.is(':visible')) {
                $self.imagezoomsl({
                    showstatus: false,
                    magnifiereffectanimate: "fadeIn",
                    loopspeedanimate: 1,
                });
            }
        });
    }
}

function initSelect(block) {
    $(block).styler({
        singleSelectzIndex: 20,
    });
}

function initSlider()
{
    var $slider = $('.slider');
    if ($slider.length) {
        $slider.each(function () {
            var $self = $(this);

            if ($self.is(':visible') && ($self.data('init') !== true)) {
                var a = new Foundation.Slider($self);
                $self.data({
                    'init': true,
                    'changed': 0,
                });
            }
        });
    }
}

function updateAdd2Basket() {
    $('.add2cart span').html(NL_ADD_TO_BASKET_BUTTON);
    $('.add2cart').attr('href', 'javascript:;');
    $('.add2cart').removeClass('in_basket');
    if ($('.add2cart').length > 0 && $('.basket_products div').length > 0) {
        $('.basket_products div').each(function(){
            var productId = $(this).attr('data-product-id');
            $('.add2cart[data-product-id=' + productId + '] span').html(NL_ADD_TO_BASKET);
            $('.add2cart[data-product-id=' + productId + ']').attr('href', NL_ADD_TO_BASKET_URL);
            $('.add2cart[data-product-id=' + productId + ']').addClass('in_basket');
        });
    }
}

function updateAdd2Liked() {
    if ($('#bx_favorite_count').length > 0 && $('.liked_products div').length > 0) {
        $('.liked_products div').each(function(){
            var productId = $(this).attr('data-product-id');
            $('.add2liked[data-product-id=' + productId + '] span').html(NL_ADD_2_LIKED_DELETE);
            $('.add2liked[data-product-id=' + productId + ']').attr('title', NL_ADD_2_LIKED_DELETE);
            $('.add2liked[data-product-id=' + productId + ']').addClass('active');
        });
    }
}

function updateAdd2Compare() {
    if ($('#bx_compare_count').length > 0 && $('.compare_products div').length > 0) {
        $('.compare_products div').each(function(){
            var productId = $(this).attr('data-product-id');
            $('.add2compare[data-product-id=' + productId + '] span').html(NL_ADD_2_COMPARE);
            $('.add2compare[data-product-id=' + productId + ']').attr('title', NL_ADD_2_COMPARE);
            $('.add2compare[data-product-id=' + productId + ']').attr('href', NL_ADD_2_COMPARE_URL);
            $('.add2compare[data-product-id=' + productId + ']').addClass('active');
        });
    }
}

function preview2Basket($self) {
    if ($self) {
        $self.addClass('in_basket');
        if ($self.attr('data-preview') !== undefined) {
            var $preview = $($self.attr('data-preview') + ':visible'),
                $cart = $('.header-cart:visible');

            if ($preview.length) {
                $preview.clone().css({
                    'position':'absolute',
                    'top':$preview.offset().top,
                    'left':$preview.offset().left,
                    'z-index':3,
                    'max-width':'200px',
                }).appendTo('#page').animate({
                    'top' :$cart.offset().top,
                    'left':$cart.offset().left,
                    'width':'75px',
                }, 700, function(){
                    $(this).remove();
                });
            }
        }
    }
}

function int2num(val) {
    return val < 10 ? '0' + val : val;
}

function inclination(n, s1, s2, s3) {
    var m = n % 10;
    var j = n % 100;
    if (m == 0 || m >= 5 || (j >= 10 && j <= 20)) return s3;
    if (m >= 2 && m <= 4) return s2;
    return s1;
}

function add2compare(productId, count, message, url) {
    var captionMini = count + ' ' + inclination(count, NL_PRODUCT_1, NL_PRODUCT_2, NL_PRODUCT_10);
    var caption = count + ' ' + inclination(count, NL_PRODUCT_1, NL_PRODUCT_2, NL_PRODUCT_10) + ' ' + NL_ADD_2_COMPARE_CAPTION;
    $(".add2compare[data-product-id=" + productId + "] span").html(message);
    $(".add2compare[data-product-id=" + productId + "]").attr('title', message);
    $(".add2compare[data-product-id=" + productId + "]").attr('href', url);
    $(".add2compare[data-product-id=" + productId + "]").addClass('active');
    $('#bx_compare_count .compare_products').append('<div data-product-id="' + productId + '"></div>');
    if (count > 0) {
        $('#bx_compare_count span').html(' (' + count + ')');
        $('#bx_compare_count_mini .header-block-info-counter').html(count);
        $('#bx_compare_count_mini .header-block-info-counter').attr('title', captionMini);
    } else {
        $('#bx_compare_count span').html('');
        $('#bx_compare_count_mini .header-block-info-counter').html('');
        $('#bx_compare_count_mini .header-block-info-counter').attr('title', '');
    }
    $('#bx_compare_count_mini .header-block-info-desc').html(caption);
    $('#bx_compare_count_mini .header-block-info-desc').attr('title', caption);
}

if (window.frameCacheVars !== undefined) {
    BX.addCustomEvent("onFrameDataReceived" , function(json) {
        $('#bx_personal_menu .dropdown-pane').foundation();
        updateAdd2Basket();
        updateAdd2Liked();
        updateAdd2Compare();
    });
} else {
    $(document).ready(function() {
        updateAdd2Basket();
        updateAdd2Liked();
        updateAdd2Compare();
    });
}

$(document).ready(function() {
    var initSlider = false;
    var initSliderCount = 0;
    
    if ($('section').hasClass('fancy')) {
        $('article .fancybox-block').show();
    }
    
    $('#catalog-filter .slider').on('moved.zf.slider', function(e, handle){
        if (handle.attr('aria-valuenow') == handle.attr('aria-valuemax') || handle.attr('aria-valuenow') == handle.attr('aria-valuemin')) {
            $("#" + handle.attr('aria-controls')).val('');
        }
    })
    
    $('#catalog-filter .slider').on('changed.zf.slider', function(e, handle){
        initSliderCount++;
        if (!initSlider) {
            if (initSliderCount >= $('#catalog-filter .slider').length) {
                initSlider = true;
            }
        } else {
            smartFilter.reload($("#" + handle.attr('aria-controls')).get(0));
        }
    });
    
    $(document).on('change', '.catalog-sorting select', function(e){
        var url = $(this).val();
        if (url != '') {
            var newSort = $(this).find('option:selected').attr('data-sort-code');
            $('#catalog-filter input[name=sort]').val(newSort);
            $(this).attr('data-ajax', url);
            $('#catalog-filter #set_filter').attr('href', $(this).attr('data-ajax'));
            getCatalogItems(this, '.catalog-reload', true);
            return false;
        }
    });
    
    $(document).on('click', '.catalog-view-select a', function(e){
        var newView = $(this).attr('data-view-code');
        $('#catalog-filter input[name=view]').val(newView);
        $('#catalog-filter #set_filter').attr('href', $(this).attr('data-ajax'));
        getCatalogItems(this, '.catalog-reload', true);
        return false;
    });
    
    $(document).on('click', '.catalog-show-count a', function(e){
        var newCount = $(this).attr('data-count-code');
        $('#catalog-filter input[name=PAGE_EL_COUNT]').val(newCount);
        $('#catalog-filter #set_filter').attr('href', $(this).attr('data-ajax'));
        getCatalogItems(this, '.catalog-reload', true);
        return false;
    });
    
    $(document).on('click', '.show-del-delivery', function(e){
        $('.message-block').addClass('hide');
        $('.confirm-block').removeClass('hide');
        $('#del-delivery form input[name=id]').val($(this).attr('data-id'));
    });
    
    $(document).on('click', '.add2liked, .remove2liked', function(e){
        var productId = $(this).attr('data-product-id'),
            sessid = BX.bitrix_sessid(),
            action = 'check';
        var isShowLoading = ($(this).hasClass('close-button')) ? true : false;
        if (productId && action) {
            if (isShowLoading) {
                $.fancybox.showLoading();
            }
            $.post($(this).attr('data-ajax'), {'action': action, 'ID': productId, 'sessid': sessid}, function(data) {
                if (data.success == true) {
                    if (data.type == 'add') {
                        $('.add2liked[data-product-id=' + productId + '] span').html(NL_ADD_2_LIKED_DELETE);
                        $('.add2liked[data-product-id=' + productId + '] title').html(NL_ADD_2_LIKED_DELETE);
                        $('.add2liked[data-product-id=' + productId + ']').addClass('active');
                        $('#bx_favorite_count .liked_products').append('<div data-product-id="' + productId + '"></div>');
                        $('.add2liked.fancybox').attr('href', 'javascript:;');
                        $('#bx_favorite_count_mini .fancybox').attr('href', 'javascript:;');
                        $.ajax({
                            url: $('#liked').attr('data-ajax'),
                            success: function(data){
                                $('#bx_fancybox_blocks #liked').replaceWith(data);
                                $('.add2liked.fancybox').attr('href', '#liked');
                                $('#bx_favorite_count_mini .fancybox').attr('href', '#liked');
                                updateAdd2Basket();
                            }
                        });
                    } else {
                        $('.add2liked[data-product-id=' + productId + '] span').html(NL_ADD_2_LIKED);
                        $('.add2liked[data-product-id=' + productId + '] title').html(NL_ADD_2_LIKED);
                        $('.add2liked[data-product-id=' + productId + ']').removeClass('active');
                        $('#bx_favorite_count .liked_products div[data-product-id=' + productId + ']').remove();
                        if (!isShowLoading) {
                            $('#liked .cart-product-item[data-product-id=' + productId + ']').remove();
                        }
                    }
                    var captionMini = data.count + ' ' + inclination(data.count, NL_PRODUCT_1, NL_PRODUCT_2, NL_PRODUCT_10);
                    var caption = data.count + ' ' + inclination(data.count, NL_PRODUCT_1, NL_PRODUCT_2, NL_PRODUCT_10) + ' ' + NL_ADD_2_LIKED_CAPTION;
                    if (data.count > 0) {
                        $('header .add2liked span').html(' (' + data.count + ')');
                        $('#bx_favorite_count_mini a .header-block-info-counter').html(data.count);
                        $('#bx_favorite_count_mini a .header-block-info-counter').attr('title', captionMini);
                    } else {
                        $('.add2liked.fancybox').attr('href', 'javascript:;');
                        $('#bx_favorite_count_mini .fancybox').attr('href', 'javascript:;');
                        $('header .add2liked span').html('');
                        $('#bx_favorite_count_mini a .header-block-info-counter').html('');
                        $('#bx_favorite_count_mini a .header-block-info-counter').attr('title', '');
                    }
                    $('#bx_favorite_count_mini a .header-block-info-desc').html(caption);
                    $('#bx_favorite_count_mini a .header-block-info-desc').attr('title', caption);
                    if (isShowLoading) {
                        $.fancybox.hideLoading();
                    }
                }
            }, 'json');
        }
        e.preventDefault();
    });
    
    $('.go2buy:not([disabled],.disabled)').fancybox({
        padding: 0,
        beforeLoad: function() {
            var parentBlock = $(this.element).parent();
            $("#buy-to-click input[name=cart]").val(parentBlock.find('input[name=cart]').val());
            $("#buy-to-click input[name=id]").val(parentBlock.find('input[name=id]').val());
            $("#buy-to-click input[name=offer_id]").val(parentBlock.find('input[name=offer_id]').val());
            $("#buy-to-click input[name=props]").val(parentBlock.find('input[name=props]').val());
            $("#buy-to-click input[name=price]").val(parentBlock.find('input[name=price]').val());
            $("#buy-to-click input[name=currency]").val(parentBlock.find('input[name=currency]').val());
            $("#buy-to-click input[name=quantity]").val(parentBlock.parents('.product-container').find('.product-count input[name=count]').val());
            $("#buy-to-click .callout").remove();
            $("#buy-to-click .result-text").remove();
            $("#buy-to-click .form-block").show();
        }
    });
    
    $(document).on('click', '#del-delivery .profile-remove', function(e){
        $.ajax({
            type: 'POST',
            url: $('#del-delivery form').attr('action'),
            data: $('#del-delivery form').serialize(),
            dataType: 'json',
            success: function(response){
                $('#del-delivery .message-block').removeClass('hide');
                $('#del-delivery .confirm-block').addClass('hide');
                if (response.success == 'N') {
                    if ($(response.error).length) {
                        $('#del-delivery .message-block').html(response.error);
                    }
                }
                if (response.success == 'Y') {
                    $('#del-delivery .message-block').html(response.message);
                    $('.shipping .profile-block-list li[data-id=' + response.id + ']').remove();
                    $('.shipping .profile-block-list li .secondary').remove();
                    if ($('.shipping .profile-block-list li').length > 0) {
                        $('.shipping .profile-block-list li').eq(0).prepend($('#profile-default-text').html());
                    } else {
                        $('.shipping .profile-block-list').remove();
                        $('.shipping .profile-block-wrap').prepend($('#profile-empty-text').html());
                    }
                    $('.profile-column-container').isotope('destroy');
                    $('.profile-column-container').isotope(profileGridOptions);
                }
            }
        });
        e.preventDefault();
    });
    
    $(document).on('click', '.delivery-form input[name=PERSON_TYPE]', function(e) {
        var curForm = $(this).parents('form');
        var curBlock = $(this).parents('.fancybox-block');
        curForm.find('input[name=action]').val('change');
        $.ajax({
            type: 'POST',
            url: curForm.attr('data-ajax'),
            data: curForm.serialize(),
            success: function(data){
                curBlock.html($(data).html());
            }
        });
        e.preventDefault();
    })
    
    $(document).on('submit', '#form_subscr_footer', function(e) {
        var curForm = $(this);
        $.ajax({
            type: 'POST',
            url: $('.footer-subscribe').attr('data-ajax'),
            data: curForm.serialize(),
            success: function(data){
                $('.footer-subscribe').replaceWith(data);
            }
        });
        e.preventDefault();
    })
    
    $(document).on('submit', '#form_subscr_personal', function(e) {
        var curForm = $(this);
        $.ajax({
            type: 'POST',
            url: curForm.attr('data-ajax'),
            data: curForm.serialize(),
            success: function(data){
                $(curForm).parents('.profile-block-wrap').html($(data).find('.profile-block-wrap').html());
            }
        });
        e.preventDefault();
    })
    
    $(document).on('click', '#registration-static .show-static, #login-static .show-static', function(e){
        if ($(this).attr('data-static') != undefined) {
            var idStatic = $(this).attr('data-static');
            $('article .fancybox-block').html($("#" + idStatic).html());
            $('article .fancybox-block').attr('id', idStatic + '-static');
            $('article .fancybox-block input[name=static]').val("Y");
            $('article .fancybox-block .show-static').removeClass("fancybox");
            initValidate("#" + idStatic + '-static');
            e.preventDefault();
        }
    });
    
    $(document).on('click', '.inner-menu-filter .menu li a', function(e){
        if ($(this).parent().hasClass('active')) {
            e.preventDefault();
        }
        $('.inner-menu-filter .menu li').removeClass('active');
        $(this).parent().addClass('active');
        if ($(this).attr('data-ajax') != undefined) {
            getNewsItems($(this), $('.inner-content-list').attr('id'), true);
            e.preventDefault();
        }
    });
    
    $(document).on('submit', '#main-feedback-form', function(e) {
        var curForm = $(this);
        $.ajax({
            type: 'POST',
            url: curForm.attr('data-ajax'),
            data: curForm.serialize(),
            success: function(data){
                $('.feedback-container').replaceWith(data);
            }
        });
        e.preventDefault();
    });
    
    $(document).on('submit', '.custom_iblock_add, .fancybox-block-form, #subscribe-edit form', function(e) {
        var curForm = $(this);
        var curBlock = $(this).parents('.fancybox-block');
        if (curForm.attr('data-ajax') != undefined) {
            if ($(curForm).parents('#service-order').length > 0) {
                $('#service-order input[data-property-code=PROPERTY_SERVICE]').val($('h1').html());
            }
            $.ajax({
                type: 'POST',
                url: curForm.attr('data-ajax'),
                data: curForm.serialize(),
                success: function(data){
                    curBlock.html($(data).html());
                }
            });
            e.preventDefault();
        }
    });
    
    $(document).on('submit', '#login-static form, #login form, #registration-static form, #registration form, #forgot form, #change form, #confirmation form', function(e) {
        var curForm = $(this);
        var curBlock = $(this).parents('.fancybox-block');
        $.ajax({
            type: 'POST',
            url: curForm.attr('data-ajax'),
            data: curForm.serialize(),
            success: function(data){
                curBlock.find('.callout.error').remove();
                var result = $(data).find('.fancybox-block-result').html();
                if (result !== undefined) {
                    curBlock.append(result);
                } else {
                    var resultForm = $(data).find("#" + curBlock.attr('id')).html();
                    if (resultForm == undefined) {
                        window.location.reload();
                    } else {
                        if (curBlock.attr('id') == 'registration' || curBlock.attr('id') == 'registration-static') {
                            var lastName = $(resultForm).find('input[name=USER_LAST_NAME]').val();
                            var name = $(resultForm).find('input[name=USER_NAME]').val();
                        }
                        curBlock.html(resultForm);
                        $(curBlock).find('.fancybox-block-caption').after($(data).find('.error-block').html());
                        initValidate("#" + curBlock.attr('id'));
                    }
                }
            }
        });
        e.preventDefault();
    });
});