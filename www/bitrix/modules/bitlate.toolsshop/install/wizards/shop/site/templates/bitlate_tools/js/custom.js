function hidePicker($primary, $secondary, $target){
    $target.addClass('change');

    if ($primary.hasClass('change') && $secondary.hasClass('change')) {
        $('.colorpicker-icon').addClass('checked');
        $('.radio-color input[type="radio"]').prop('checked', false);
        applyChange();
    }
}

function applyChange(){
    $.fancybox.helpers.overlay.open({
        closeClick: false,
        parent: $('body')
    });
    $.fancybox.showLoading();
}

function showCustomTooltip(){
    setTimeout(function(){
        if ($('html').hasClass('slideout-open')) {
            showCustomTooltip();
        } else {
            var $toggle = $('#custom-menu .toggle');
            if ($toggle.attr('data-toggle') !== undefined) {
                $toggle.foundation('show');
            }
        }
    }, 3000);
}

$(document).ready(function(){
    if ($("#custom-menu").length > 0) {
        showCustomTooltip();
        
        if (window.BX !== undefined) {
            BX.ready(function(){
                var $customMenu = $('#custom-menu'),
                    customMenuHeight = $customMenu.find('.body').innerHeight() + 46,
                    BxPanel = BX.admin.panel;
                window.customCalc = function(){
                    var bxPanelHeight = BxPanel.DIV.clientHeight,
                        calcHeight = (customMenuHeight + bxPanelHeight > window.innerHeight) ? window.innerHeight - bxPanelHeight : customMenuHeight;

                    if (window.pageYOffset >= bxPanelHeight && BxPanel.isFixed() === false) {
                        $customMenu.css('top', 0);
                    } else if (BxPanel.isFixed() === true) {
                        $customMenu.css('top', bxPanelHeight);
                    } else {
                        $customMenu.css('top', bxPanelHeight - window.pageYOffset);
                    }
                    $customMenu.height($customMenu.hasClass('active') ? calcHeight : 46);
                };
                if($customMenu.length){
                    $customMenu.addClass('bx-panel-active');
                    customCalc();
                    window.onscroll = customCalc;
                    window.onresize = customCalc;
                    BX.addCustomEvent('onTopPanelCollapse',BX.delegate(customCalc,this));
                    BX.addCustomEvent('onTopPanelFix',BX.delegate(customCalc,this));
                }
            });
        }
    }

    $(document).on('click', '#custom-menu .toggle', function(){
        var $self = $(this);
        if ($self.attr('data-toggle') !== undefined) {
            $(this).foundation('hide');
        }
        $('#custom-menu').toggleClass('active').promise().done(function(){
            if (window.customCalc !== undefined) {
                customCalc();
            }
        });
    });
    
    $('#custom-menu .toggle').on('hide.zf.tooltip', function(){
        $(this).foundation('destroy');
    });

    $(document).on('change', '.custom-option:not(.jq-selectbox)', function(){
        window.location.href = $(this).val();
        applyChange();
    });
});