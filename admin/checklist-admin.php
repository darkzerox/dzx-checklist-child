<div class="wrap">
  <div class="title-head">
    <h2>Property List</h2>
  </div>
  <div class="property-group">

    <div class="form-row">

      <div class="checklist-container col-8">


        <?php if (isusr('administrator')){ ?>
        <div class="row margin-b10">
          <div class="col">

            <form class="form-horizontal" role="form">
              <div class="form-group">
                <select id="property_list" class="data-list page-data-list selectpicker form-control btn " data-live-search="true" data="property"
                  data-style="btn-outline-secondary">
                </select>
                <h3>Property Detail</h3>
              </div>
            </form>
          </div>
        </div>
        <?php } ?>
      </div>



      <div class="form-group col-4">
        <div class="selepro-btngroup">
          <button type="button" class="btn btn-success" style="width: 60px;height: 60px;" go="property" ac="new">
            <i class="far fa-plus-square fa-2x"></i>
          </button>
          <button type="button" class="btn btn-danger" style="width: 60px;height: 60px;" go="property" ac="ch-del">
            <i class="fas fa-trash-alt fa-2x"></i>
          </button>
        </div>
        <div class="confirm-del" style="display:none;">
          <button type="button" class="btn btn-success" style="width: 60px;height: 60px;" go="property" ac="del">
            <i class="fas fa-check fa-2x"></i>
          </button>
          <button type="button" class="btn btn-danger" style="width: 60px;height: 60px;" go="property" ac="cancel">
            <i class="fas fa-times fa-2x"></i>
          </button>
        </div>



      </div>

    </div>

    <form id="property-form">
      <div class="form-row">
        <div class="form-group col-md-2 hidden">
          <input type="text" class="form-control" name="id" placeholder="Property ID">
        </div>
        <div class="form-group col-md-2">
          <label for="pro_name">Property ID</label>
          <input type="text" class="form-control" name="pro_id" placeholder="Property ID">
        </div>
        <div class="form-group col-md-10">
          <label for="pro_name">Property Name</label>
          <input type="text" class="form-control" name="pro_name" placeholder="Property Name">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="address" placeholder="Address">
        </div>
        <div class="form-group col-md-4">
          <label for="district">District</label>
          <input type="text" class="form-control" name="district" placeholder="District">
        </div>
        <div class="form-group col-md-4">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city" placeholder="City">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="provice">Provice</label>
          <input type="text" class="form-control" name="provice" placeholder="Provice">
        </div>
        <div class="form-group col-md-4">
          <label for="zipcode">Zip code</label>
          <input type="text" class="form-control" name="zipcode" placeholder="Zip code">
        </div>
      </div>

      <hr>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="elec_meter">Electricity Meter</label>
          <input type="text" class="form-control" name="elec_meter" placeholder="Electricity Meter">
        </div>
        <div class="form-group col-md-4">
          <label for="water_meter">Water Meter</label>
          <input type="text" class="form-control" name="water_meter" placeholder="Water Meter">
        </div>
      </div>

      <hr>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputTenant">Tenant</label>
          <select id="input_tenant" class="form-control" name="tenant_id">
            <option class="non-select" value="-1" selected>Choose...</option>
            <?php
            $blogusers = get_users( 'blog_id=1&orderby=nicename&role=tanant' );
            // Array of WP_User objects.
            foreach ( $blogusers as $user ) {
              
              echo '<option class="non-select" value="'.esc_html( $user->id ).'">'.esc_html( $user->user_nicename ).'</option>';
            }
            
            ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="inputLandlord">Landlord</label>
          <select id="input_landlord" class="form-control" name="landlord_id">
            <option class="non-select" value="-1" selected>Choose...</option>
            <?php 
              $blogusers = get_users( 'blog_id=1&orderby=nicename&role=landlord' );
              // Array of WP_User objects.
              foreach ( $blogusers as $user ) {
                
                echo '<option class="non-select" value="'.esc_html( $user->id ).'">'.esc_html( $user->user_nicename ).'</option>';
              }
            ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="inputStartDate">Lease start date</label>
          <input type="text" class="form-control date" name="startdate" placeholder="30-01-2018">
        </div>
        <div class="form-group col-md-3">
          <label for="inputEndDate">Lease expire date</label>
          <input type="text" class="form-control date" name="enddate" placeholder="31-05-2018">
        </div>
      </div>

      <button type="submit" class="btn btn-success btnProperty_Update btn-lg" go="property" ac="insert"><i class="fas fa-save"></i> Save</button>
      <div class="state"> </div>


    </form>
    <hr/>
    


    <div id="room_lists">
      
    </div>
  </div>



</div>