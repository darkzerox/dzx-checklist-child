<div class="wrap">
  <h2>Property List</h2>


  <div class="property-group">
    <h2>Property</h2>
    <div class="form-row">

      <div class="form-group col">
        <form class="form-horizontal" role="form">
          <select id="property_list" class="data-list selectpicker show-tick form-control btn btn-outline-secondary" data-live-search="true" data-style="btn-outline-secondary"  data="property" >
          </select>

        </form>
      </div>

      <!-- <div class="form-group col">
        <select id="property_list" class="custom-select data-list" data="property">
          <option class="non-select" value="-2">เลือก Property</option>
          <option class="non-select" value="-1">เพิ่ม property</option>
        </select>
      </div>  -->
      <div class="form-group col">
        <button type="button" class="btn btn-success" go="property" ac="new">
          <i class="far fa-plus-square"></i>
        </button>
        <button type="button" class="btn btn-danger" go="property" ac="del">
          <i class="fas fa-trash-alt"></i>
        </button>
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
          <input type="text" class="form-control date" name="startdate" placeholder="30/01/2018">
        </div>
        <div class="form-group col-md-3">
          <label for="inputEndDate">Lease expire date</label>
          <input type="text" class="form-control date" name="enddate" placeholder="31/05/2018">
        </div>
      </div>

      <button type="submit" class="btn btn-primary btnProperty_Update" go="property" ac="update">Update</button>
      <div class="state"> </div>


    </form>
  </div>
</div>