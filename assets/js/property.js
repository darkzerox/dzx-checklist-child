(function ($, $window, $document) {

  $(document).ajaxComplete(function () {
    $('#property_list').selectpicker('destroy').selectpicker({
      liveSearch: true,
      title: 'Please select',
    });

  })

  $document.ready(function () {

    // image uploader
    $.wpMediaUploader();

    //new row fern inventroy
    var getRow = $('.fern_data tr:last-child').html();
    var getRoomID = $('.fern_data tr:first-child').attr('room');
    $('.insert_row').click(function(){       
      // console.log(getRow);
      $('.fern_data').append("<tr class='new-row' field='-1' room='"+getRoomID+"'>"+getRow+"</tr>");
      
    });


    //ferniture check event
    $('.fer_check').click(function(){
      $(this).find('svg').toggleClass('isCheck');
       
      var ischeck = $(this).find('input').attr('val');  
      
      if (ischeck == 0){
        $(this).find('input').attr('val',1);
      }else{
        $(this).find('input').attr('val',0);  
      }
      
    });

    //update ferniture inventory
    $('.update_fern').click(function(){
      
      var fieldata=[];
      
      $('.fern_data tr').each(function(){
        var all_row = {};
          all_row.room = $(this).attr('room');
          all_row.row_1 = $(this).attr('field');
          all_row.row_name = $(this).find('.fer_name').val();
          all_row.row_img = $(this).find('.fer_img .fer_img').attr('src');
          if (all_row.row_img == undefined) {
            all_row.row_img = '';
          }

          all_row.row_check_in = $(this).find('.fer_check_in').attr('val');
          all_row.row_inphoto = $(this).find('.fer_img_in .fer_img').attr('src');
          if (all_row.row_inphoto == undefined) {
            all_row.row_inphoto = '';
          }
          all_row.row_in_comment = $(this).find('.fer_comm_in').val();


          all_row.row_check_out = $(this).find('.fer_check_out').attr('val');
          all_row.row_outphoto = $(this).find('.fer_img_out .fer_img').attr('src');
          if (all_row.row_outphoto == undefined) {
            all_row.row_outphoto = '';
          }
          all_row.row_out_comment = $(this).find('.fer_comm_out').val();

          fieldata.push(all_row);

        // console.log(all_row);
      });
      console.log(fieldata);
      
    });


    

    
    checklist_reload();

    $('.property-group .btn').click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      var isGo = $(this).attr('go');
      var isAction = $(this).attr('ac');
      var fid = $(this).attr('fid');
      if (isAction == 'update') {
        getform_data(isGo + '-form', isGo, 'update');
      }
      if (isAction == 'insert') {
        // console.log('insert event');
        getform_data(isGo + '-form', isGo, 'insert')
      }
      if (isAction == 'del') {
        // console.log('del event');
        // console.log(isGo);

        delData(isGo, fid);
      }

      // console.log(isGo);


    });

    $('.btn[ac="new"]').click(function () {
      var eleName = $(this).attr('go');
      $('#' + eleName + '-form').find('input').val('');
      $('#' + eleName + '-form .btn').text('Insert').removeClass('btn-primary').addClass('btn-info').attr('ac', 'insert');
    });

    show_property_list();


    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      todayHighlight: true
    });
 

    //room click
    $('.furniture-list li').click(function () {
      // console.log($(this).text());
      sndsess('roID', $(this).attr('data'));
      sndsess('roN', $(this).text());



    });



  });

  function checklist_reload() {
    get_list_data('property', 'property_list');
    // get_list_data('tenant', 'tenant_list');
    // get_list_data('landlord', 'landlord_list');

  }

  function getform_data(form, table, state) {
    var formData = $("#" + form).serializeArray();
    if (state == 'update') {
      updateData(table, formData);
    }
    if (state == 'insert') {
      insertData(table, formData);
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
        var select_data = `<option value="-99">Select Property</option>`;


        $.each(data, function (key, value) {
          select_data += `<option value="${value.id}" data-tokens="${value.pro_id} ${value[field]}" data-subtext="${value.pro_id}">${value[field]}</option>`
        });

        $('#' + ele + " option").not('.non-select').remove();
        $('#' + ele).append(select_data);

        if (field == 'name') {
          $('#input_' + attr + " option").not('.non-select').remove();
          $('#input_' + attr).append(select_data);
        }



        $('.bootstrap-select').click(function () {
          if ($(this).find('.dropdown-menu').hasClass('show')) {
            $(this).find('.dropdown-menu').removeClass('show');
          } else {
            $(this).find('.dropdown-menu').addClass('show');
          }
        });


      }
    });


  }

  function show_property_list() {

    $('.data-list').change(function () {
      var thisForm = $(this);
      var eleName = $(this).attr('data');
      var thisVal = $(this).val();
      $('.btn[ac="del"]').attr('fid', thisVal);
      $('#' + eleName + '-form .btn').text('Update').removeClass('btn-info').addClass('btn-primary').attr('ac', 'update');
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

            if (thisForm.hasClass('page-data-list')) {
              $('#property_data_dialog_title').text(data.pro_name);
              $('#property_data_dialog #pro_address').text(data.address);
              $('#property_data_dialog #pro_district').text(data.district);
              $('#property_data_dialog #pro_city').text(data.city);
              $('#property_data_dialog #pro_provice').text(data.provice);
              $('#property_data_dialog #pro_zipcode').text(data.zipcode);

              $('#property_data_dialog #pro_start').text(data.startdate);
              $('#property_data_dialog #pro_end').text(data.enddate);

              $.ajax({
                type: 'POST',
                url: darkxee_plist.callurl,
                data: {
                  'action': 'getuserData',
                  'id': data.landlord_id,
                  'type': 'landlord'
                },
                success: function (data) {
                  data = JSON.parse(data);
                  // console.log(data);
                  if (data.nickname[0] != "admin") {
                    if ('first_name' in data) $('#property_data_dialog #landlord_name').text(data.first_name[0]);
                    if ('address' in data) $('#property_data_dialog #landlord_address').text(data.address[0]);
                    if ('district' in data) $('#property_data_dialog #landlord_district').text(data.district[0]);
                    if ('city' in data) $('#property_data_dialog #landlord_city').text(data.city[0]);
                    if ('provice' in data) $('#property_data_dialog #landlord_provice').text(data.provice[0]);
                    if ('zipcode' in data) $('#property_data_dialog #landlord_zipcode').text(data.zipcode[0]);
                    if ('phone' in data) $('#property_data_dialog #landlord_tel').text(data.phone[0]);
                    if ('email' in data) $('#property_data_dialog #landlord_email').text(data.email);
                  }
                }
              });

              $.ajax({
                type: 'POST',
                url: darkxee_plist.callurl,
                data: {
                  'action': 'getuserData',
                  'id': data.tenant_id,
                  'type': 'tenant'
                },
                success: function (data) {
                  data = JSON.parse(data);
                  // console.log(data);
                  if (data.nickname[0] != "admin") {

                    if ('first_name' in data) $('#property_data_dialog #tenant_name').text(data.first_name[0]);
                    if ('address' in data) $('#property_data_dialog #tenant_address').text(data.address[0]);
                    if ('district' in data) $('#property_data_dialog #tenant_district').text(data.district[0]);
                    if ('city' in data) $('#property_data_dialog #tenant_city').text(data.city[0]);
                    if ('provice' in data) $('#property_data_dialog #tenant_provice').text(data.provice[0]);
                    if ('zipcode' in data) $('#property_data_dialog #tenant_zipcode').text(data.zipcode[0]);
                    if ('phone' in data) $('#property_data_dialog #tenant_tel').text(data.phone[0]);
                    if ('email' in data) $('#property_data_dialog #tenant_email').text(data.email);
                  }
                }
              });

              $('#btnInventory').click();
            }

          }
        });
      } else {
        // console.log('out scop');
        $('#' + eleName + '-form').find('input').val('');
        $('#' + eleName + '-form .btn').text('Insert').removeClass('btn-primary').addClass('btn-info').attr('ac', 'insert');
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

  function delData(table, id) {
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'checklist_del_table',
        'tid': id,
        'tn': table
      },
      success: function (data) {
        // console.log(data);
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






  function sndsess(n, v) {
    $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'build_sess',
        'sName': n,
        'sVal': v
      }
    });

  }





})(jQuery, jQuery(window), jQuery(document));