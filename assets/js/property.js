(function ($, $window, $document) {

  $document.ajaxComplete(function () {
    $('#property_list , #property_report_list').selectpicker('destroy').selectpicker({
      liveSearch: true,
      title: 'Please select',
    });
    $('.dropdown-menu li[data-original-index="1"]').hide();
    if (!$('body').hasClass('wp-admin')) {
      $('.data-list .dropdown-menu li').click(function () {
        $('#property_data_dialog').modal('show');
      })

    }
  

    //search property click
    $('.bootstrap-select').click(function () {
      if ($(this).find('.dropdown-menu').hasClass('show')) {
        $(this).find('.dropdown-menu').removeClass('show');
      } else {
        $(this).find('.dropdown-menu').addClass('show');
      }
    });

  })
  
  shadow();

  $document.ready(function () {
    

    //get report list for non admin
    if($('body.home').find('#property_report_list').length > 0){
      var uid = $('#property_report_list').attr('uid');
      var utype = $('#property_report_list').attr('uty');
       get_report_list(uid,utype);
      // console.log('aa');
      
    }
    

    //more menu click
    $('.more-menu').click(function(){
      $('.more-menu-item').toggleClass('show');
    });

    //move-in-out-report
    $('.moveInOutReport').click(function () {
      var target = $(this).attr('stype');
      var pro = $(this).attr('pro');
      var title = (target == '0') ? 'Move in Detect Report' : 'Move out Detect Report';

      return $.ajax({
        type: 'POST',
        url: darkxee_plist.callurl,
        data: {
          'action': 'get_report_inout',
          pro,
          target,
        },
        dataType: 'json',
        success: function (data) {
          
          // console.log(data);
          var tbody = '';
          $.each(data, function (key, value) {
            tbody += `<tr><td>${value.room_name}</td>
                          <td>${value.fer_name}</td>
                          <td><img src="${value.img}" /></td>
                          <td>${value.comment}</td></tr>`;
          });
          $('#move_inout_report').html('').append(tbody);
          $('#moveInOutReportTitle').text(title);
          $('#moveInOutReport').modal('show');

        }
      });

    });

    //current menu heightlight
    if ($('body').hasClass('page-template-page-room')) {
      $('.meu-inventory').addClass('current_page_item');
    }

    //report img popup
    $('.page-report .fer_img').click(function () {
      var thisSrc = $(this).attr('src');
      $('.fer_img_pop').attr('src', thisSrc);
      $('#img_pop').modal('show');
    });

    //room click
    $('.furniture-list li.fer-list').click(function (e) {
      e.preventDefault();
      shadow()
      // console.log($(this).text());
      sndsess('roID', $(this).attr('data'));
      sndsess('roN', $(this).text());
      $(this).find('a').css('color', 'rgba(41, 180, 115, 0.27)');
      setTimeout(function () {
        location.href = '/inventory/room/';
      }, 1000)

    });

    // image uploader
    $.wpMediaUploader();

    //new row fern inventroy
    var getRow = $('.fern_data tr:last-child').html();
    var getRoomID = $('.fern_data tr:first-child').attr('room');

    $('.insert_row').click(function () {
      $.ajax({
        type: 'POST',
        url: darkxee_plist.callurl,
        data: {
          'action': 'skele_inventory',
          'room': getRoomID         
        },
        success: function (data) {
         // console.log(data);
          $('.fern_data').append(data);
        }

      });
      

     // $('.fern_data').append("<tr class='new-row' field='-1' room='" + getRoomID + "'>" + getRow + "</tr>");
      
    });

    // ferClickCheck();


    //del fern btn
    $('.btn-del-fern').click(function () {
      var fer_id = "";
      fer_id = $(this).attr('data-val');
      var fer_name = $('.fern_data tr[field=' + fer_id + ']').find('.fer_name').val();
      var fer_img = $('.fern_data tr[field=' + fer_id + ']').find('.fer_data.fer_img').attr('src');
      fer_img = (fer_img === undefined) ? "" : fer_img;

      // console.log(fer_id);


      $('.modal-body.del_fern').html(`<div class="fern-dialog-body center"><p>${fer_name}</p><img src="${fer_img}" /></div>`);
      $('.btn-fern-conf').attr('da', fer_id);

      $('.btn-fern-conf').click(function () {
        fer_id = $(this).attr('da');
        // console.log(fer_id);
        $.ajax({
          type: 'POST',
          url: darkxee_plist.callurl,
          data: {
            'action': 'fern_del',
            'd': fer_id,
          },
          success: function (data) {
            console.log(data);
            $('#del-fern').modal('hide');
            $('.fern_data tr[field=' + fer_id + ']').remove();

          }

        });
      });
    });

    //update ferniture inventory
    $('.update_fern').click(function () {

      var fieldata = [];
      $('.fern_data tr').each(function () {
        var all_row = {};
        all_row.room = $(this).parent().attr('room');
        // console.log(' all_row.room' +  all_row.room);
        all_row.row_1 = $(this).attr('field');
        all_row.row_name = $(this).find('.fer_name').val();
        all_row.row_img = $(this).find('.fer_img .fer_img').attr('src');
        if (all_row.row_img == undefined) {
          all_row.row_img = '';
        }

        all_row.row_check_in = $(this).find('.fer_check.fer_check_in input:checked').val();
        all_row.row_inphoto = $(this).find('.fer_img_in .fer_img').attr('src');
        if (all_row.row_inphoto == undefined) {
          all_row.row_inphoto = '';
        }
        all_row.row_in_comment = $(this).find('.fer_comm_in').val();


        all_row.row_check_out =  $(this).find('.fer_check.fer_check_out input:checked').val();
        all_row.row_outphoto = $(this).find('.fer_img_out .fer_img').attr('src');
        if (all_row.row_outphoto == undefined) {
          all_row.row_outphoto = '';
        }
        all_row.row_out_comment = $(this).find('.fer_comm_out').val();
        all_row.row_date = getDateTime();

        fieldata.push(all_row);

        //  console.log(all_row);
      });


      //console.log(fieldata);

      $.ajax({
        type: 'POST',
        url: darkxee_plist.callurl,
        data: {
          'action': 'fern_insert',
          'd': fieldata,
        },
        success: function (data) {
         // console.log(data);
          // location.reload();
        }

      });


    });

    checklist_reload();

    // $('.property-group  [ac="new"]').click();
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
      if (isAction == 'ch-del') {
        // console.log('chde');
        $('.selepro-btngroup').fadeOut();
        $('.confirm-del').fadeIn();

      }
      if (isAction == 'cancel') {
        $('.selepro-btngroup').fadeIn();
        $('.confirm-del').fadeOut();

      }
      if (isAction == 'del') {
        $('.selepro-btngroup').fadeIn();
        $('.confirm-del').fadeOut();
        delData(isGo, fid);
      }

      // console.log(isGo);


    });

    $('.btn[ac="new"]').click(function () {
      var eleName = $(this).attr('go');
      $('#' + eleName + '-form').find('input').val('');
      $('#' + eleName + '-form .btn').html('<i class="fas fa-save"></i> Save').removeClass('btn-info').addClass('btn-success').attr('ac', 'insert');
      $('#room_lists').html('');
    });

    show_property_list();


    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      todayHighlight: true
    });

  });

  function getRoomList(proid) {
    return $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'getRoom',
        'rid': proid,
      },
      dataType: 'json',
      success: function (data) {
        //  console.log(data)

        var list = `<div class="title-head">
                      <h2>Room</h2>
                    </div><ul pro="${proid}">`;
        $.each(data, function (key, val) {
          var incheck = (val.room_type == 1) ? 'checked' : '';
          var outcheck = (val.room_type == 2) ? 'checked' : '';

          list += `<li ac="old" proid="${proid}" room="${val.id}">
            <input class="room_name" type="text" value="${val.name}"  room="${val.id}" >        
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="roomPositon-${val.id}" id="room_${val.id}-1" value="1" ${incheck}>
              <label class="form-check-label" for="room_${val.id}-1">Inside</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="roomPositon-${val.id}" id="room_${val.id}-2" value="2" ${outcheck}>
              <label class="form-check-label" for="room_${val.id}-2">Outside </label>
            </div>
            <div class="room-del inline"><button class="btn btn-danger btn-sm btn-del-room" type="room" rid="${val.id}"><i class="fas fa-trash-alt "></i></button></div>
          </li>`;
        });
        list += `</ul>
        <button class="btn btn-info btn-sm insert_row_room"><i class="fas fa-plus"></i></button> 
        <button class="btn btn-success btn-sm save_row_room"><i class="fas fa-save"></i> Save</button>`;
        $('#room_lists').html(list);

        

        $('#room_lists li').change(function(){
          $(this).attr('ac','change');
          // $(this).change(function(){
           
          // })
          
        })

        $('.insert_row_room').click(function () {
          $('#room_lists ul').append(moreInput());

          
        });
        
        admin_room_del();
        admin_room_update();
       
      }
    });

  }
  function randomSTR(){
    var value = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 5; i++) {
      value += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return value;
  }

  var moreInput = function () {
    var value = randomSTR();

    //var value = Math.floor(Math.random()*1E16);
    return `<li ac="new" radio_val = "${value}"><input class="room_name" type="text">        
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="roomPositon-${value}" id ="roomPositon-${value}-1" value="1" checked>
      <label class="form-check-label" for="roomPositon-${value}-1">Inside</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="roomPositon-${value}" id ="roomPositon-${value}-2" value="2">
      <label class="form-check-label" for="roomPositon-${value}-2">Outside </label>
    </div>
    </li>`;
  }

  function checklist_reload() {
    get_list_data('property', 'property_list'); 
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

  function get_report_list(uid,uty) {
    return $.ajax({
      type: 'POST',
      url: darkxee_plist.callurl,
      data: {
        'action': 'getReportList',
        uid,
        uty
      },
      dataType: 'json',
      success: function (data) {
        console.log(data)
        var select_data = `<option value="-99">Select My Property</option>`;

        $.each(data, function (key, value) {
          select_data += `<option value="${value.id}" data-tokens="${value.pro_id} ${value.pro_name}" data-subtext="${value.pro_id}" data-key="${value.linkkey}">${value.pro_name}</option>`
        });

        $('#property_report_list option').not('.non-select').remove();
        $('#property_report_list ').append(select_data);

        $('.report-data-list ').change(function () {
          var thiskey = $('#property_report_list option:selected').attr('data-key');
          console.log(thiskey);
          window.location.replace("/report/?d="+thiskey);
        })
      }
    });
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
          console.log('select click');
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
      $('#' + eleName + '-form .btn').html('<i class="fas fa-save"></i> Update').removeClass('btn-info').addClass('btn-success').attr('ac', 'update');
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

              //get room list
              if ($('body').hasClass('wp-admin')) {
                getRoomList(data.id);
              }



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


              if (!$('body').hasClass('wp-admin')) {
                $('#property_data_dialog').modal('show');
              }



            }

          }
        });
      } else {
        // console.log('out scop');
        $('#' + eleName + '-form').find('input').val('');
        $('#' + eleName + '-form .btn').text('Save').removeClass('btn-primary').addClass('btn-info').attr('ac', 'insert');
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
        msgState(data);
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
          
        } 
       
      }

    });
  }


  function msgState(ch){
    var state_msg;
    if (ch){
      state_msg = `<div class="msg-state"><div class="alert alert-success" role="alert">Success</div></div>`;
    }else{
      state_msg = `<div class="msg-state"><div class="alert alert-danger" role="alert">Fail</div></div>`;
    }
    $('.msg-state').remove();
    $('body').append(state_msg);
    $('.msg-state').fadeIn('fast').delay(3000).fadeOut('fast');
    // return state_msg;
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
        
        msgState(data);
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
         
        }


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
        msgState(data)    
        if (data == 1) {
          $('#' + table + '-form input').val('');
          checklist_reload();
          
        } 
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

  function getDateTime() {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
      (('' + month).length < 2 ? '0' : '') + month + '-' +
      (('' + day).length < 2 ? '0' : '') + day + ' ' + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

    return output;
  }





  //signature
  $document.ready(function () {

    var savePNGButton = ''
    var clearButton_tenant;
    var clearButton_landlord;
    if ($.find('.signature-pad').length > 0) {

      var wrapper_tenant = document.getElementById("signature-tenant");
      clearButton_tenant = wrapper_tenant.querySelector("[data-action=clear]");
      savePNGButton = wrapper_tenant.querySelector("[data-action=save-png]");

      var canvas_tenant = wrapper_tenant.querySelector("canvas");
      canvas_tenant.width = '700';
      canvas_tenant.height = '320';
      var signaturePad_tenant = new SignaturePad(canvas_tenant, {
        backgroundColor: 'rgb(255, 255, 255)'
      });

      var wrapper_landlord = document.getElementById("signature-landlord");
      clearButton_landlord = wrapper_landlord.querySelector("[data-action=clear]");
      savePNGButton = wrapper_landlord.querySelector("[data-action=save-png]");

      var canvas_landlord = wrapper_landlord.querySelector("canvas");
      canvas_landlord.width = '700';
      canvas_landlord.height = '320';
      var signaturePad_landlord = new SignaturePad(canvas_landlord, {
        backgroundColor: 'rgb(255, 255, 255)'
      });

    }

    function resizeCanvas() {
      var ratio = Math.max(window.devicePixelRatio || 1, 1);
      // This part causes the canvas to be cleared
      canvas_tenant.width = canvas_tenant.offsetWidth * ratio;
      canvas_tenant.height = canvas_tenant.offsetHeight * ratio;
      canvas_tenant.getContext("2d").scale(ratio, ratio);
      signaturePad_tenant.clear();

      canvas_landlord.width = canvas_landlord.offsetWidth * ratio;
      canvas_landlord.height = canvas_landlord.offsetHeight * ratio;
      canvas_landlord.getContext("2d").scale(ratio, ratio);

      signaturePad_landlord.clear();
    }

    function dataURLToBlob(dataURL) {

      var parts = dataURL.split(';base64,');
      var contentType = parts[0].split(":")[1];
      var raw = window.atob(parts[1]);
      var rawLength = raw.length;
      var uInt8Array = new Uint8Array(rawLength);

      for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
      }

      return new Blob([uInt8Array], {
        type: contentType
      });
    }

    if ($.find('.signature-pad').length > 0) {

      // window.onresize = resizeCanvas;
      // resizeCanvas();


      $('.sign-btn').click(function () {
        
        var thisBtn = $(this);
        var data = thisBtn.attr('data-action');
        var dataRole = thisBtn.attr('datarole');
        var dataID = thisBtn.attr('data-id');
        var dataURL = '';

        if (data == "clear") {
          $('.save.sign-btn').addClass('btn-info').removeClass('btn-success').text('save');
          if (dataRole == 'landlord') {
            signaturePad_landlord.clear();
          }
          if (dataRole == 'tenant') {
            signaturePad_tenant.clear();
          }
        }

        if (data == "save-png") {

          
          
          // console.log(dataRole);     


          if (dataRole == 'landlord') {
            if (!signaturePad_landlord.isEmpty()) {
              dataURL = signaturePad_landlord.toDataURL();
            } else {
              alert("Please provide a signature first.");
            }
          }
          if (dataRole == 'tenant') {
            if (!signaturePad_tenant.isEmpty()) {
              dataURL = signaturePad_tenant.toDataURL();
            } else {
              alert("Please provide a signature first.");
            }
          }



          // var blob = dataURLToBlob(dataURL);
          // // var blobUrl = URL.createObjectURL(blob);
          // console.log(dataURL);

          var formData = new FormData();
          formData.append('action', 'add_sign');
          formData.append('bs', dataURL);
          formData.append('rid', dataID);
          formData.append('rs', dataRole);

          if (dataURL != '') {
            shadow();
            $.ajax({
              type: 'POST',
              url: darkxee_plist.callurl,
              data: formData,
              processData: false,
              contentType: false,
              success: function (data) {
                thisBtn.removeClass('btn-info').addClass('btn-success').text('Success');
                $('.' + dataRole + '_sign_img').attr('src', dataURL);

                $('#' + dataRole + '_signture_dialog').modal('hide');
              }
            });
          }


        }

      })


    }
    //End signature

  });



  function admin_room_update() {
    //admin insert update room
    $('.save_row_room').click(function () {
      var abjData = [];
      var proid = $('#room_lists ul').attr('pro');      
      $('#room_lists li').each(function(){
          var roomObj = {}
          roomObj.roomName = $(this).find('.room_name').val();
          roomObj.roomID = $(this).attr('room');
          roomObj.roomType = $(this).find('input.form-check-input:checked').val();
          roomObj.acType = $(this).attr('ac');
          roomObj.proID = proid;
          if (roomObj.roomName != ''){
            abjData.push(roomObj);
          }
          
         
      })
    //  console.log(abjData);

      $.ajax({
        type: 'POST',
        url: darkxee_plist.callurl,
        data: {
          'action': 'updateRoom',
          'd': abjData,
        },
       // dataType: 'json',
        success: function (data) {
          //  console.log(data)  
          msgState(data);
           
            // reload 
            getRoomList(proid);     
        }
      });


      
      
    });
  }

  function admin_room_del(){
    $('.btn-del-room').click(function(){
      
      var rid = $(this).attr('rid');
      delData('room', rid);
      $(this).parent().parent().fadeOut("normal", function() {
        $(this).remove();
      });
    });
  }

  function ferClickCheck(){    
    //ferniture check event
    $('.fer_check').each(function () {
      $(this).click(function(){
        console.log('cc');
      $(this).find('svg').toggleClass('isCheck');
      var ischeck = $(this).find('input').attr('val');
      if (ischeck == 0) {
        $(this).find('input').attr('val', 1);
      } else {
        $(this).find('input').attr('val', 0);
      }
      });
      

    });
  }


  function shadow(){
    $('.shadow-load').fadeIn()
    $window.load(function () {     
      $('.shadow-load').fadeOut();

    });
    $document.ajaxComplete(function () {
      $('.shadow-load').fadeOut();      
    });

  }

})(jQuery, jQuery(window), jQuery(document));