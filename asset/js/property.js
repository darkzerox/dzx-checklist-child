(function ($, $window, $document) {

  $document.ready(function () {

    show_property_list();

    $('#tenant_list').change(function () {
      console.log('cj');
      var thisVal = $(this).val();
      get_people('tenant', thisVal);

    });
    $('#landlord_list').change(function () {
      var thisVal = $(this).val();
      get_people('landlord', thisVal);

    });


  });



  function show_property_list() {
    $('#property_list').change(function () {
      //  console.log($(this).val());
      $.ajax({
        type: 'POST',
        url: darkxee_plist.callurl,
        data: {
          'action': 'get_property_detail',
          'pid': $(this).val(),
        },
        success: function (data) {
          //  console.log(data);
          data = JSON.parse(data);
          // console.log(data);

          data = data[0];
          var showHtml = "<div id='pro_list'>";

          showHtml += `
          
          <ul id="tenant_data">
            <li class="row_id">Tenant ID : <input type="text" class="edit-data" name="id"  value="${data.tenant_id}" /></li> 
            <li>Tenant Name : <input type="text" class="edit-data" name="name"  value="" /></li> 
            <li>Address : 
              <input type="text" class="edit-data" name="address" value="" /> 
              <input type="text" class="edit-data" name="district" value="" /> 
              <input type="text" class="edit-data" name="city" value="" /> 
              <input type="text" class="edit-data" name="provice" value=""/> 
              <input type="text" class="edit-data" name="zippost"  maxlength="5" value=""/> 
            </li> 
            <li>Email : <input type="text" class="edit-data" name="email" value="" /></li>
            <li>Tel. : <input type="text" class="edit-data" name="phone" value="" /></li>
            <button id="tenant_data_update" class="property_btn_update">Update</button>
          </ul>
          
          <ul id="landlord_data">
            <li class="row_id">Landlord ID : <input type="text" class="edit-data" name="id" value="${data.landlord_id}" /></li>
            <li>Landlord Name : <input type="text" class="edit-data" name="name" value="" /></li>
            <li>Email : <input type="text" class="edit-data" name="email" value="" /></li>
            <li>Tel. : <input type="text" class="edit-data" name="phone" value="" /></li>   
            <li>Address : 
              <input type="text" class="edit-data" name="address" value="" /> 
              <input type="text" class="edit-data" name="district" value=""/>  
              <input type="text" class="edit-data" name="city" value="" /> 
              <input type="text" class="edit-data" name="provice" value="" /> 
              <input type="text" class="edit-data" name="zippost"  maxlength="5" value=""/> 
            </li>
            <button id="landlord_data_update" class="property_btn_update">Update</button>
          </ul>

          <ul id="property_data">
            <li class="row_id">Property ID : <input type="text" class="edit-data" name="id" value="${data.id}" /></li>
            <li>Property Name : <input type="text" class="edit-data" name="pro_name" value="${data.pro_name}" /></li>
            <li>Property Address : 
              <input type="text" class="edit-data" name="address" value="${data.address}" /> 
              <input type="text" class="edit-data" name="district" value="${data.district}" /> 
              <input type="text" class="edit-data" name="city" value="${data.city}" /> 
              <input type="text" class="edit-data" name="provice" value="${data.provice}" /> 
              <input type="text" class="edit-data" name="zippost" maxlength="5" value="${data.zippost}"/> 
            </li>
            <li>Lease start date : <input type="text" class="edit-data" name="startdate" value="${data.startdate}" /></li>
            <li>Lease expire date : <input type="text" class="edit-data" name="enddate" value="${data.enddate}" /></li>
            <button id="property_data_update" class="property_btn_update">Update</button>
          </ul>

          `;

          showHtml += "</div>";

          get_people('landlord', data.landlord_id);
          get_people('tenant', data.tenant_id);

          $('#pro_list').remove();
          $(showHtml).insertAfter('.checklist');

          $(' #property_data .edit-data ').each(function () {
            $(this).css('width', $(this).textWidth() + 10 + "px");
            $(this).on('mouseenter mouseleave change keydown', function () {
              $(this).css('width', $(this).textWidth() + 10 + "px");
            });
          });


          //update btn
          $('.property_btn_update').click(function () {
            var formData = $(this).parent().find('.edit-data');
            var table = $(this).parent('ul').attr('id').split('_');
            table = table[0];
            console.log(table);
            var attr = [];
            formData.each(function () {
              var thisField = $(this).attr('name');
              var thisVal = $(this).val();

              attr.push({
                field: thisField,
                val: thisVal
              });

            })

            if (table == 'property') {
              attr.push({
                field: 'landlord_id',
                val: $('#landlord_data input[name="id"]').val()
              }, {
                field: 'tenant_id',
                val: $('#tenant_data input[name="id"]').val()
              });
            }

            // console.log(attr);
            updateData(table, attr);

          });
          // $('#property_data_update').click(function(){
          //   $('#tenant_data_update , #landlord_data_update , #property_data_update ').click
          // })


        }
      });
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
        console.log(data);
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