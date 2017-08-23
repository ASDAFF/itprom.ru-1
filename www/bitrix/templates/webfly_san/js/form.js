if (window.frameCacheVars !== undefined)
{
  BX.addCustomEvent("onFrameDataReceived" , function(json) {
    console.log("frame received");
    console.log(json);
    init();
  });
} else {
    $(init);
}

	
function tickOffCompareCheckboxes()
{
  var idsStr = $("input#compare_list_items").val();
  if (idsStr)
  {
    var compare_list = $.parseJSON(idsStr.replace(/'/g,"\"")); // json parser doesn't understand symbol '
    for (var i=0; i < compare_list.length; i++)
    {
      $("input[type=checkbox][wf-elem-id="+compare_list[i]+"]").prop("checked","checked");
    }
  }
}



function init() {
  tickOffCompareCheckboxes();
  if ( $('input:checkbox').not(".superIgnore").length > 0)
    var _checkbox = $('input:checkbox').not(".superIgnore").checkbox();
  checkboxStyling('.styledRadio', '.styledLabel');
  $('.styledLabel').on('click', function(e){
    checkboxStyling('.styledRadio', '.styledLabel');
  });
  if ($("input#compare_list_items").length)
  {
    checkbox_change_events($);
    addToBacketEvent($);
    addToBacketAnimationEvent($);
  }
}


$.fn.checkbox = function (o) {
  var callMethod = $.fn.checkbox.method;
  if (typeof o == "string" && o in $.fn.checkbox.method) {
    var checkbox = $(this);
    callMethod[o](checkbox);
    return checkbox;
  }
  if (!("method" in $.fn.checkbox)) {
    $.fn.checkbox.method = {
      "destroy": function (checkbox) {
        if (checkbox.data('customized')) {
          checkbox.off('change.customForms');
          checkbox.each(function () {
            $(this).data('customCheckbox').off('click.customForms').remove();
          });
          checkbox.removeData();
        } else {
          throw new Error('Ошибка!');
        }
      },
      "check": function (checkbox) {
        checkbox.trigger('change.customForms', ['check']);
      },
      "uncheck": function (checkbox) {
        checkbox.trigger('change.customForms', ['uncheck']);
      },
      "toggle": function (checkbox) {
        var method = this;
        checkbox.each(function () {
          if (!$(this).is(':checked')) {
            method.check($(this));
          } else {
            method.uncheck($(this));
          }
        });
      }
    };
    callMethod = $.fn.checkbox.method;
  }
  var checkboxes = [];
  $(this).each(function () {
    if (!$(this).data('customized')) {
      checkboxes.push(this);
    }
  });
  if (!$(this).size()) {
    throw new Error('С объектом ' + $(this).attr("name") + ' произошла ошибка!');
  }
  if (checkboxes.length) {
    o = $.extend({
      "checkboxClass": "checkboxAreaChecked",
      "labelClass": "active",
      "customCheckboxClass": "checkboxArea"
    }, o);
    var customCheckbox = $('<span class="' + o.customCheckboxClass + '"></span>');
    checkboxes = $(checkboxes);
    checkboxes.data('customized', true);
    return checkboxes.each(function () {
      var checkbox = $(this),
              localCustomCheckbox = customCheckbox.clone(),
              checkboxClass = o.checkboxClass,
              labelClass = o.labelClass;
      checkbox.data('customCheckbox', localCustomCheckbox);
      localCustomCheckbox.insertAfter(checkbox);
      if (checkbox.closest('label').size()) {
        checkbox.data('label', checkbox.closest('label'));
      }
      else if (checkbox.attr('id')) {
        checkbox.data('label', $('label[for=' + checkbox.attr('id') + ']'));
      }
      checkbox.on('change.customForms', function (e, command) {
        if (command == "check") {
          check();
        }
        else if (command == "uncheck") {
          uncheck();
        }
        else {
          if (checkbox.is(':checked')) {
            check();
          }
          else {
            uncheck();
          }
        }
      }).trigger('change');
      localCustomCheckbox.on('click.customForms', function (e) {
        if (!localCustomCheckbox.hasClass(checkboxClass)) {
          callMethod.check(checkbox);
        }
        else {
          callMethod.uncheck(checkbox);
        }
        e.preventDefault();
      });
      function check() {
        checkbox.attr('checked', true);
        localCustomCheckbox.addClass(checkboxClass);
        if (checkbox.data('label')) {
          checkbox.data('label').addClass(labelClass);
        }

      }
      function uncheck() {
        checkbox.attr('checked', false);
        localCustomCheckbox.removeClass(checkboxClass);
        if (checkbox.data('label')) {
          checkbox.data('label').removeClass(labelClass);
        }

      }
    });
  } else {
    throw Error('Какая-то ошибка!');
  }
};

function checkboxStyling(checkbox, container) {
 if($(checkbox).length) {
  $(checkbox).each(function() {
   var elem = $(this);
   var parent = elem.parents(container);
   if(elem.is(':checked'))
    parent.addClass('checked');
   else
    parent.removeClass('checked');
  })
  return $(checkbox);
 }
}