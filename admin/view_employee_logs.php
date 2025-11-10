<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require_once('../../API/db_connect.php');
// require('../../dashboard/components/session.php');

include('../config/db_config.php');
// include('sql_queries.php');

include('check_admin_session.php');

// include('deletepayment.php');
// include('deleteyearly.php');

// session_start();
// $user_id = $_SESSION['id'];

// // include('verify_admin.php');
// if (!isset($_SESSION['id'])) {
//   header('location:../index.php');
// } else {
// }


$user_id = $_SESSION['id'];
if (!isset($_SESSION['id'])) {
  header('location:../index.php');
} else {
}


date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');
$time = date('H:i:s');
$now = new DateTime();

$objid = $objid1 = $masname1 = $person_status =  $entity_no  =  $address  =
  $contact_number  = $fullname = $date_from = $date_to = $street = $mobile_no = $ydate_from = $ydate_to = '';

//fetch user from database
// $get_user_sql = "SELECT * FROM tbl_users where id = :id ";
// $user_data = $con->prepare($get_user_sql);
// $user_data->execute([':id' => $user_id]);
// while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {


//   $db_fullname = $result['fullname'];
// }

$emp_id2 = $_GET['emp_id'];




$get_employee_sql = "SELECT * FROM tbl_employee_info where emp_id = :emp_id";
$get_employee_data = $con->prepare($get_employee_sql);
$get_employee_data->execute([':emp_id' => $emp_id2]);

while ($result = $get_employee_data->fetch(PDO::FETCH_ASSOC)) {

  $emp_id_new = $result['emp_id'];
  $fullname_new = $result['fullname'];
  $address_new = $result['address'];
}

// $get_all_preby_sql = "SELECT * FROM preparedby";
// $get_all_preby_data = $con->prepare($get_all_preby_sql);
// $get_all_preby_data->execute();




// $get_amount_sql= "SELECT SUM(amountmas) as total FROM masdailypayment where id = '$objid '";
// $get_pay_amount_data = $con_fscap2->prepare($get_amount_sql);
// $get_pay_amount_data->execute();

// while ($result1 = $get_pay_amount_data->fetch(PDO::FETCH_ASSOC)) {

//   $total =$result1['total'];
// }


// $get_pay_amount_sql= "SELECT SUM(`amountmas`) as total FROM masdailypayment where ";
// $get_pay_amount_data = $con->prepare($get_pay_amount_sql);
// $get_pay_amount_data->execute();
// $get_pay_amount_data->setFetchMode(PDO::FETCH_ASSOC);
// while ($result1 = $get_pay_amount_data->fetch(PDO::FETCH_ASSOC)) {

//   $payrolltotal =$result1['total'];
// }



?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>View logs </title>
  <?php include('heading.php'); ?>


