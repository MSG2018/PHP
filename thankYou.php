<?php
/**
 * Created by PhpStorm.
 * User: SuccessEngine
 * Date: 2/8/16
 * Time: 1:52 AM
 */
session_start();

//checks session for approval
if(isset($_SESSION["approval"])) {
    $approved = $_SESSION["approval"];
}

?>


<html>
<head>
  <title> Event Tickets</title>

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  -->

    <link rel="stylesheet" href="http://bootswatch.com/yeti/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--jQuery validate -->

    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>


    <!-- Include Bootstrap-select CSS, JS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>

    <style type="text/css">
        #bootstrapSelectForm .selectContainer .form-control-feedback {
            /* Adjust feedback icon position */
            right: -15px;

        }
    </style>
</head>
<body>

<div class="alert alert-success text-center" >
   <strong>THANK YOU FOR YOUR ORDER</strong>  <br>
    <b>
    </b>
    <?php
      //checks for approval code then displays approval message
        if (isset($approved )) {
            foreach ($approved as $key => $value) {
            echo $key . " :" . $value;
            echo "<br>";
            }

            //unsets all session variables
            session_unset();
            session_destroy();

        }
    ?>
</div>

</body>


</html>
