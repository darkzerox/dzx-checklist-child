(function ($, $window, $document) {

  $document.ready(function () {

    checklist_reload();

    $('.property-group .btn').click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      var isGo = $(this).attr('go');
      var isAction = $(this).attr('ac');
      var fid = $(this).attr('fid');
      if (isAction == 'update') {
        getform_data(isGo + '-form', isGo,'update');
      }
      if (isAction == 'insert'){
        console.log('insert event');
        getform_data(isGo + '-form', isGo,'insert')
      }
      if (isAction == 'del'){
        console.log('del event');
        console.log(isGo);
        
         delData(isGo,fid);
      }

      // console.log(isGo);


    });

    $('.btn[ac="new"]').click(function(){
      var eleName = $(this).attr('go');
      $('#' + eleName + '-form').find('input').val('');
      $('#' + eleName + '-form .btn').text('Insert').removeClass('btn-primary').addClass('btn-info').attr('ac','insert');
    });

    show_property_list();


    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      todayHighlight: true
    });


  });

  function checklist_reload() {
    get_list_data('property', 'property_list');
    get_list_data('tenant', 'tenant_list');
    get_list_data('landlord', 'landlord_list');

  }

  function getform_data(form, table, state) {
    var formData = $("#" + form).serializeArray();    
    if (state == 'update'){
      updateData(table, formData);
    }
    if (state == 'insert'){
      insertData(table,formData);
    }
    
  }

  function get_list_data(attr, ele) {
    return $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'getlList',
        'attr': attr,
      },
      dataType: 'json',
      success: function (data) {
        //  console.log(data)
        var field = "";
        if (attr == 'property') {
          field = 'pro_name';
        } else {
          field = 'name';
        }
        var select_data;
        $.each(data, function (key, value) {
          select_data += `<option value="${value.id}">${value[field]}</option>`
        });

        $('#' + ele + " option").not('.non-select').remove();
        $('#' + ele).append(select_data);
        if (field == 'name') {
          $('#input_' + attr + " option").not('.non-select').remove();
          $('#input_' + attr).append(select_data);
        }

      }
    });


  }

  function show_property_list() {

    $('.data-list').change(function () {
      var eleName = $(this).attr('data');
      var thisVal = $(this).val();
      $('.btn[ac="del"]').attr('fid',thisVal);
      $('#' + eleName + '-form .btn').text('Update').removeClass('btn-info').addClass('btn-primary').attr('ac','update');
      if (thisVal > -1) {
        $.ajax({
          type: 'POST',
          url: darkxee_plist.callurl,
          data: {
            'action': 'get_property_detail',
            'pid': $(this).val(),
            't': eleName,
          },
          dataType: 'json',
          success: function (data) {
            // console.log(data);
            data = data[0];
            $('#' + eleName + '-form .form-control').each(function () {
              var getName = $(this).attr('name');
              $(this).val(data[getName]);
            });
          }
        });
      } else {
        // console.log('out scop');
        $('#' + eleName + '-form').find('input').val('');
        $('#' + eleName + '-form .btn').text('Insert').removeClass('btn-primary').addClass('btn-info').attr('ac','insert');
      }
    });
  }

  function insertData(table, data) {
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'checklist_insert_table',
        'td': data,
        'tn': table
      },
      success: function (data) {
        var state_msg;
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
          state_msg = `<div class="alert alert-success" role="alert">Success</div>`;
        } else {
          state_msg = `<div class="alert alert-danger" role="alert">Fail</div>`;
        }
        $('#' + table + '-form .state ').html(state_msg).fadeIn('fast').delay(3000).fadeOut('fast');
      }

    });
  }

  function updateData(table, data) {
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'checklist_update_table',
        'table_data': data,
        'table_name': table
      },
      success: function (data) {
        var state_msg;
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
          state_msg = `<div class="alert alert-success" role="alert">Success</div>`;
        } else {
          state_msg = `<div class="alert alert-danger" role="alert">Fail</div>`;
        }
        $('#' + table + '-form .state ').html(state_msg).fadeIn('fast').delay(3000).fadeOut('fast');


      }

    });
  }

  function delData(table,id){
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'checklist_del_table',
        'tid': id,
        'tn': table
      },
      success: function (data) {
        console.log(data);
        var state_msg;
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
          state_msg = `<div class="alert alert-success" role="alert">Success</div>`;
        } else {
          state_msg = `<div class="alert alert-danger" role="alert">Fail</div>`;
        }
        $('#' + table + '-form .state ').html(state_msg).fadeIn('fast').delay(3000).fadeOut('fast');


      }

    });
  }



  function get_people(table, id) {
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'get_people',
        'table_name': table,
        'id': id
      },
      success: function (data) {
        data = JSON.parse(data);
        var chData = data.length == 0 ? false : true;
        data = data[0];
        var ele = "#" + table + "_data input";
        var elesele = '#' + table + '_list';
        if (chData) {
          $(elesele).val(data.id);
        } else {
          $(elesele).val(0);
        }

        $(ele).each(function () {
          if (chData) {
            var ele_name = $(this).attr("name");
            $(this).val(data[ele_name]);
          }

          $(this).css('width', $(this).textWidth() + 10 + "px");
          $(this).on('mouseenter mouseleave change keydown', function () {
            $(this).css('width', $(this).textWidth() + 10 + "px");
          });


        });
      }

    });
  }

  $.fn.textWidth = function (text, font) {
    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
  };


})(jQuery, jQuery(window), jQuery(document));