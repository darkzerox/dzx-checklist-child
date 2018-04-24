<?php 
get_header();

 $lanID = $_SESSION['landlord'];
 $tenID = $_SESSION['tenant'];
 $proID = $_SESSION['pro'];
 $roomID = $_SESSION['roID'];

 if ($proID == '' ){
  ?>
  <script>    
    window.location = "/checklist";
  </script>
  <?php

 }


 $lanData = get_userdata($lanID);	
 $tenData = get_userdata($tenID);
 

global $wpdb;
$query = "SELECT * FROM dzx_property WHERE id LIKE ".$proID;
$pro_data = $wpdb->get_results($query);
$pro_data = $pro_data[0];

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
      <h1><?php echo $pro_data->pro_name ?></h1>
        


<?php


$room_query = "SELECT name,id FROM dzx_room WHERE property_id LIKE ".$proID;
$rooms = $wpdb->get_results($room_query);


foreach ($rooms as $value) {  
   
   ?>
    <div class="row">
          <div class="col">
            <h4 class="toppic toppic-success">
            <?php echo $value->name; ?>
            </h4>
          </div>          
        </div>

   <?php

  $fern_room_query = "SELECT * FROM dzx_furniture WHERE room_id LIKE ".$value->id;
  $ferniture = $wpdb->get_results($fern_room_query);
  // $ferniture = $ferniture[0];
  $ferTableData = "";

  foreach ($ferniture as $value) {

  $fer_img = ($value->image != '') ? "<img class='fer_data fer_img' src=".$value->image." />":"";
  $fer_img_in =  ($value->move_in_img != '') ? "<img class='fer_data fer_img ' src=".$value->move_in_img." />":"";
  $fer_img_out =  ($value->move_out_img != '') ? "<img class='fer_data  fer_img ' src=".$value->move_out_img." />":"";

  $fer_check_in_like = ($value->move_in == 1) ? 'isCheck':'' ;
  $fer_check_in_dislike = ($value->move_in == 0) ? 'isCheck':'' ; 
  $fer_check_out_like = ($value->move_out == 1) ? 'isCheck':'' ;
  $fer_check_out_dislike = ($value->move_out == 0) ? 'isCheck':'' ;


    $ferTableData .="
    <tr field='".$value->id."' room = '".$roomID."' >
        <td><p>".$value->name."</p></td>
        <td>".$fer_img."</td>
        <td> 
          <div class=''>
            <i class='far fa-2x fa-thumbs-up ". $fer_check_in_like ."'></i> <i class='far fa-2x fa-thumbs-down ". $fer_check_in_dislike ."'></i>
            <input class='fer_data fer_check_in' style='display:none' type='text' val=".$value->move_in.">
          </div>
        </td>                    
        <td>".$fer_img_in."</td>
        <td><p>".$value->in_comment."</p></td>
        <td>
          <div class=''>
            <i class='far fa-thumbs-up fa-2x ". $fer_check_out_like ."'></i> <i class='far fa-2x fa-thumbs-down ". $fer_check_out_dislike ."'></i>
            <input class='fer_data fer_check_out' style='display:none' type='text' val=".$value->move_out.">
          </div>
        </td>
        <td>".$fer_img_out."</td>
        <td><p >".$value->out_comment."</p></td>
      </tr>";    
  }

  ?>
  <table class="table-style-dzx">
    <thead>
      <tr>
        <th>Item</th>
        <th>Photo</th>
        <th>Move in</th>
        <th>in photo</th>
        <th>Comment</th>
        <th>Move out</th>
        <th>out photo</th>
        <th>Comment</th>
        
      </tr>
    </thead>
    

    <tbody class="fern_data">
      <?php echo $ferTableData; ?>
      
      </tbody>
  </table>   
  <?php
}
?>

  <div class="row">
    <div class="col-6 text-center">
      <div id="signature-tenant" class="signature-pad">
        <div class="signature-pad--body">
          <img class="tenant_sign_img" src="<?php echo $pro_data->tenant_sign ?> " alt="" />
          <canvas></canvas>
        </div>
        <div class="signature-pad--footer">
          <h4>Tenant</h4>
          <div class="signature-pad--actions">  
            <div class="row flex_center">
              <button type="button" class="btn btn-secondary clear sign-btn" data-action="clear" datarole="tenant">Clear</button> 
              <button type="button" class="btn btn-info save sign-btn" data-action="save-png" datarole="tenant" data-id ="<?php echo $proID ?>" >Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 text-center">
      <div id="signature-landlord" class="signature-pad">
        <div class="signature-pad--body">            
          <img class="landlord_sign_img" src="<?php echo $pro_data->landlord_sign ?> " alt="" />  
          <canvas></canvas>
        </div>
        <div class="signature-pad--footer">
          <h4>Landlord</h4>
          <div class="signature-pad--actions">         
            <div class="row flex_center">
              <button type="button" class="btn btn-secondary clear sign-btn" data-action="clear" datarole="landlord">Clear</button> 
              <button type="button" class="btn btn-info save sign-btn" data-action="save-png" datarole="landlord" data-id ="<?php echo $proID ?>">Save</button>
            </div>
          </div>
         
        </div>
      </div>
    </div>
  </div>







</div>



<?php get_footer(); ?>