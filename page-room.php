<?php 
/**
 * Template Name: page-room
 */
get_header();
    
include_once( 'inventory-component/inventory-mid-head.php' );

$room_query = "SELECT * FROM dzx_furniture WHERE room_id LIKE ".$roomID ;
$ferniture = $wpdb->get_results($room_query);

$uploadIcon = "/wp-content/uploads/2018/04/upload_icob.png";
$ferTableData="";

foreach ($ferniture as $value) {

 $fer_img = ($value->image != '') ? "<img class='smartcat-upload  fer_data fer_img' src=".$value->image." />":"<img class='smartcat-upload upload_icon' src='".$uploadIcon."' />";
 $fer_img_in =  ($value->move_in_img != '') ? "<img class='smartcat-upload fer_data fer_img ' src=".$value->move_in_img." />":"<img class='smartcat-upload upload_icon' src='".$uploadIcon."' />";
 $fer_img_out =  ($value->move_out_img != '') ? "<img class='smartcat-upload fer_data  fer_img ' src=".$value->move_out_img." />":"<img class='smartcat-upload upload_icon' src='".$uploadIcon."' />";

 $fer_check_in_like = ($value->move_in == 1) ? 'checked':'' ;
 $fer_check_in_dislike = ($value->move_in == 0) ? 'checked':'' ; 
 $fer_check_out_like = ($value->move_out == 1) ? 'checked':'' ;
 $fer_check_out_dislike = ($value->move_out == 0) ? 'checked':'' ;

 $inID = randomSTR();
 $outID = randomSTR();
 

  $ferTableData .="<tr field='".$value->id."' room = '".$roomID."' >
                    <td>
                      <textarea class='fer_data fer_name' type='text' >".$value->name."</textarea>
                    </td>
                    <td>
                      <div class=' smartcat-uploader fer_img'>   
                      ".$fer_img."                   
                      <input style='display:none' type='text'>
                      </div>
                    </td>
                    <td> 
                      <div class='fer_check fer_check_in'>
                        <input id='thumbs-up-".$inID."' type='radio' name='fer_check_in".$inID."' value='1' class='thumbs-up' ".$fer_check_in_like."/>
                        <label class='fer_check_state fer_check_in' for='thumbs-up-".$inID."'>
                          ".$faUp."
                        </label>
                        <input id='thumbs-down-".$inID."' type='radio' name='fer_check_in".$inID."' value='0' class='thumbs-down' ".$fer_check_in_dislike."/>
                        <label class='fer_check_state fer_check_in' for='thumbs-down-".$inID."'>
                        ".$faDown."
                        </label>
                      </div>
                    </td>                    
                    <td>
                      <div class=' smartcat-uploader fer_img_in'>   
                      ".$fer_img_in."                   
                      <input style='display:none' type='text' name='".$value->name."'>
                      </div>
                    </td>
                    <td><textarea class='fer_data fer_comm_in' >".$value->in_comment."</textarea></td>
                    <td>
                      <div class='fer_check fer_check_out'>
                        <input id='thumbs-up-".$outID."' type='radio' name='fer_check_out".$outID."' value='1' class='thumbs-up' ".$fer_check_out_like."/>
                        <label class='fer_check_state fer_check_out' for='thumbs-up-".$outID."'>
                        ".$faUp."
                        </label>
                        <input id='thumbs-down-".$outID."' type='radio' name='fer_check_out".$outID."' value='0'
                          class='thumbs-down' ".$fer_check_out_dislike." />
                        <label class='fer_check_state fer_check_out' for='thumbs-down-".$outID."'>
                        ".$faDown."
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class=' smartcat-uploader fer_img_out'>   
                      ".$fer_img_out."                   
                      <input style='display:none' type='text' name='".$value->name."'>
                      </div>
                    </td>
                    <td><textarea class='fer_data fer_comm_out' >".$value->out_comment."</textarea></td>
                    <td>
                    
                    <button type='button' class='btn btn-danger btn-del-fern btn-sm' data-toggle='modal' data-target='#del-fern' data-val='".$value->id."'><i class='fas fa-trash-alt'></i></button>
                    
                    </td>
                    
                  </tr>";

   



}

?>


<div id="content" class="site-content inventory-page">
  <div class="container">
    <div class="row">

      <div class="checklist-container">
        <div class="row">
          <div class="col">
            <h1>
              <?php echo $pro_data->pro_name; ?>
            </h1>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h4 class="toppic toppic-success">
              <?php echo $_SESSION['roN'] ?>
            </h4>
          </div>
          <div class="col">
            <h4 class="toppic toppic-nobar" style="text-align: right;">Date of checklist :
              <?php echo date("l  M  Y") ?>
            </h4>
          </div>
        </div>

        <?php
       
       include_once( 'inventory-component/move-in-out-report.php' );
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
                <th>Del</th>
              </tr>
            </thead>         
           

            <tbody class="fern_data" room="<?php echo $roomID?>">
              <?php echo $ferTableData; 
              
              //skele_inventory(randomSTR(),randomSTR(),$roomID);
          
              ?>

              

            </tbody>

          </table>
          <button class="btn btn-info btn-sm insert_row">
            <i class="fas fa-plus"></i>
          </button>
      </div>


      <div class="row full center">
        <a href="/inventory/" class="btn btn-secondary btn-lg ">Back</a>&ensp;
        <button href="#" type="button" class="btn btn-success btn-lg update_fern">Save</button>

      </div>



      <div class="modal fade" id="del-fern" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Remove Ferniture</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body del_fern">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-danger btn-fern-conf">
                <i class='fas fa-trash-alt'></i>
              </button>
            </div>
          </div>
        </div>
      </div>









      <?php get_footer(); ?>