</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include('sidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- <div class="float-topright">
                <?php echo $alert_msg; ?>
            </div> -->
      <div class="content-header"></div>
      <section class="content">
        <div class="card">


          <div class="card-header p-2 bg-dark text-white">

            <div class="nav nav-pills" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-daily" role="tab" aria-controls="nav-home" aria-selected="true">DAILY LOGS</a>
              <!-- <a class="nav-item nav-link" id="nav-overtime-tab" data-toggle="tab" href="#nav-overtime" role="tab" aria-controls="nav-overtime" aria-selected="false">OVERTIME LOGS </a> -->


            </div>
          </div>

          <div class="card-body">

            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-daily" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="card">
                  <div class="card-header  text-white bg-dark">
                    <h5>Emp ID: <?php echo $emp_id_new; ?>
                      <input hidden id="emp_id_new" value="<?php echo $emp_id_new; ?>">

                      <br> NAME: <?php echo $fullname_new; ?> <br> ADDRESS: <?php echo $address_new; ?>
                      <a class="btn btn-danger btn-sm" style="float:right;" target="blank" id="printlink" class="btn btn-success bg-gradient-success" href="../plugins/jasperreport/dailypayment.php?objid=<?php echo $objid; ?>&masname=<?php echo $masname1; ?>&street=<?php echo $street1; ?>&barangay1=<?php echo $barangay1; ?>&preparedby=<?php echo $preparedby; ?>&position=<?php echo $position; ?>&datefrom=<?php echo $date_from; ?>&dateto=<?php echo $date_to; ?>">
                        <i class="nav-icon fa fa-print"></i></a>
                    </h5>
                  </div>





                  <div class="card-body">
                    <div class="box box-primary">

                      <div class="box-body">
                        <div class="row">
                          <div class="col-12" style="margin-bottom:30px;padding:auto;">
                            <div class="input-group date">
                              <label style="padding-right:10px;padding-left: 10px">From: </label>
                              <div style="padding-right:40px" class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input style="margin-right:10px;" type="text" data-provide="datepicker" class="form-control col-3 " style="font-size:13px" autocomplete="off" name="datefrom" id="dtefrom" value="<?php echo $date_from; ?>">

                              <label style="padding-right:10px">To:</label>
                              <div style="padding-right:10px" class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" style="margin-right:50px;" class="form-control col-3 " data-provide="datepicker" autocomplete="off" name="dateto" id="dteto" value="<?php echo $date_to; ?>">

                              <button id="view_dailypayment_member" onClick="loadhistory()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                              <input hidden id="objid" value="<?php echo $objid; ?>">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <button id="viewdailylogs" onClick="viewdailylogs()" class="btn btn-warning">View All Logs</button>
                            </div>

                            <br>

                          </div>


                          <label style="padding-right:10px;padding-left: 10px">TOTAL Work Hours: </label>
                          <div class="col-md-3" id="total_payment">


                          </div>

                        </div>

                        <br>


                        <div class="table-responsive">



                          <table style="overflow-x: auto;" id="users" name="user" class="table table-bordered table-striped">
                            <thead alignment="center">



                              <th> EMP ID </th>
                              <th> DATE</th>
                              <th> TIME IN</th>
                              <th> TIME OUT </th>
                              <th> Options </th>

                            </thead>
                            <tbody id="daily_logs">

                            </tbody>
                          </table>


                        </div>

                      </div>
                    </div>

                  </div>

                </div>
              </div>



              <!-- OVERTIME -->

              <!-- <div class="tab-pane fade " id="nav-overtime" role="tabpanel" aria-labelledby="nav-overtime-tab">
                <div class="card">
                  <div class="card-header  text-white bg-info">
                    <h5>Emp ID: <?php echo $emp_id; ?> <input hidden id="emp_id" value="<?php echo $masname1; ?>"> <br> NAME: <?php echo $fullname; ?> <br> ADDRESS: <?php echo $address; ?>
                      <input hidden id="ymasname1" value="<?php echo $masname1; ?>">
                      <input hidden id="ystreet" value="<?php echo $street; ?>">
                      <input hidden id="ybarangay1" value="<?php echo $barangay; ?>">

                      <a class="btn btn-danger btn-sm" style="float:right;" target="blank" id="printlink2" class="btn btn-success bg-gradient-success" href="../plugins/jasperreport/yearlypayment.php?objid=<?php echo $objid; ?>&ydatefrom=<?php echo $ydate_from; ?>&ydateto=<?php echo $ydate_to; ?>">
                        <i class="nav-icon fa fa-print"></i></a>
                    </h5>
                  </div>

                  <div class="card-body">
                    <div class="box box-primary">
                      <form role="form" method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                        <div class="box-body">
                          <div class="row">
                            <div class="col-12" style="margin-bottom:30px;padding:auto;">
                              <div class="input-group date">
                                <label style="padding-right:10px;padding-left: 10px">From: </label>
                                <div style="padding-right:10px" class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input style="margin-right:10px;" type="text" data-provide="datepicker" class="form-control col-3 " style="font-size:13px" autocomplete="off" name="ydatefrom" id="ydtefrom" value="<?php echo $ydate_from; ?>">

                                <label style="padding-right:10px">To:</label>
                                <div style="padding-right:10px" class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" style="margin-right:50px;" class="form-control col-3 " data-provide="datepicker" autocomplete="off" name="dateto1" id="ydteto" value="<?php echo $ydate_to; ?>">

                                <button id="view_yearlypayment_member" onClick="loadhistory1()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                <input hidden id="objid5" value="<?php echo $objid; ?>">
                              </div>
                            </div>

                            <div class="input-group date">
                              <label style="padding-right:10px;padding-left: 10px">Prepared By: </label>

                    


                              <label style="padding-right:10px;padding-left: 10px">Position: </label>
                              <div class="col-md-3">
                                <input type="text" readonly class="form-control  " id="yposition" name="yposition" value="">
                                <input hidden type="text" readonly class="form-control  " id="ypreparedby" name="ypreparedby" value="">
                              </div>
                              <button id="view_payment1" onClick="viewpaymentyear()" class="btn btn-warning">VIEW PAYMENT</button>
                            </div>

                          </div>
                          <div class="table-responsive">



                            <table style="overflow-x: auto;" id="users1" name="user" class="table table-bordered table-striped">
                              <thead align="center">



                                <th> OBJID </th>
                                <th> DATE PAYMENT</th>
                                <th> OR#</th>
                                <th> AMOUNT </th>
                                <th> Options </th>

                              </thead>
                              <tbody id="yearly_payment">

                              </tbody>
                            </table>


                          </div>
                      </form>
                    </div>
                  </div>

                </div>

              </div> -->

            </div>

          </div>

        </div>







      </section>
      <br>
    </div>
    <!-- /.content-wrapper -->


  </div>


  <!-- DAILY PAYMENT MODAL -->
  <div class="modal fade" id="delete_membermodal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Delete</h4>

        </div>
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?> ">
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Delete Record?</label>
                <input readonly="true" type="text" name="payment_delete" id="payment_delete" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
            <input type="submit" name="deletepayment" class="btn btn-danger" value="Yes">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- YEARLY PAYMENT MODAL -->
  <div class="modal fade" id="delete_yearlymodal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Delete</h4>

        </div>
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Delete Record sa yearly?</label>
                <input readonly="true" type="text" name="yearly_delete" id="yearly_delete" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
            <input type="submit" name="deleteyearly" class="btn btn-danger" value="Yes">
          </div>
        </form>
      </div>
    </div> <!-- /.modal-content -->
  </div>

  </div>






  <?php include('pluginscript.php') ?>

  <script>
    $('#users').DataTable({
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': true,
      'autoHeight': true,

    });


    $('#users1').DataTable({
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': true,
      'autoHeight': true,

    });



    // $('#addPUM').on('hidden.bs.modal', function() {
    //   $('#addPUM form')[0].reset();
    // });

    $(function() {
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
      });
    });

    // $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
    //   event.preventDefault();

    //   var user_id = ($(this).data('id'));

    //   $('#user_id').val(user_id);
    //   $('#delete_PUMl').modal('toggle');

    // });

    function loadhistory() {
      event.preventDefault();
      var emp_id = $('#emp_id').val();
      var date_from = $('#dtefrom').val();
      var date_to = $('#dteto').val();

      $('#daily_logs').load("load_dailylogs2.php", {
          emp_id: emp_id,
          date_from: date_from,
          date_to: date_to,



        },


        function(response, status, xhr) {
          if (status == "error") {
            alert(msg + xhr.status + " " + xhr.statusText);
            console.log(msg + xhr.status + " " + xhr.statusText);
            console.log("xhr=" + xhr.responseText);
          }
        });





    }




    function viewdailylogs() {
      event.preventDefault();
      var emp_id = $('#emp_id_new').val();


      $('#daily_logs').load("load_dailylogs.php", {
          emp_id: emp_id




        },

        function(response, status, xhr) {
          if (status == "error") {
            alert(msg + xhr.status + " " + xhr.statusText);
            console.log(msg + xhr.status + " " + xhr.statusText);
            console.log("xhr=" + xhr.responseText);
          }
        });



      console.log(emp_id);

      $('#total_payment').load("load_totalpayment.php", {
          objid: objid


        },



        function(response, status, xhr) {
          if (status == "error") {
            alert(msg + xhr.status + " " + xhr.statusText);
            console.log(msg + xhr.status + " " + xhr.statusText);
            console.log("xhr=" + xhr.responseText);
          }
        });
    }




    function loadhistory1() {
      console.log("test");
      event.preventDefault();
      var objid5 = $('#objid5').val(); // dri ka mo kuha  so ok nani nard salamat kayo galibog pako ani
      var ydate_from = $('#ydtefrom').val();
      var ydate_to = $('#ydteto').val();

      $('#yearly_payment').load("load_yearlypayment.php", {
          objid5: objid5, //objid 1 man imong gi gmit dri kuan nard abi nako diri sa itaas kwaon
          ydate_from: ydate_from,
          ydate_to: ydate_to,


        },
        function(response, status, xhr) {
          if (status == "error") {
            alert(msg + xhr.status + " " + xhr.statusText);
            console.log(msg + xhr.status + " " + xhr.statusText);
            console.log("xhr=" + xhr.responseText);
          }
        });


    }


    function viewpaymentyear() {
      console.log("test");
      event.preventDefault();
      var objid5 = $('#objid5').val(); // dri ka mo kuha  so ok nani nard salamat kayo galibog pako ani
      var ydate_from = $('#ydtefrom').val();
      var ydate_to = $('#ydteto').val();

      $('#yearly_payment').load("load_viewpaymentyear.php", {
          objid5: objid5, //objid 1 man imong gi gmit dri kuan nard abi nako diri sa itaas kwaon
          ydate_from: ydate_from,
          ydate_to: ydate_to,


        },
        function(response, status, xhr) {
          if (status == "error") {
            alert(msg + xhr.status + " " + xhr.statusText);
            console.log(msg + xhr.status + " " + xhr.statusText);
            console.log("xhr=" + xhr.responseText);
          }
        });





    }


    // DELETE DAILYPAYMENT
    $(function() {
      $(document).on('click', '.delete_logs', function(e) {
        e.preventDefault();

        var currow = $(this).closest("tr");
        var objid = currow.find("td:eq(0)").text();
        $('#delete_membermodal').modal('show');
        $('#payment_delete').val(objid);
      });
    });



    // DELETE YEARLY PAYMENT
    $(function() {
      $(document).on('click', '.delete_yearlypayment', function(e) {
        e.preventDefault();

        var currow = $(this).closest("tr");
        var objid = currow.find("td:eq(0)").text();
        $('#delete_yearlymodal').modal('show');
        $('#yearly_delete').val(objid);
      });
    });


    $(function() {

      //Initialize Select2 Elements
      $('.select2').select2();
      $("#preby").select2({
        //  minimumInputLength: 3,
        // placeholder: "hello",
        ajax: {
          url: "preparedby_query", // json datasource
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },

          processResults: function(response) {
            return {
              results: response


            };
          },
          cache: true,
          error: function(xhr, b, c) {
            console.log(
              "xhr=" +
              xhr.responseText +
              " b=" +
              b.responseText +
              " c=" +
              c.responseText
            );
          }
        }
      });

    });

    $('#preby').on('change', function() {
      var idp = this.value;
      console.log(idp);
      $.ajax({
        type: "POST",
        url: 'preparedby.php',
        data: {
          idp: idp
        },
        error: function(xhr, b, c) {
          console.log(
            "xhr=" +
            xhr.responseText +
            " b=" +
            b.responseText +
            " c=" +
            c.responseText
          );
        },
        success: function(response) {
          var result = jQuery.parseJSON(response);
          console.log('response from server', result);
          $('#idp').val(result.data);
          $('#preparedby').val(result.data1);
          $('#position').val(result.data2);






        },


      });

    });


    $(function() {


      $("#ypreby").select2({
        //  minimumInputLength: 3,
        // placeholder: "hello",
        ajax: {
          url: "ypreparedby_query", // json datasource
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },

          processResults: function(response) {
            return {
              results: response


            };
          },
          cache: true,
          error: function(xhr, b, c) {
            console.log(
              "xhr=" +
              xhr.responseText +
              " b=" +
              b.responseText +
              " c=" +
              c.responseText
            );
          }
        }
      });
    });



    $('#ypreby').on('change', function() {
      var idp = this.value;
      console.log(idp);
      $.ajax({
        type: "POST",
        url: 'ypreparedby.php',
        data: {
          idp: idp
        },
        error: function(xhr, b, c) {
          console.log(
            "xhr=" +
            xhr.responseText +
            " b=" +
            b.responseText +
            " c=" +
            c.responseText
          );
        },
        success: function(response) {
          var result = jQuery.parseJSON(response);
          console.log('response from server', result);
          $('#idp').val(result.data);
          $('#ypreparedby').val(result.data1);
          $('#yposition').val(result.data2);






        },


      });

    });




    $('#printlink').click(function() {
      var objid = $('#objid').val();
      var date_from1 = $('#dtefrom').val();
      var date_to = $('#dteto').val();
      var masname1 = $('#masname1').val();
      var barangay1 = $('#barangay1').val();
      var street1 = $('#street').val();
      var preparedby = $('#preparedby').val();
      var position = $('#position').val();


      console.log(objid);
      var param = "objid=" + objid + "&masname1=" + masname1 + "&barangay=" + barangay1 + "&street=" + street1 + "&preparedby=" + preparedby + "&position=" + position + "&datefrom=" + date_from1 + "&dateto=" + date_to + "";
      $('#printlink').attr("href", "../plugins/jasperreport/dailypayment.php?" + param, '_parent');
    })



    $('#printlink2').click(function() {
      var objid = $('#objid').val();
      var masname1 = $('#masname1').val();
      var ydate_from1 = $('#ydtefrom').val();
      var ydate_to1 = $('#ydteto').val();
      var ypreparedby = $('#ypreparedby').val();
      var yposition = $('#yposition').val();

      var ystreet = $('#ystreet').val();
      var ybarangay1 = $('#ybarangay1').val();



      console.log(objid);
      var param = "objid=" + objid + "&masname1=" + masname1 + "&ystreet=" + ystreet + "&ybarangay1=" + ybarangay1 + "&ydatefrom1=" + ydate_from1 + "&ydateto1=" + ydate_to1 + "&ypreparedby=" + ypreparedby + "&yposition=" + yposition + "";
      $('#printlink2').attr("href", "../plugins/jasperreport/yearlypayment.php?" + param, '_parent');
    })
  </script>
</body>

</html>