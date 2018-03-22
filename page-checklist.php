<?php 
get_header();
?>

<?php 
    do_action('user_property');
?>

<div class="checklist"> 



  
  <?php 
  if (isusr("administrator")){ 
   do_action('checklist_propertylist');
  }
  ?>


<div id='pro_list'>
  
    <ul id="tenant_data">
      <li class="row_id">Tenant ID : <input type="text" class="<?php  usrClass()?>" name="id" value="" /></li> 
      <li>Tenant Name : <input type="text" class="<?php  usrClass()?>" name="name"  value="" /></li> 
      <li>Address : 
        <input type="text" class="<?php  usrClass()?>" name="address" value="" /> 
        District : <input type="text" class="<?php  usrClass()?>" name="district" value="" /> 
        City : <input type="text" class="<?php  usrClass()?>" name="city" value="" /> 
        Provice : <input type="text" class="<?php  usrClass()?>" name="provice" value=""/> 
        Zippost : <input type="text" class="<?php  usrClass()?>" name="zippost"  maxlength="5" value=""/> 
      </li> 
      <li>Email : <input type="text" class="<?php  usrClass()?>" name="email" value="" /></li>
      <li>Tel. : <input type="text" class="<?php  usrClass()?>" name="phone" value="" /></li>
      <?php if (isusr("administrator")){ 
      ?><button id="tenant_data_update" class="property_btn_update">แก้ไข</button><?php  
      }?>
      
    </ul>
  
  
    <ul id="landlord_data">
      <li class="row_id">Landlord ID : <input type="text" class="<?php  usrClass()?>" name="id" value="" /></li>
      <li>Landlord Name : <input type="text" class="<?php  usrClass()?>" name="name" value="" /></li>
      <li>Email : <input type="text" class="<?php  usrClass()?>" name="email" value="" /></li>
      <li>Tel. : <input type="text" class="<?php  usrClass()?>" name="phone" value="" /></li>   
      <li>Address : 
      <input type="text" class="<?php  usrClass()?>" name="address" value="" /> 
        District : <input type="text" class="<?php  usrClass()?>" name="district" value=""/>  
        City : <input type="text" class="<?php  usrClass()?>" name="city" value="" /> 
        Provice : <input type="text" class="<?php  usrClass()?>" name="provice" value="" /> 
        Zippost : <input type="text" class="<?php  usrClass()?>" name="zippost"  maxlength="5" value=""/> 
      </li>
      <?php if (isusr("administrator")){ 
      ?><button id="landlord_data_update" class="property_btn_update">แก้ไข</button><?php  
      }?>
      
    </ul>
  
  
    <ul id="property_data">
      <li class="row_id">Property ID : <input type="text" class="<?php  usrClass()?>" name="id" value="" /></li>
      <li>Property Name : <input type="text" class="<?php  usrClass()?>" name="pro_name" value="" /></li>
      <li>Property Address : 
        <input type="text" class="<?php  usrClass()?>" name="address" value="" /> 
        District : <input type="text" class="<?php  usrClass()?>" name="district" value="" /> 
        City : <input type="text" class="<?php  usrClass()?>" name="city" value="" /> 
        Provice : <input type="text" class="<?php  usrClass()?>" name="provice" value="" /> 
        Zippost : <input type="text" class="<?php  usrClass()?>" name="zippost" maxlength="5" value=""/> 
      </li>
      <li>Lease start date : <input type="text" class="<?php  usrClass()?>" name="startdate" value="" /></li>
      <li>Lease expire date : <input type="text" class="<?php  usrClass()?>" name="enddate" value="" /></li>      
      <?php if (isusr("administrator")){ 
      ?><button id="property_data_update" class="property_btn_update">แก้ไข</button><?php  
      }?>
    </ul>
  
</div>


</div>



<?php get_footer(); ?>