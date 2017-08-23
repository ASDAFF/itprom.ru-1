function wfJTitleSearch(arParams){
  var that = this;
  this.arParams = {
    'AJAX_PAGE': arParams.AJAX_PAGE,
    'CONTAINER_ID': arParams.CONTAINER_ID,
    'INPUT_ID': arParams.INPUT_ID,
    'MIN_QUERY_LEN': parseInt(arParams.MIN_QUERY_LEN),
    'SITE_ID': arParams.SITE_ID,
    'CLEAR_CACHE': arParams.CLEAR_CACHE
  };
  if (arParams.WAIT_IMAGE) this.arParams.WAIT_IMAGE = arParams.WAIT_IMAGE;
  if (arParams.MIN_QUERY_LEN <= 0) arParams.MIN_QUERY_LEN = 1;
  this.cache = [];
  this.cache_key = null;
  this.startText = '';
  this.currentRow = -1;
  this.RESULT = null;
  this.CONTAINER = null;
  this.INPUT = null;
  this.WAIT = null;

  if ($.browser.msie) {
    $("#wft-search form").find("input[type='text']").each(function () {
      var tp = $(this).attr("placeholder");
      that.startText = tp;
      $(this).attr('value', tp).css('color', '#ccc');
    }).focusin(function () {
      var val = $(this).attr('placeholder');
      if ($(this).val() == val) {
        $(this).attr('value', '').css('color', '#303030');
      }
    }).focusout(function () {
      var val = $(this).attr('placeholder');
      if ($(this).val() == "") {
        $(this).attr('value', val).css('color', '#ccc');
      }
    });

    $("#wft-search form").submit(function () {
      $(this).find("input[type='text']").each(function () {
        var val = $(this).attr('placeholder');
        if ($(this).val() == val) {
          $(this).attr('value', '');
        }
      })
    });
  }

  this.ShowResult = function (result){
    var pos = BX.pos(that.INPUT);
    pos.width = pos.right - pos.left;
    that.RESULT.style.position = 'absolute';
    that.RESULT.style.top = (pos.bottom) + 'px';
    if (result != null) {
      result = $.trim(result);
      if (result.length > 0) {
        that.RESULT.innerHTML = result;
        $(that.RESULT).slideDown(500, this.checkHeight);
        that.add2basketHandler();
      }
      else $(that.RESULT).hide();
    }
    else $(that.RESULT).slideUp(500);
    if (pos.left + $(that.RESULT).width() >= $(window).width()) {
      that.RESULT.style.right = $(window).width() - pos.right + 'px';
      that.RESULT.style.left = null;
    } else {
      that.RESULT.style.left = pos.left + 'px';
      that.RESULT.style.right = null;
    }
    //ajust left column to be an outline
    var th;
    var tbl = BX.findChild(that.RESULT, {'tag': 'table', 'class': 'wft-search-result'}, true);
    if (tbl)
      th = BX.findChild(tbl, {'tag': 'th'}, true);
    if (th){
      var tbl_pos = BX.pos(tbl);
      tbl_pos.width = tbl_pos.right - tbl_pos.left;

      var th_pos = BX.pos(th);
      th_pos.width = th_pos.right - th_pos.left;
      th.style.width = th_pos.width + 'px';

      that.RESULT.style.width = (pos.width + th_pos.width) + 'px';

      //Move table to left by width of the first column
      that.RESULT.style.left = (pos.left - th_pos.width - 1) + 'px';

      //Shrink table when it's too wide
      if ((tbl_pos.width - th_pos.width) > pos.width)
        that.RESULT.style.width = (pos.width + th_pos.width - 1) + 'px';

      //Check if table is too wide and shrink result div to it's width
      tbl_pos = BX.pos(tbl);
      var res_pos = BX.pos(that.RESULT);
      if (res_pos.right > tbl_pos.right)
      {
        that.RESULT.style.width = (tbl_pos.right - tbl_pos.left) + 'px';
      }
    }

    var fade;
    if (tbl) fade = BX.findChild(that.RESULT, {'class': 'title-search-fader'}, true);
    if (fade && th){
      res_pos = BX.pos(that.RESULT);
      fade.style.left = (res_pos.right - res_pos.left - 18) + 'px';
      fade.style.width = 18 + 'px';
      fade.style.top = 0 + 'px';
      fade.style.height = (res_pos.bottom - res_pos.top) + 'px';
      fade.style.display = 'block';
    }
  };

  this.checkHeight = function () {
    var p = $(that.RESULT);
    p.css('height', 'auto').removeClass('vert-scroll');
    var hw = $(window).height();
    var ht = p.height();
    if (ht > (hw - 200)) {
      p.css('height', hw - 200).addClass('vert-scroll');
    }
  };
  
  this.add2basketHandler = function (){
    var buttons = $(that.RESULT).find(".add2basket");
    buttons.unbind("mouseover");
    buttons.unbind("mouseout");
    buttons.unbind("click");
    buttons.mouseover(function () {
      that.onUnderCursor = true;
    });
    buttons.mouseout(function () {
      that.onUnderCursor = false;
    });
    buttons.click(function () {
      if (!$(this).hasClass('in_basket')) {
        var button = $(this);
        var id = button.attr('id').replace('elem-it-', '');
        var splitData = id.split('-');
        var element_id = splitData[1];
        var obPostParams = {
          'is_ajax_call': 'y',
          'add2basket_srch': 'y',
          'site_id': that.arParams.SITE_ID,
          'id': element_id
        };
        var postUrl = that.arParams.AJAX_PAGE;
        $.post(postUrl, obPostParams, function (result){
          if (result != "error") {
            button.addClass("in_basket");
            button.html(result);
            BX.onCustomEvent('OnBasketChange');
          }
        });
      }
    });
  }

  this.onKeyPress = function (keyCode){
    var tbl = BX.findChild(that.RESULT, {'tag': 'table', 'class': 'wft-search-result'}, true);
    if (!tbl) return false;
    var cnt = tbl.rows.length;
    switch (keyCode){
      case 27: // Esc
        that.RESULT.style.display = 'none';
        that.currentRow = -1;
        that.UnSelectAll();
        return true;
      case 40: // arrowDown
        if (that.RESULT.style.display == 'none')
          that.RESULT.style.display = 'block';
        var first = -1;
        for (var i = 0; i < cnt; i++){
          if (!BX.findChild(tbl.rows[i], {'class': 'title-search-separator'}, true)){
            if (first == -1) first = i;
            if (that.currentRow < i){
              that.currentRow = i;
              break;
            }
            else if (tbl.rows[i].className == 'title-search-selected'){
              tbl.rows[i].className = '';
            }
          }
        }
        if (i == cnt && that.currentRow != i) that.currentRow = first;

        tbl.rows[that.currentRow].className = 'title-search-selected';
        return true;

      case 38:// arrowUp
        if (that.RESULT.style.display == 'none') that.RESULT.style.display = 'block';
        var last = -1;
        for (var i = cnt - 1; i >= 0; i--){
          if (!BX.findChild(tbl.rows[i], {'class': 'title-search-separator'}, true)){
            if (last == -1) last = i;
            if (that.currentRow > i){
              that.currentRow = i;
              break;
            }
            else if (tbl.rows[i].className == 'title-search-selected'){
              tbl.rows[i].className = '';
            }
          }
        }

        if (i < 0 && that.currentRow != i) that.currentRow = last;
        tbl.rows[that.currentRow].className = 'title-search-selected';
        return true;
      case 13: // Enter
        if (that.RESULT.style.display == 'block'){
          for (var i = 0; i < cnt; i++){
            if (that.currentRow == i){
              if (!BX.findChild(tbl.rows[i], {'class': 'title-search-separator'}, true)){
                var a = BX.findChild(tbl.rows[i], {'tag': 'a'}, true);
                if (a){
                  window.location = a.href;
                  return true;
                }
              }
            }
          }
        }
        return false;
    }
    return false;
  }

  this.WAIT_STATUS = false;
  this.loader_obj = $("#wft-search .s_submit");

  this.WAIT_START = function (){
    this.WAIT_STATUS = true;
    that.loader_obj.addClass("loader");
    var loaderSymbols = ['0', '1', '2', '3', '4', '5', '6', '7'], loaderRate = 30, loaderIndex = 0
    var loader = function () {
      that.loader_obj.html(loaderSymbols[loaderIndex]);
      loaderIndex = loaderIndex < loaderSymbols.length - 1 ? loaderIndex + 1 : 0;
      if (that.WAIT_STATUS)
        setTimeout(loader, loaderRate);
      else {
        that.loader_obj.html('&#0035;');
        that.loader_obj.removeClass("loader");
      }
    };
    loader();
  };
  this.WAIT_STOP = function (){
    that.WAIT_STATUS = false;
  };

  this.cat = $('#wft-search select#search_select');

  this.onTimeout = function (){
    if (that.INPUT.value != that.oldValue){
      that.oldValue = that.INPUT.value;
      if (that.INPUT.value.length >= that.arParams.MIN_QUERY_LEN){
        that.cache_key = that.cat.val() + that.INPUT.value;
        if (that.cache[that.cache_key] == null){
          that.WAIT_START();
          var postParams = {
            'is_ajax_call': 'y',
            'cat': that.cat.val(),
            'site_id': that.arParams.SITE_ID,
            'clear_cache': that.arParams.CLEAR_CACHE,
            'red_url': window.location.pathname,
            'q': that.INPUT.value
          };
          $.post(that.arParams.AJAX_PAGE, postParams, function (result){
            that.RESULT.innerHTML = null;
            that.cache[that.cache_key] = result;
            that.ShowResult(result);
            that.currentRow = -1;
            that.EnableMouseEvents();
            that.WAIT_STOP();
            that.onTimeout()
          }
          );
        }else{
          that.ShowResult(that.cache[that.cache_key]);
          that.currentRow = -1;
          that.EnableMouseEvents();
          setTimeout(that.onTimeout, 500);
        }
      }
      else{
        $(that.RESULT).slideUp(300, function () {
          that.RESULT.innerHTML = null;
        });
        that.currentRow = -1;
        that.UnSelectAll();
        setTimeout(that.onTimeout, 500);
      }
    }
    else{
      if (that.INPUT.value == that.startText)
        $(that.RESULT).slideUp(300, function () {
          that.RESULT.innerHTML = null;
        });
      setTimeout(that.onTimeout, 500);
    }
  }

  this.UnSelectAll = function (){
    var tbl = BX.findChild(that.RESULT, {'tag': 'table', 'class': 'wft-search-result'}, true);
    if (tbl){
      var cnt = tbl.rows.length;
      for (var i = 0; i < cnt; i++) tbl.rows[i].className = '';
    }
  }

  this.EnableMouseEvents = function (){
    var tbl = BX.findChild(that.RESULT, {'tag': 'table', 'class': 'wft-search-result'}, true);
    if (tbl){
      var cnt = tbl.rows.length;
      for (var i = 0; i < cnt; i++)
        if (!BX.findChild(tbl.rows[i], {'class': 'title-search-separator'}, true)){
          tbl.rows[i].id = 'row_' + i;
          tbl.rows[i].onmouseover = function (e) {
            if (that.currentRow != this.id.substr(4)){
              that.UnSelectAll();
              this.className = 'title-search-selected';
              that.currentRow = this.id.substr(4);
            }
          };
          tbl.rows[i].onmouseout = function (e) {
            this.className = '';
            that.currentRow = -1;
          };
        }
    }
  }

  this.onFocusGain = function (){
    if (that.INPUT.value.length > 0)
      if ($.trim(that.RESULT.innerHTML).length > 0)
        $(that.RESULT).slideDown(300, this.checkHeight);
  }

  this.onKeyDown = function (e){
    if (!e) e = window.event;
    if (that.RESULT.style.display == 'block'){
      if (that.onKeyPress(e.keyCode)) return BX.PreventDefault(e);
    }
  }

  this.Init = function (){
    this.CONTAINER = document.getElementById(this.arParams.CONTAINER_ID);
    this.RESULT = document.body.appendChild(document.createElement("UL"));
    this.RESULT.className = 'wft-search-result';
    this.INPUT = document.getElementById(this.arParams.INPUT_ID);
    this.startText = this.oldValue = this.INPUT.value;
    BX.bind(this.INPUT, 'focus', function () {
      that.onFocusGain();
    });
    if (BX.browser.IsSafari() || BX.browser.IsIE()) this.INPUT.onkeydown = this.onKeyDown;
    else this.INPUT.onkeypress = this.onKeyDown;
    if (this.arParams.WAIT_IMAGE){
      this.WAIT = document.body.appendChild(document.createElement("DIV"));
      this.WAIT.style.backgroundImage = "url('" + this.arParams.WAIT_IMAGE + "')";
      if (!BX.browser.IsIE())
        this.WAIT.style.backgroundRepeat = 'none';
      this.WAIT.style.display = 'none';
      this.WAIT.style.position = 'absolute';
      this.WAIT.style.zIndex = '1100';
    }

    setTimeout(this.onTimeout, 500);

    function closeIt() {
      $(that.RESULT).slideUp(500);
    }
    $(document).keyup(function (e) {
      if (e.keyCode == 27) // esc
        closeIt();
    });
    this.onUnderCursor = false;
    $('#wft-search').mouseover(function () {
      that.onUnderCursor = true;
    });
    $('#wft-search').mouseout(function () {
      that.onUnderCursor = false;
    });
    $(that.RESULT).mouseover(function () {
      that.onUnderCursor = true;
    });
    $(that.RESULT).mouseout(function () {
      that.onUnderCursor = false;
    });
    $('#fixbody a:not(.wft-search-result a)').on('click', function () {
      if (that.onUnderCursor == false)
        closeIt();
    });
    $(document).on('click', function () {
      if (that.onUnderCursor == false)
        closeIt();
    });
    /*----END LOST FOCUS-----*/
    $(window).resize(function () {
      var p = $(that.RESULT);
      p.css('height', 'auto').removeClass('vert-scroll');
      var hw = $(window).height();
      var ht = p.height();
      if (ht > (hw - 200)) {
        p.css('height', hw - 200).addClass('vert-scroll');
      }
    });
    $('#wft-search .example a').click(function () {
      $('#wft-search-input').attr('value', $(this).html()).focus();
    });
    $("#wft-search .s_submit").click(function () {
      $("#wft-search #search_form").submit();
    });
  };

  BX.ready(function () {
    that.Init(arParams);
  });
}

