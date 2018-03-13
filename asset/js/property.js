(function ($, $window, $document) {

  $document.ready(function () {

    show_property_list();



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
            <li>Tenant ID : <input type="text" class="edit-data" name="id"  value="${data.tenant_id}" /></li> 
            <li>Tenant Name : <input type="text" class="edit-data" name="name"  value="" /></li> 
            <li>Address : 
              <input type="text" class="edit-data" name="address" value="" /> 
              <input type="text" class="edit-data" name="district" value="" /> 
              <input type="text" class="edit-data" name="city" value="" /> 
              <input type="text" class="edit-data" name="provice" value=""/> 
              <input type="text" class="edit-data" name="zippost" value=""/> 
            </li> 
            <li>Email : <input type="text" class="edit-data" name="email" value="" /></li>
            <li>Tel. : <input type="text" class="edit-data" name="phone" value="" /></li>
            <button id="tenant_data_update" class="property_btn_update">Update</button>
          </ul>
          
          <ul id="landlord_data">
            <li>Landlord ID : <input type="text" class="edit-data" name="id" value="${data.landlord_id}" /></li>
            <li>Landlord Name : <input type="text" class="edit-data" name="name" value="" /></li>
            <li>Email : <input type="text" class="edit-data" name="email" value="" /></li>
            <li>Tel. : <input type="text" class="edit-data" name="phone" value="" /></li>   
            <li>Address : 
              <input type="text" class="edit-data" name="address" value="" /> 
              <input type="text" class="edit-data" name="district" value=""/>  
              <input type="text" class="edit-data" name="city" value="" /> 
              <input type="text" class="edit-data" name="provice" value="" /> 
              <input type="text" class="edit-data" name="zippost" value=""/> 
            </li>
            <button id="landlord_data_update" class="property_btn_update">Update</button>
          </ul>

          <ul id="property_data">
            <li>Property ID : <input type="text" class="edit-data" name="id" value="${data.id}" /></li>
            <li>Property Name : <input type="text" class="edit-data" name="pro_name" value="${data.pro_name}" /></li>
            <li>Property Address : 
              <input type="text" class="edit-data" name="address" value="${data.address}" /> 
              <input type="text" class="edit-data" name="district" value="${data.district}" /> 
              <input type="text" class="edit-data" name="city" value="${data.city}" /> 
              <input type="text" class="edit-data" name="provice" value="${data.provice}" /> 
              <input type="text" class="edit-data" name="zippost" value="${data.zippost}"/> 
            </li>
            <li>Lease start date : <input type="text" class="edit-data" name="startdate" value="${data.startdate}" /></li>
            <li>Lease expire date : <input type="text" class="edit-data" name="enddate" value="${data.enddate}" /></li>
            <button id="property_data_update" class="property_btn_update">Update</button>
          </ul>

          `;

          showHtml += "</div>";

          get_people('landlord',data.landlord_id);
          get_people('tenant',data.tenant_id);


          $('#pro_list').remove();
          $(showHtml).insertAfter('.checklist');

          

          //update btn
          $('.property_btn_update').click(function () {
            var formData = $(this).parent().find('.edit-data');
            var table = $(this).parent('ul').attr('id').split('_');
            table = table[0];
            var attr = [];
            formData.each(function () {
              var thisField = $(this).attr('name');
              var thisVal = $(this).val();

              attr.push({field:thisField ,val:thisVal});

            })
            // console.log(attr);
            updateData(table, attr);

            // edit input inline
            $('.edit-data').on('input', function () {
              var inputWidth = $(this).textWidth();
              $(this).css({
                width: inputWidth + 10
              })
            }).trigger('input');


          });



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

  function get_people(table,id){
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
        data = data[0];
        //  console.log(data);
        var ele = "#"+table+"_data input";
        // console.log(ele);
          $(ele).each(function(){
            var ele_name = $(this).attr("name");
            console.log(data[ele_name]);
            
              // console.log (data[ele_name]);
             $(this).val(data[ele_name])
          });
      }

    });
  }



  var targetElem = $('.edit-data');
  inputWidth(targetElem);

  function inputWidth(elem, minW, maxW) {
    elem = $(this);
    // console.log(elem)
  }

  $.fn.textWidth = function (text, font) {
    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
  };


  function dataCheck(data){
    if (data != undefined){
      return data;
    }else{
      return "";
    }
  }

})(jQuery, jQuery(window), jQuery(document));