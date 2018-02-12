<?php
/**
 * Created by PhpStorm.
 * User: Menia Gautier
 * Date: 2/9/16
 * Time: 3:45 PM
 */

session_start();

$showerrors = array();
if (isset($_SESSION["errors"])) {
    $showerrors = $_SESSION["errors"];
}

$declined = array();
if (isset($_SESSION["approval"])) {
    $declined = $_SESSION["approval"];
}

if (isset($_SESSION["orderid"])) {
    $order_id = $_SESSION["orderid"];
}


?>

<html>
<head>
    <title> Order Products</title>

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  -->


    <!-- jQuery library -->
    <script  type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!--jQuery validate library-->
    <script  type="text/javascript" src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <script  type="text/javascript" src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script  type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="http://bootswatch.com/journal/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">


    <!-- Include Bootstrap-select CSS, JS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css"/>
    <script  type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>


    <style type="text/css">
        #bootstrapSelectForm .selectContainer .form-control-feedback {
            /* Adjust feedback icon position */
            right: -15px;
            text-emphasis-color: #0000BB;
        }
    </style>


    <!-- styles for li and background -->
    <style type="text/css">
         li {
        color: #DD0000;
         }

        body {
            background-color: lightgrey;
        }
    </style>


</head>

<body>

<div id="container">


    <div class="row">
        <div class="panel panel-default  col-md-6 col-md-offset-3">
            <div class="panel-heading">
                <h3 class="panel-title"> Event Order

                   <!-- displays form errors in the header-->
                    <?php
                    //displays errors from form submission
                    if (is_array($showerrors) || is_object($showerrors)) {

                        foreach ($showerrors as $key => $value) {

                            echo "<li>".$value."</li>";
                        }
                    }
                    //Displays errors for declined credit card
                    if (is_array($declined) || is_object($declined)) {
                        foreach ($declined as $key => $value) {
                            echo "<li>".$key . " :" . $value."</li>";
                            echo "<br>";
                        }
                    }
                    ?>

                </h3>
            </div>
            <!-- ends panel heading  -->
              <div class="panel-body">

                <form role="form" id=“createOrder” name="createOrder" method="post" action="processOrder.php">

                    <fieldset><span
                            class="help-block"> Check one or more events and enter the quanity of tickets.</span>
                        <legend> 1. Select Tickets</legend>
                         <div class="row">
                            <div class="col-lg-6 form-group has feedback ">
                                <div class="input-group ">
                                    <span class="input-group-addon">
                                        <label for="event" class="control-label"> <input autofocus type="checkbox"
                                                                                         name="real_estate_con"
                                                                                         value="Real Estate Conference"
                                                                                         aria-label=" "> Real Estate
                                            Con  $75.00</label>
                                    </span>
                                    <input type="number"  value="" name="real_estate_tickets" class="form-control"
                                           aria-label="...">
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-6  form-group has feedback">
                                <div class="input-group ">
                                    <span class="input-group-addon">
                                         <label for="event"> <input type="checkbox" name="wellness_seminar"
                                                                    value="Wellness Seminar" aria-label="..."> Wellness
                                             Seminar $150</label>
                                    </span>
                                    <input type="number" value="" name="wellness_tickets" class="form-control"
                                           aria-label="...">

                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->

                        <br>
                    </fieldset><!-- end of select tickets fieldset  -->
                    <fieldset><!-- beginning of select subscription fieldset -->
                        <legend> 2. Add Subscriptions</legend>
                        <span
                            class="help-block"> Check one or more subscriptions and enter a quanity.</span>
                      <div class="row">
                          <div class="col-lg-6 form-group has feedback">


                              <div class="input-group ">
                                    <span class="input-group-addon">
                                         <label for="event"> <input type="checkbox" name="real_estate_mag_sub"
                                                                    value="real_estate_sub" aria-label="..."> Real Estate
                                             Mag $7.00</label>
                                    </span>
                                  <input type="number" value="" name="real_estate_mag_qty" class="form-control"
                                         aria-label="...">

                              </div><!-- /input-group -->


                          </div>

                          <div class="col-lg-6 form-group has feedback">


                              <div class="input-group ">
                                    <span class="input-group-addon">
                                         <label for="event"> <input type="checkbox" name="health_mag_sub"
                                                                    value="health_mag_sub" aria-label="..."> Health Journal $10.00
                                              </label>
                                    </span>
                                  <input type="number" value="" name="health_mag_qty" class="form-control"
                                         aria-label="...">

                              </div><!-- /input-group -->


                          </div>
                      </div>
                    </fieldset>
                    <br>
                    <fieldset><br>
                        <legend> 3. Personal Details</legend>
                        <div class="row">
                            <div class="form-group has feedback col-lg-6">
                                <label for="firstname" class="control-label"><span
                                        class="glyphicon glyphicon-user"></span> First Name:</label>
                                <input type="text" name="firstname" class="form-control input-sm"
                                       placeholder="First Name"
                                       value="<?php echo (isset($_SESSION["firstname"])) ? $_SESSION["firstname"] : ''; ?>">
                            </div> <!-- end of name div -->
                            <div class="form-group has feedback col-lg-6">
                                <label for="lastname" class="control-label"><span
                                        class="glyphicon glyphicon-user"></span> Last Name:</label>

                                <input type="text" class="form-control input-sm" placeholder="Last Name" name="lastname"
                                       id="lastname"
                                       value="<?php echo (isset($_SESSION["lastname"])) ? $_SESSION["lastname"] : ''; ?>">
                            </div> <!-- end of lastname div -->
                        </div>
                        <div class="row">
                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="email"><span
                                        class="glyphicon glyphicon-envelope"></span> Email address:</label>
                                <input type="email" class="form-control input-sm" placeholder="Email" name="email"
                                       id="email"
                                       value="<?php echo (isset($_SESSION["email"])) ? $_SESSION["email"] : ''; ?>">
                            </div>  <!-- end of email div  -->

                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="phone"><span
                                        class="glyphicon glyphicon-phone "></span> Phone:</label>
                                <input type="tel" class="form-control input-sm " placeholder="Phone" name="phone"
                                       id="phone"
                                       value="<?php echo (isset($_SESSION["phone"])) ? $_SESSION["phone"] : ''; ?>">
                            </div><!-- end of phone div -->
                        </div>
                        <div class="row">
                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="streetaddr"> Street Address</label>
                                <input type="text" class="form-control input-sm" placeholder="Street address"
                                       name="streetaddr" id="streetaddr"
                                       value="<?php echo (isset($_SESSION["streetaddr"])) ? $_SESSION["streetaddr"] : ''; ?>"
                                       required>
                            </div> <!-- end of streetaddr -->
                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="city"> City</label>
                                <input type="text" class="form-control input-sm" placeholder="City" id="city"
                                       name="city"
                                       value="<?php echo (isset($_SESSION["city"])) ? $_SESSION["city"] : ''; ?>"
                                       required>
                            </div><!-- end of city -->
                        </div> <!-- close row  city streetaddr -->
                        <div class="row">
                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="state"> State</label>
                                <input type="text" class="form-control input-sm" placeholder="State" name="state"
                                       id="state"
                                       value="<?php echo (isset($_SESSION["state"])) ? $_SESSION["state"] : ''; ?>"
                                       required>
                            </div><!-- end of state -->

                            <div class="form-group has feedback col-lg-6">
                                <label class="control-label" for="zip">Zip</label>
                                <input type="text" class="form-control input-sm" name="zip" placeholder="Zip" id="zip"
                                       value="<?php echo (isset($_SESSION["zip"])) ? $_SESSION["zip"] : ''; ?>"
                                       required>
                                <br>

                            </div><!-- end of zip -->
                        </div>
                    </fieldset><!-- end of personal details fieldset -->


                    <fieldset><br>
                        <legend> 4. Payment Details</legend>
                        <div class="row">
                            <div class="form-group has feedback col-lg-4 "> 
                                <label for="cc_type" class="control-label">Card Type</label> 
                                <select class="form-control input-sm" id="cc_type" name="cc_type"> 
                                    <option value="Visa">Visa</option>
                                     
                                    <option value="Mastercard">Mastercard</option>
                                     
                                    <option value="American Express">American Express</option>
                                     
                                    <option value="Discover">Discover</option>
                                     
                                </select> 
                            </div>

                            <div class="form-group has feedback col-lg-8"> 
                                <label for="ccnumber" class="control-label">
                                    <span  class="glyphicon glyphicon-credit-card"></span> Credit Card  Number:
                                </label> 
                                <input type="tel" name="ccnumber" class="form-control input-sm"  
                                       placeholder="Credit Card number">
                                  
                            </div><!-- end of card type and credit card number -->
                        </div> <!-- end of row -->
                        <div class="row">
                            <div class="form-group has feedback col-lg-3 "> 
                                <label for="cc_exp_mo" class="control-label">Exp. Month</label> 
                                <select class="form-control input-sm" id="cc_exp_mo" name="cc_exp_mo"> 
                                    <option value="01">01</option>
                                     
                                    <option value="02">02</option>
                                     
                                    <option value="03">03</option>
                                     
                                    <option value="04">04</option>
                                     
                                    <option value="05">05</option>
                                     
                                    <option value="06">06</option>
                                     
                                    <option value="07">07</option>
                                     
                                    <option value="08">08</option>
                                     
                                    <option value="09">09</option>
                                     
                                    <option value="10">10</option>
                                     
                                    <option value="11">11</option>
                                     
                                    <option value="12">12</option>
                                     
                                </select> 
                            </div><!-- end of select for Exp. month -->
                            <div class="form-group has feedback col-lg-6"> 
                                <label for="cc_exp_yr" class="control-label">Exp. Year</label> 
                                <select class="form-control input-sm" id="cc_exp_yr" name="cc_exp_yr"> 
                                    <?php
                                    $i = 0;
                                    $current_year = date('Y');;
                                    while ($i < 10) {
                                        $calculated_year = $current_year + $i;
                                        echo '<option value="' . $calculated_year . '">' . $calculated_year . '</option>';
                                        $i++;;
                                    }
                                    ?> 
                                </select> 
                                </div><!-- end of cc_exp_yr -->
                             <div class="form-group has feedback col-lg-3"> 
                                <label class="control-label" for="cc_ccv">CCV:</label> 
                                <input type="tel" class="form-control input-sm" placeholder="CCV"   name="cc_ccv"> 
                            </div>
                    </fieldset>

                    <button type="submit" class="btn btn-primary btn-block"> Buy Tickets</button>
             </form>
            <!-- ends Orderform  -->
        </div>
        <!-- ends panel-body -->
    </div>
    <!-- ends panel panel-default -->
</div>
<!-- ends row -->
</div>
<!-- ends container -->




<script>

    jQuery.validator.setDefaults({
        debug: false,
        success: "valid"


    });


    $("#createOrder").validate({
        rules: {


            firstname: {
                required: true
            },

            email: {
                required: true,
                email: true
            },


            ccnumber: {
                required: true,
                creditcard: true
            },

            city: {
                required: true
            },

            state: {
                required: true
            },
            streetaddr: {
                required: true
            },

            phone: {
                required: true,
                phoneUS: true
            },


            zip: {
                required: true
            },


            cc_ccv: {
                required: true
            },


            cc_exp_mo: {
                required: true
            },

            cc_exp_yr: {
                required: true
            }


        }
    });


</script>


</body>
</html>
