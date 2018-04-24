<?php
  global $wpdb;

 $lanID = $_SESSION['landlord'];
 $tenID = $_SESSION['tenant'];

 $proID = ( $proID == '') ? $_SESSION['pro']: $proID;
 $roomID = $_SESSION['roID'];

 if ($proID == '' ){
  ?>
  <script>    
    window.location = "/checklist";
  </script>
  <?php

 }
 


 $query = "SELECT * FROM dzx_property WHERE id LIKE ".$proID;
 $pro_data = $wpdb->get_results($query);
 $pro_data = $pro_data[0];

 $lanData = get_userdata($pro_data->landlord_id);	
 $tenData = get_userdata($pro_data->tenant_id);


?>

<div class="pro-detail">
  <div class="container">
    <div class="row">
      <div class="col">Tenant :
        <?php echo $tenData->first_name;?>
      </div>
      <div class="col">Landlord :
        <?php echo $lanData->first_name;?>
      </div>
    </div>
    <div class="row">
      <div class="col"> Address :
        <?php echo $pro_data->address." ".$pro_data->district." ".$pro_data->city." ".$pro_data->provice." ".$pro_data->zipcode." "?>
      </div>
    </div>
  </div>
</div>


