
<?php 
/**
 * Template Name: page-checklist
 */
get_header();
?>
<div id="content" class="site-content">
  <div class="container">
    <div class="row">


      <div class="checklist-container">
        <h2 class="head-top">Expat Living Guide & Moving Checklist</h2>

        <div class="group-container">
          <?php if (isusr('administrator')){ ?>
          <div class="row margin-b10">
            <div class="col">
              <form class="form-horizontal" role="form">
                <div class="form-group">
                  <select id="property_list" class="data-list page-data-list selectpicker form-control btn " data-live-search="true" data="property"
                    data-style="btn-outline-secondary">
                  </select>
                </div>
              </form>
            </div>
          </div>
          <?php }else if ( is_user_logged_in() ) {
            $userType = "";
            $userID = get_current_user_id();
            if (isusr('landlord')){
              $userType ='landlord';
            }
            if (isusr('tenant')){
              $userType ='tenant';
            }
            ?>

            <div class="row margin-b10">
            <div class="col">
              <form class="form-horizontal" role="form">
                <div class="form-group">
                  <select id="property_report_list" uid="<?php echo $userID; ?>" uty="<?php echo $userType; ?>" class="report-data-list selectpicker form-control btn " data-live-search="true" data="property"
                    data-style="btn-outline-secondary">
                  </select>
                </div>
              </form>
            </div>
          </div>

            <?php
          } ?>


          <div class="row margin-b10">
            <div class="col form-group">
              <a class="btn btn-outline-secondary btn-full btn-lg align-left" href="/expat/" role="button">Expat Living Guide</a>
            </div>
          </div>

          <!-- <div class="row margin-b10">
            <div class="col form-group">
              <a class="btn btn-outline-secondary btn-full btn-lg align-left" href="#" role="button">HR Profile</a>
            </div>
          </div> -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="property_data_dialog" tabindex="-1" role="dialog" aria-labelledby="property_data_dialog" aria-hidden="true">
          <div class="modal-dialog modal-full modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="property_data_dialog_title">Property Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="data-group">
                  <div class="row">
                    <div class="col-3">
                      <p>Tenant Name :</p>
                    </div>
                    <div class="col-9">
                      <p id="tenant_name"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Address :</p>
                    </div>
                    <div class="col-9">
                      <p>
                        <span id="tenant_address"></span>
                        <span id="tenant_district"></span>
                        <span id="tenant_city"></span>
                        <span id="tenant_provice"></span>
                        <span id="tenant_zipcode"></span>
                      </p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Tel :</p>
                    </div>
                    <div class="col-9">
                      <p id="tenant_tel"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Email :</p>
                    </div>
                    <div class="col-9">
                      <p id="tenant_email"></p>
                    </div>
                  </div>
                </div>
                <div class="data-group">
                  <div class="row">
                    <div class="col-3">
                      <p>Landlord Name :</p>
                    </div>
                    <div class="col-9">
                      <p id="landlord_name"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Address :</p>
                    </div>
                    <div class="col-9">
                      <p>
                        <span id="landlord_address"></span>
                        <span id="landlord_district"></span>
                        <span id="landlord_city"></span>
                        <span id="landlord_provice"></span>
                        <span id="landlord_zipcode"></span>
                      </p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Tel :</p>
                    </div>
                    <div class="col-9">
                      <p id="landlord_tel"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Email :</p>
                    </div>
                    <div class="col-9">
                      <p id="landlord_email"></p>
                    </div>
                  </div>
                </div>

                <div class="data-group">
                  <div class="row">
                    <div class="col-3">
                      <p>Property Address:</p>
                    </div>
                    <div class="col-9">
                      <p>
                        <span id="pro_address"></span>
                        <span id="pro_district"></span>
                        <span id="pro_city"></span>
                        <span id="pro_provice"></span>
                        <span id="pro_zipcode"></span>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="data-group">
                  <div class="row">
                    <div class="col-3">
                      <p>Lease start date:</p>
                    </div>
                    <div class="col-9">
                      <p id="pro_start"></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <p>Lease expire date:</p>
                    </div>
                    <div class="col-9">
                      <p id="pro_end"></p>
                    </div>
                  </div>

                </div>

                <div class="row full center">
                  <a href="/inventory/" type="button" class="btn btn-danger btn-lg">Inventory</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>





    </div>




    <?php get_footer(); ?>