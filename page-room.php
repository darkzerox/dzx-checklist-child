<?php 
get_header();

 $lanID = $_SESSION['landlord'];
 $tenID = $_SESSION['tenant'];
 $proID = $_SESSION['pro'];
 $roomID = $_SESSION['roID'];


 $lanData = get_userdata($lanID);	
 $tenData = get_userdata($tenID);
 

global $wpdb;


$room_query = "SELECT * FROM dzx_furniture WHERE room_id LIKE 2 " ;
$ferniture = $wpdb->get_results($room_query);
// $ferniture = $ferniture[0];

// print_r($ferniture);

$ferTableData="";
foreach ($ferniture as $value) {

 $fer_img = ($value->image != '') ? "<img class='smartcat-upload  fer_data fer_img' src=".$value->image." />":"<img class='smartcat-upload' src='/wp-content/uploads/2018/04/upload.png' />";
 $fer_img_in =  ($value->move_in_img != '') ? "<img class='smartcat-upload fer_data fer_img ' src=".$value->move_in_img." />":"<img class='smartcat-upload' src='/wp-content/uploads/2018/04/upload.png' />";
 $fer_img_out =  ($value->move_out_img != '') ? "<img class='smartcat-upload fer_data  fer_img ' src=".$value->move_out_img." />":"<img class='smartcat-upload' src='/wp-content/uploads/2018/04/upload.png' />";

 $fer_check_in_like = ($value->move_in == 1) ? 'isCheck':'' ;
 $fer_check_in_dislike = ($value->move_in == 0) ? 'isCheck':'' ; 
 $fer_check_out_like = ($value->move_in == 0) ? 'isCheck':'' ;
 $fer_check_out_dislike = ($value->move_in == 1) ? 'isCheck':'' ;


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
                      <div class='fer_check'>
                        <i class='far fa-2x fa-thumbs-up ". $fer_check_in_like ."'></i> <i class='far fa-2x fa-thumbs-down ". $fer_check_in_dislike ."'></i>
                        <input class='fer_data fer_check_in' style='display:none' type='text' val=".$value->move_in.">
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
                      <div class='fer_check'>
                        <i class='far fa-thumbs-up fa-2x ". $fer_check_out_like ."'></i> <i class='far fa-2x fa-thumbs-down ". $fer_check_out_dislike ."'></i>
                        <input class='fer_data fer_check_out' style='display:none' type='text' val=".$value->move_out.">
                      </div>
                    </td>
                    <td>
                      <div class=' smartcat-uploader fer_img_out'>   
                      ".$fer_img_out."                   
                      <input style='display:none' type='text' name='".$value->name."'>
                      </div>
                    </td>
                    <td><textarea class='fer_data fer_comm_out' >".$value->out_comment."</textarea></td>
                  </tr>";

   
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
        <div class="row">
          <div class="col">
            <h4 class="toppic toppic-success">
              <?php echo $_SESSION['roN'] ?>
            </h4>
          </div>
          <div class="col">
            <h4 class="toppic toppic-nobar">Date of checklist : 22 March 2018</h4>
          </div>
        </div>

        <div class="row margin30">
          <div class="col">
            <a href="#" type="button" class="btn btn-success btn-sm">Move in Detect Report</a>
          </div>
          <div class="col">
            <a href="#" type="button" class="btn btn-info btn-sm">Move out Detect Report</a>
          </div>
        </div>

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
          <tfoot>
            <tr>
              <td >
                <button class="btn btn-info btn-sm insert_row"><i class="fas fa-plus"></i></button>
              </td>
            </tr>
          </tfoot>

          <tbody class="fern_data">
            <?php echo $ferTableData; ?>

            <tr class="new-row" field='' room = '<?php echo $roomID ?>' >
                    <td>
                      <textarea class='fer_data fer_name' type='text'></textarea>
                    </td>
                    <td>
                      <div class=' smartcat-uploader fer_img'>   
                      <?php echo $fer_img ?>
                      <input style='display:none' type='text'>
                      </div>
                    </td>
                    <td> 
                      <div class='fer_check'>
                        <i class='far fa-2x fa-thumbs-up isCheck'></i> <i class='far fa-2x fa-thumbs-down'></i>
                        <input class='fer_data fer_check_in' style='display:none' type='text' val='1'>
                      </div>
                    </td>                    
                    <td>
                      <div class=' smartcat-uploader fer_img_in'>                         
                      <?php echo $fer_img_in ?>                
                      <input style='display:none' type='text' name=''>
                      </div>
                    </td>
                    <td><textarea class='fer_data fer_comm_in' ></textarea></td>
                    <td>
                      <div class='fer_check'>
                        <i class='far fa-thumbs-up fa-2x isCheck'></i> <i class='far fa-2x fa-thumbs-down'></i>
                        <input class='fer_data fer_check_out' style='display:none' type='text' val='1'>
                      </div>
                    </td>
                    <td>
                      <div class=' smartcat-uploader fer_img_out'>                         
                      <?php echo $fer_img_out ?>                   
                      <input style='display:none' type='text' name=''>
                      </div>
                    </td>
                    <td><textarea class='fer_data fer_comm_out' ></textarea></td>
                  </tr>

          </tbody>

         
          
        </table>
        

      </div>




      <div class="row full center">
        <a href="#" type="button" class="btn btn-success btn-lg update_fern">Save</a>
      </div>






      <?php get_footer(); ?>