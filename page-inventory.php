<?php 
get_header();

 $lanID = $_SESSION['landlord'];
 $tenID = $_SESSION['tenant'];
 $proID = $_SESSION['pro'];
 $_SESSION['roID'] = "";

 if ($proID == '' ){
  ?>
  <script>    
    window.location = "/checklist";
  </script>
  <?php

 }
 

 $lanData = get_userdata($lanID);	
 $tenData = get_userdata($tenID);

  
//  echo $landData->first_name;
global $wpdb;
$query = "SELECT address, district, city, provice, zipcode FROM dzx_property WHERE id LIKE ".$proID;
$pro_data = $wpdb->get_results($query);
$pro_data = $pro_data[0];

$room_query = "SELECT * FROM dzx_room WHERE property_id LIKE ".$proID;
$rooms = $wpdb->get_results($room_query);

// print_r($rooms); 
$inside_property = "";
$outside_property ="";
foreach ($rooms as $value) {
  if ($value->room_type == 1){
    $inside_property .= "<li data='".$value->id."'><a href='/inventory/room/'>".$value->name."</a></li>";
  }else{
    $outside_property .= "<li data='".$value->id."'><a href='/inventory/room/'>".$value->name."</a></li>";
  }

   
}




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
<div id="content" class="site-content inventory-page">
  <div class="container">
    <div class="row">

      <div class="checklist-container">

        <h3 class="toppic toppic-success">Inside Property</h3>
        <div class="furniture">
          <ul class="furniture-list">
            <?php echo $inside_property; ?>
          </ul>
        </div>

        <h3 class="toppic toppic-danger">Outside Property</h3>
        <div class="furniture">
          <ul class="furniture-list">
          <?php echo $outside_property; ?>
          </ul>
        </div>


      </div>

      <div class="row full center">
        <a href="#" type="button" class="btn btn-success btn-lg">See All</a>
      </div>















      <?php get_footer(); ?>