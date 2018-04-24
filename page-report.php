<?php 
/**
 * Template Name: page-report
 */


get_header();
global $cryptKey;

$getProID = $_GET["d"];
$getProID = str_replace(" ","+",$getProID);

if ( $_GET["d"] != '' ){
  $proID =  decryptIt($getProID, $cryptKey);
}else{
  $proID = $_SESSION['pro'];
}

$proID_encrypted = encryptIt($proID, $cryptKey);
$pageLink = get_site_url()."/report/?d=".$proID_encrypted;

include_once( 'inventory-component/inventory-mid-head.php' );

?>
<div id="content" class="site-content inventory-page">
  <div class="container">
    <div class="row">
      <div class="checklist-container">
        <h1 id="property_name">
          <?php echo $pro_data->pro_name ?>
        </h1>

        <?php

        $room_query = "SELECT name,id,room_type FROM dzx_room WHERE property_id LIKE ".$proID." ORDER BY room_type asc";
        $rooms = $wpdb->get_results($room_query);


        if( count($rooms) != 0){
          include_once( 'inventory-component/move-in-out-report.php' );

          foreach ($rooms as $value) {  
            if ($value->room_type == 1){
              $roomClass = "success";
            }else{
              $roomClass = "danger";
            } 
   
            ?>
            <div class="row">
              <div class="col">
                <h4 class="toppic toppic-<?php echo  $roomClass; ?>">
                  <?php echo $value->name; ?>
                </h4>
              </div>
            </div>
            <?php

           
            

            $fern_room_query = "SELECT * FROM dzx_furniture WHERE room_id LIKE ".$value->id." ORDER BY name asc";
            $ferniture = $wpdb->get_results($fern_room_query);
            // $ferniture = $ferniture[0];
            $ferTableData = "";

              foreach ($ferniture as $value) {

                $fer_img = ($value->image != '') ? "<img class='fer_data fer_img' src=".$value->image." />":"";
                $fer_img_in =  ($value->move_in_img != '') ? "<img class='fer_data fer_img ' src=".$value->move_in_img." />":"";
                $fer_img_out =  ($value->move_out_img != '') ? "<img class='fer_data  fer_img ' src=".$value->move_out_img." />":"";

                

                $fer_check_in_like = ($value->move_in == 1) ? '<i class="fa fa-thumbs-up fa-2x"></i>':'<i class="fa fa-thumbs-down fa-2x"></i>' ;              
                $fer_check_out_like = ($value->move_out == 1) ? '<i class="fa fa-thumbs-up fa-2x"></i>':'<i class="fa fa-thumbs-down fa-2x"></i>' ;
                


                $ferTableData .="
                <tr field='".$value->id."'>
                    <td><p>".$value->name."</p></td>
                    <td>".$fer_img."</td>
                    <td> 
                      <div class='check-report'>
                      ".$fer_check_in_like."
                      </div>
                    </td>                    
                    <td>".$fer_img_in."</td>
                    <td><p>".$value->in_comment."</p></td>
                    <td>
                      <div class='check-report'>
                        ".$fer_check_out_like."
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
                    <th class="table-name">Item</th>
                    <th class="table-photo">Photo</th>
                    <th class="table-chood">Move in</th>
                    <th class="table-photo">in photo</th>
                    <th class="table-comment">Comment</th>
                    <th class="table-chood">Move out</th>
                    <th class="table-photo">out photo</th>
                    <th class="table-comment">Comment</th>

                  </tr>
                </thead>


                <tbody class="fern_data">
                  <?php echo $ferTableData;?>
                </tbody>
              </table>
              <?php
          }


          ?>
              <!-- //print new page -->
              <div class="pagebreak"></div>

              <div class="pro-meter">
                <div class="row">
                  <div class="col-12">Electricity meter reading :
                    <?php echo $pro_data->elec_meter ?>
                  </div>
                  <div class="col-12">Water meter reading :
                    <?php echo $pro_data->water_meter ?>
                  </div>

                  <div class="col-12">Lease start date :
                    <?php echo $pro_data->startdate ?>
                  </div>
                  <div class="col-12">Lease expire date :
                    <?php echo $pro_data->enddate ?>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-6 text-center">
                  <img class="tenant_sign_img" src="<?php echo $pro_data->tenant_sign ?> " data-toggle="modal" data-target="#tenant_signture_dialog"
                  />
                  <h5>Tenant</h5>
                  <h4>
                    <?php echo $tenData->first_name; ?>
                  </h4>
                  <p id="tenEmail">
                    <?php echo $tenData->user_email; ?>
                  </p>
                </div>

                <div class="col-6 text-center">
                  <img class="landlord_sign_img" src="<?php echo $pro_data->landlord_sign ?> " data-toggle="modal" data-target="#landlord_signture_dialog"
                  />
                  <h5>Landlord</h5>
                  <h4>
                    <?php echo $lanData->first_name;?>
                  </h4>
                  <p id="landEmail">
                    <?php echo $lanData->user_email; ?>
                  </p>
                </div>


                <?php 
              if (isusr("administrator")){
              ?>
                <!-- Modal -->
                <div class="modal fade" id="tenant_signture_dialog" tabindex="-1" role="dialog" aria-labelledby="property_data_dialog" aria-hidden="true">
                  <div class="modal-dialog modal-full modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="tenant-signture">Tenant Signture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col text-center">
                            <div id="signature-tenant" class="signature-pad">
                              <div class="signature-pad--body">
                                <canvas></canvas>
                              </div>
                              <div class="signature-pad--footer">

                                <div class="signature-pad--actions">
                                  <div class="row flex_center">
                                    <button type="button" class="btn btn-secondary clear sign-btn" data-action="clear" datarole="tenant">Clear</button>
                                    <button type="button" class="btn btn-info save sign-btn" data-action="save-png" datarole="tenant" data-id="<?php echo $proID ?>">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>




                <!-- Modal -->
                <div class="modal fade" id="landlord_signture_dialog" tabindex="-1" role="dialog" aria-labelledby="property_data_dialog"
                  aria-hidden="true">
                  <div class="modal-dialog modal-full modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="landlord-signture">Landlord Signture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col text-center">
                            <div id="signature-landlord" class="signature-pad">
                              <div class="signature-pad--body">
                                <canvas></canvas>
                              </div>
                              <div class="signature-pad--footer">
                                <div class="signature-pad--actions">
                                  <div class="row flex_center">
                                    <button type="button" class="btn btn-secondary clear sign-btn" data-action="clear" datarole="landlord">Clear</button>
                                    <button type="button" class="btn btn-info save sign-btn" data-action="save-png" datarole="landlord" data-id="<?php echo $proID ?>">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>

              </div>

              <?php 
                if (isusr("administrator")){
                  echo  do_shortcode( '[contact-form-7 id="137" title="Report"]' ); 
                }


        }
              ?>




              <!-- Image model popup -->
              <div class="modal fade" id="img_pop" tabindex="-1" role="dialog" aria-labelledby="img_pop" aria-hidden="true">
                <div class="modal-dialog modal-full modal-lg modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body center">
                      <img class="fer_img_pop" src="">
                    </div>
                  </div>
                </div>
              </div>
      </div>

      <script>
        $('#property-name').val('<?php echo $pro_data->pro_name; ?>');
        $('#tenant-mail').val('<?php echo $tenData->user_email; ?>');
        $('#landlord-mail').val('<?php echo $lanData->user_email; ?>');
        $('#link-email').val('<?php echo $pageLink ;?>');
      </script>

      <?php 
      get_footer(); ?>