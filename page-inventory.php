<?php 
/**
 * Template Name: page-inventory
 */

get_header();

include_once( 'inventory-component/inventory-mid-head.php' );


$room_query = "SELECT * FROM dzx_room WHERE property_id LIKE ".$proID;
$rooms = $wpdb->get_results($room_query);

// print_r($rooms); 
$inside_property = "";
$outside_property ="";
foreach ($rooms as $value) {
  if ($value->room_type == 1){
    $inside_property .= "<li class='fer-list' data='".$value->id."'><a href='/inventory/room/'>".$value->name."</a></li>";
  }else{
    $outside_property .= "<li class='fer-list' data='".$value->id."'><a href='/inventory/room/'>".$value->name."</a></li>";
  }

   
}

?>

  <div id="content" class="site-content inventory-page">
    <div class="container">
      <div class="row">
        <div class="checklist-container">
          <div class="row">
            <div class="col">
              <h1 id="property_name">
                <?php echo $pro_data->pro_name ?>
              </h1>
            </div>
          </div>
          <h3 class="toppic toppic-success">Inside Property</h3>
          <div class="furniture">
            <ul class="furniture-list">
              <?php echo $inside_property; ?>
              <!-- <li class="room-insert">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Room Name">
                  <div class="input-group-append btnRoom-new">
                    <span class="input-group-text">
                      <i class="fas fa-plus-square"></i>
                    </span>
                  </div>
                </div>
              </li> -->

            </ul>

          </div>

          <h3 class="toppic toppic-danger">Outside Property</h3>
          <div class="furniture">
            <ul class="furniture-list">
              <?php echo $outside_property; ?>

              <!-- <li class="room-insert">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Room Name">
                  <div class="input-group-append btnRoom-new">
                    <span class="input-group-text">
                      <i class="fas fa-plus-square"></i>
                    </span>
                  </div>
                </div>
              </li> -->
            </ul>
          </div>


        </div>

        <div class="row full center">
          <a href="/report/" type="button" class="btn btn-success btn-lg">Report</a>
        </div>















        <?php get_footer(); ?>