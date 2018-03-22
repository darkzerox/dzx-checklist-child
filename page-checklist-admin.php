<?php 
get_header();
?>

<?php 
    do_action('user_property');
?>
<div class="container checklist">

  <?php 
  if (isusr("administrator")){ 
?>

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="property-tab" data-toggle="tab" href="#tab-property" role="tab" aria-controls="home" aria-selected="true">Property</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="tenant-tab" data-toggle="tab" href="#tab-tenant" role="tab" aria-controls="profile" aria-selected="false">Tenant</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="landlord-tab" data-toggle="tab" href="#tab-landlord" role="tab" aria-controls="contact" aria-selected="false">Landlord</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">

    <div class="property-group tab-pane fade show active" id="tab-property" aria-labelledby="property-tab">
      <h2>Property</h2>
      <div class="form-row">
        <div class="form-group col">
          <select id="property_list" class="custom-select data-list" data="property">
            <option class="non-select" value="-2">เลือก Property</option>
            <option class="non-select" value="-1">เพิ่ม property</option>
          </select>
        </div>
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
          <div class="form-group col-md-12">
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
            <label for="zippost">Zippost</label>
            <input type="text" class="form-control" name="zippost" placeholder="Zippost">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="inputTenant">Tenant</label>
            <select id="input_tenant" class="form-control" name="tenant_id">
              <option class="non-select" value="-1" selected>Choose...</option>
              <option>...</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="inputLandlord">Landlord</label>
            <select id="input_landlord" class="form-control" name="landlord_id">
              <option class="non-select" value="-1" selected>Choose...</option>
              <option>...</option>
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

    <div class="property-group tab-pane fade" id="tab-tenant" aria-labelledby="tenant-tab">
      <h2>Tenant</h2>
      <div class="form-row">
        <div class="form-group col">
          <select id="tenant_list" class="custom-select data-list" data="tenant">
            <option class="non-select" value="-2">เลือก Tenant</option>
            <option class="non-select" value="-1">เพิ่ม Tenant</option>
          </select>
        </div>
        <div class="form-group col">
          <button type="button" class="btn btn-success" go="tenant" ac="new">
            <i class="far fa-plus-square"></i>
          </button>
          <button type="button" class="btn btn-danger" go="tenant" ac="del">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>

      <form id="tenant-form">
        <div class="form-row">
          <div class="form-group col-md-2 hidden">
            <input type="text" class="form-control" name="id" placeholder="Tenant ID">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Tenant Name</label>
            <input type="text" class="form-control" name="name" placeholder="Tenant Name">
          </div>
          <div class="form-group col-md-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email">
          </div>
          <div class="form-group col-md-4">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" name="phone" placeholder="Phone">
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
            <label for="zippost">Zippost</label>
            <input type="text" class="form-control" name="zippost" placeholder="Zippost">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btnTenant_Update" go="tenant" ac="update">Update</button>
        <div class="state"> </div>


      </form>
    </div>

    <div class="property-group tab-pane fade" id="tab-landlord" aria-labelledby="landlord-tab">
      <h2>Landlord</h2>
      <div class="form-row">
        <div class="form-group col">
          <select id="landlord_list" class="custom-select data-list" data="landlord">
            <option class="non-select" value="-2">เลือก Landlord</option>
            <option value="-1">เพิ่ม Landlord</option>
          </select>
        </div>
        <div class="form-group col">
          <button type="button" class="btn btn-success" go="landlord" ac="new">
            <i class="far fa-plus-square"></i>
          </button>
          <button type="button" class="btn btn-danger" go="landlord" ac="del">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>

      <form id="landlord-form">
        <div class="form-row">
          <div class="form-group col-md-2 hidden">
            <input type="text" class="form-control" name="id" placeholder="Landlord ID">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Landlord Name</label>
            <input type="text" class="form-control" name="name" placeholder="Landlord Name">
          </div>
          <div class="form-group col-md-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email">
          </div>
          <div class="form-group col-md-4">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" name="phone" placeholder="Phone">
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
            <label for="zippost">Provice</label>
            <input type="text" class="form-control" name="provice" placeholder="Provice">
          </div>
          <div class="form-group col-md-4">
            <label for="zippost">Zippost</label>
            <input type="text" class="form-control" name="zippost" placeholder="Zippost">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btnLandlord_Update" go="landlord" ac="update">Update</button>
        <div class="state"> </div>

      </form>
    </div>


  </div>







  <?php 
  }
?>

</div>







<?php get_footer(); ?>