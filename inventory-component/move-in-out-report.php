<div class="row margin30">
  <div class="col text-right">
    <button type="button" class="btn btn-success btn-sm moveInOutReport" data-toggle="modal"  stype="0" pro="<?php echo  $proID; ?>">Move in Detect Report</button>
    <button type="button" class="btn btn-info btn-sm moveInOutReport" data-toggle="modal"  stype="1" pro="<?php echo $proID; ?>">Move out Detect Report</button>
  </div> 
</div>

<!-- Modal moveINreport -->
<div class="modal fade" id="moveInOutReport" tabindex="-1" role="dialog" aria-labelledby="moveInOutReportTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lgg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moveInOutReportTitle">Move in Detect Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table-style-dzx">            
          <thead>
            <tr>
              <th class="table-name">Room</th>
              <th class="table-name">Item</th>
              <th class="table-photo">Photo</th>                
              <th class="table-comment">Comment</th>             

            </tr>
          </thead>   
          <tbody id="move_inout_report">
          </tbody>         

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php

?>