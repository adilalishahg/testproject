<?php
include_once('../DBAccess/newDatabase.inc.php');
   
// include_once('../Classes/MyMailer.php');
// include_once('../Classes/mapquest_google_miles.class.php');	
// include_once('../milesfunction.php');
// $mile_C = new mapquest_google_miles;
// $local = $db->database_host;
$server = $_SERVER['HTTP_ORIGIN'];
	$db = new Database;	
    $msgs = '';
	$noRec = '';
	$msgs .= $_GET['msg'];
	$db = new Database;	
	// $mail = new MyMailer;
	$db->connect();
	$capped_miles=0;
    // print_r($part2);echo"/";
    // echo"<br>";
    $address = $server.$part2;
    // echo"<pre>";
    // print_r($db );exit;

 $qry_vehtype  = "SELECT id,vname FROM  vehicles";
 if($db->query($qry_vehtype) && $db->get_num_rows() > 0){
     $vehiclepref = $db->fetch_all_assoc();
  } 
 
//   echo"<pre>";
// print_r($_SESSION);

///------------       Render php array to HTML        ----------------//////////////  
$foreach = function ($arr, $param) {
	$result = '';
	foreach ($arr as $key => $value) {
        // print_r($value);
		$search = ["{key}", "{value}"];
		$replace = [$value['id'], $value['vname']];
		$result .= str_replace($search, $replace, $param);
	}
	return $result;
};

echo <<<END
<!DOCTYPE html><!--  Last Published: Tue May 31 2022 21:38:56 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="623a5ce18ffc14c99cd03d23" data-wf-site="623a5ce18ffc148a4dd03d27">
<head>
  <meta charset="utf-8">
  <title>Request a trip</title>
  <meta content="Request a trip" property="og:title">
  <meta content="Request a trip" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="../css/normalize.css" rel="stylesheet" type="text/css">
  <link href="../css/components.css" rel="stylesheet" type="text/css">
  <link href="../css/fpe-transport.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> 
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/ui.datepicker.js"></script>

        <script src="https://kit.fontawesome.com/0e3976740b.js" crossorigin="anonymous"></script>
        <script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBBE53xDKH93kCWSWREyehlzH8N_t2R2lw"></script>
        <!-- <script language="JavaScript" type="text/javascript" src="js/suggest.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggest2.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggestpick.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggestdrop.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggestdrop3.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggestdrop4.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/suggestdrop5.js"></script> -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Lora:regular,500,600,700,italic"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.png" rel="apple-touch-icon">

<script type="text/javascript">
    $(document).ready(function(){	
        
$("#dob1").datepicker( {yearRange:'-120:00',dateFormat: 'mm/dd/yy' } );
$("#appdate").datepicker( {yearRange:'-120:00',dateFormat: 'mm/dd/yy' } );
            $("#dob1").mask("99/99/9999");
            $("#appdate").mask("99/99/9999");
            $("#phnum").mask("(999) 999-9999");
            $("#d_phnum").mask("(999) 999-9999");
            $("#d_phnum2").mask("(999) 999-9999");
            $("#d_phnum3").mask("(999) 999-9999");
            $("#p_phnum").mask("(999) 999-9999");
            $("#ins_fax").mask("(999) 999-9999");
            $('#org_apptime').mask('19:59');
            $('#apptime').mask('19:59');
            $('#returnpickup').mask('19:59');
$('#adduser').validate({
submitHandler: function(form) {
    // do other things for a valid form
 $('#submitB').hide();
 form.submit();
  }
});
});
$('#org_apptime').mask('19:59');
$('#apptime').mask('19:59');
function time(t){ 
//var atime = document.getElementById('t').value; 
var atime = $('#'+t).val();
// alert(atime);
var hours = atime.split(':');
var hour = hours[0];
var minut = hours[1]; 
if(hour >12 || minut >59) 
{
alert('Please enter correct 12 Hours AM/PM  Format!');
$('#'+t).val('');
return false }}
    function chTrip(a){
                
                if(a=='Round Trip'){
                    document.getElementById('return').style.display="block";
                    document.getElementById('rpu').style.display="block";
                    document.getElementById('rpu2').style.display="block";
                }
                // if(a=='Three Way'){
                //     document.getElementById('rpu').style.display="block";
                //     document.getElementById('rpu2').style.display="block";
                //     document.getElementById('3rd').style.display="block";
                //     document.getElementById('return').style.display="block";
                // }
                // if(a=='Four Way'){
                //     document.getElementById('rpu').style.display="block";
                //     document.getElementById('rpu2').style.display="block";
                //     document.getElementById('3rd').style.display="block";
                //     document.getElementById('4th').style.display="block";
                //     document.getElementById('return').style.display="block";
                // }
                if(a=='One Way'){
                    document.getElementById('rpu').style.display="none";
                    document.getElementById('rpu2').style.display="none";
                    // document.getElementById('3rd').style.display="none";
                    // document.getElementById('4th').style.display="none";
                    document.getElementById('return').style.display="none";
                }
            }
            function Fill(a){
                if($(a).is(":checked")){
                    pick_loc = $("#picklocation").val();
                    p_address = $("#pickaddress").val();
                    p_room = $("#psuiteroom").val();
                    p_instr = $("#pickup_instruction").val();
                   
                        $("#backtolocation").val(pick_loc);
                        $("#backtolocation").text(pick_loc);
                        $("#autocomplete3").val(p_address);
                        $("#autocomplete3").text(p_address);
                        $("#bsuiteroom").val(p_room);
                        $("#bsuiteroom").text(p_room);
                        $("#backto_instruction").val(p_instr);
                        $("#backto_instruction").text(p_instr);

                        
                    }else{
                        $("#backtolocation").val('');
                        $("#backtolocation").text('');
                        $("#autocomplete3").val('');
                        $("#autocomplete3").text('');
                        $("#bsuiteroom").val('');
                        $("#bsuiteroom").text('');
                        $("#backto_instruction").val('');
                        $("#backto_instruction").text('');
                    }
            }
</script>
  
</head>
<body style="opacity:0" class="body">
  <div data-collapse="medium" data-animation="over-right" data-duration="500" data-easing="ease-out" data-easing2="ease-out" data-doc-height="1" role="banner" class="navbar w-nav">
    <div class="html-embed w-embed">
      <style>
@media screen and (max-width: 991px) {
.navmenu {
overflow-y:scroll;
}
.navmenu::-webkit-scrollbar{
	display:none;
}
}

.input-group-addon {
    padding: 1px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #555;
    text-align: center;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: Lato, sans-serif;
}
</style>
    </div>
    <div class="nav-container w-container">
      <a href="../index.html" class="brand mobile w-nav-brand"><img src="../images/logow.png" loading="lazy" alt="" class="logo"></a>
      <nav role="navigation" class="navmenu w-nav-menu">
        <div class="div-block-76">
          <ul role="list" class="headernav left">
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="../index.html" class="navbarlink">Home</a>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="../about.html" class="navbarlink">About us</a>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div data-hover="true" data-delay="0" class="nav-link-drop-down-2 dropdown w-dropdown">
                <div class="navbarlink dropdpwn w-dropdown-toggle">
                  <div class="navbarlinkwrapper-2">
                    <div class="bg-2 navbarlinkicon"></div>
                    <div class="navbarlink">Services</div>
                  </div>
                </div>
                <nav class="dropdown-list w-dropdown-list">
                  <div class="dropdown-list-wrapper">
                    <a href="../medical-transportation.html" class="dropdownlink w-dropdown-link">Medical Transportation</a>
                    <a href="../personal-transportation.html" class="dropdownlink w-dropdown-link">Personal Transportation and Shuttles</a>
                    <a href="../medical-equipment-transport.html" class="dropdownlink w-dropdown-link">Medical Equipment Transport</a>
                    <a href="../wheelchair-ramps-services.html" class="dropdownlink w-dropdown-link">Wheelchair Ramps Services</a>
                  </div>
                </nav>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="/#area" class="navbarlink">Service Areas</a>
              </div>
            </li>
          </ul>
          <a href="../index.html" class="brand w-nav-brand"><img src="../images/logow.png" loading="lazy" alt="" class="logo"></a>
          <ul role="list" class="headernav right">
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="../careers.html" class="navbarlink">Careers</a>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="#contact" class="navbarlink w-nav-link">Contact</a>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="../report-an-incident.html" class="navbarlink w-nav-link">Incident</a>
              </div>
            </li>
            <li class="new-item-wrapper">
              <div class="navbarlinkwrapper-2">
                <div class="bg-2 navbarlinkicon"></div>
                <a href="request-a-trip.php" aria-current="page" class="navbarlink main w-nav-link w--current">Book a Trip</a>
              </div>
            </li>
          </ul>
          <div class="div-block-11 hide mobile">
            <div class="text-block-4">FPE Transport<br></div>
            <div class="text-block-10">
              <a href="tel:+19103223087" class="link navcontactlink">P: 910-322-3087</a>
            </div>
            <div class="text-block-10">
              <a href="mailto:ncfpellc@mail.com" class="link navcontactlink">E: ncfpellc@gmail.com<br></a>
              <a href="#"> </a><br>
            </div>
          </div>
        </div>
      </nav>
      <div class="nav-menu-button w-nav-button">
        <div class="button-wrapper">
          <div class="navbuttonicons">
            <div class="hearder-button-line-top"></div>
            <div class="hearder-button-line-medium"></div>
            <div class="hearder-button-line-bottom"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="pagewrap">
    <div id="Hero-Section" data-w-id="8ae4eba2-2158-24fc-3729-a608153310b3" class="topsection wf-section"><img src="../images/driver55.png" srcset="../images/driver55-p-500.png 500w, ../images/driver55-p-800.png 800w, ../images/driver55-p-1080.png 1080w, ../images/driver55.png 1200w" sizes="100vw" alt="" class="image-4 p2">
      <div class="container w-container">
        <div class="topsectionwraaper">
          <div class="div-block-18 overflow">
            <h1 class="topsectiontitle left">Trip </h1>
            <h1 class="topsectiontitle right"> Request</h1>
          </div>
          <div class="div-block-19 overflow">
            <p style="-webkit-transform:translate3d(0, 100%, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 100%, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 100%, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 100%, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0)" class="detail-paragraph subpage">Available <strong>24 hours</strong><br></p>
          </div>
        </div>
      </div>
    </div>
    <div id="tripform" class="tripsection wf-section">
      <div class="formcontainer w-container">
        <div class="iframecode  w-embed w-iframe w-script">
          <form id="contact-form" method="post" name="request_form" action="new.php" autocomplete="off">
            <div class="form-row">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        New Trip Request</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <!-- <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="name">Account Name *</label></span>
                            <select name="account"  id="account" required="required" class="form-control"autocomplete="off">
                                
                            </select>
                        </div>
                    </div> -->
                    <div class="col-sm-6" >
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="pname">Patient Name *</label></span>
                            <input type="text" name="pname" class="form-control" id="pname" value="" placeholder="Patient Name"  maxlength="50" autocomplete="off"  > 
                            <div id="layer1"></div>
                            </div>
                    </div>
                   


                    <div class="col-sm-6" >
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="phnum">Patient Phone No *</label></span>
                            <input type="text" name="phnum" class="form-control" id="phnum" placeholder="Phone Number" maxlength="16" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <div class="col-sm-6" >
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle" style=""><label
                                    for="name">PO #</label></span>
                            <input type="text" name="po" class="form-control" id="po" placeholder="Postal Address">
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div class="input-group">
                            <!-- Date input -->
                            <label class="input-group-addon" id="spanstyle"
                                for="dob">Date</label>
                            <input class="form-control" id="dob1" name="dob" placeholder="MM/DD/YYY" type="text" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="triptype">Select Trip Type *</label></span>
                            <select name="triptype" id="triptype" class="form-control" onchange="return chTrip(this.value);">
                                <option value="One Way">One Way--(1 Destination) </option>
                                <option value="Round Trip">Two Way--(Round Trip) </option>
                                <!-- <option value="Three Way">Three Way--(3 Destinations) </option>
                                <option value="Four Way">Four Way--(4 Destinations) </option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="triptype">Vehicle Preference *</label></span>
                            <select name="vehtype" id="vehtype" required="required"
                                class="form-control" onchange="bringlocations(this.value,this)"
                                autocomplete="off">
                                {$foreach($vehiclepref,"<option value= {key}>{value}</option>")}
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top:20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="oxygen">Oxygen Needed ?</label></span>
                            <select name="oxygen" id="oxygen" required="required" class="form-control">
                                <option value="no">No </option>
                                <option value="yes">Yes </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <!-- Date input -->
                            <label class="input-group-addon" id="spanstyle"
                                for="appointment_date">Appointment Date *</label>
                            <input class="form-control" id="appdate" name="appdate" placeholder="MM/DD/YYY" type="text" />
                        </div>
                    </div>


                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="pnum">PickUp Time *</label></span>
                            <input type="text" name="apptime" id="apptime" value="" class="form-control time"
                                placeholder=" (e.g. 10:30 AM )" maxlength="8" required="required"
                                 onblur="javascript:time(this.id);">
                            <span class="input-group-addon" id="spanstyle">
                                <select name="apptimerad" id="apptimerad">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </span>
                            <!-- <span class="input-group-addon" id="spanstyle"><a
                                    onclick="CheckdriversAvailibility('driver_availibility.php','pick')"> Check Free
                                    Drivers Time Slots</a>
                            </span> -->
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="pnum">Appointment Time *</label></span>
                            <input type="text" name="org_apptime" id="org_apptime" value="" class="form-control time"
                                placeholder=" (e.g. 10:30 AM )" maxlength="8" required="required"
                                 onblur="return time(this.id);">
                            <span class="input-group-addon" id="spanstyle">
                                <select name="org_apptimerad" id="org_apptimerad">
                                    <option value="am">AM</option>  
                                    <option value="pm">PM</option>
                                </select>
                            </span>

                        </div>
                    </div>
                    <div class="col-sm-6" id="rpu" style="margin-top: 20px; display:none;" >
							<div class="input-group">
							<span class="input-group-addon" id="spanstyle"><label>Return Pickup(For last destination)</label></span>
							<select name="puchoice" id="puchoice" onchange="return pUchoice(this.value);" class="form-control" onkeypress="return disableEnterKey(event)">
								<option value="Time">Time</option>
                                <option value="Will Call">Will Call</option>
							</select>
							</div>
					</div>
                    <div class="col-sm-6" id="rpu2" style="margin-top: 20px; display:none;" >
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label
                                    for="pnum">Return Pick Time *</label></span>
                            <input type="text" name="returnpickup" id="returnpickup"  class="form-control"
                                placeholder="Return Pick Up Time" maxlength="8" 
                                onblur="return time(this.id);">
                            <span class="input-group-addon" id="spanstyle">
                                <select name="returnpickuprad" id="returnpickuprad">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </span>
                            <span class="input-group-addon" id="spanstyle"><a
                                    onclick="CheckdriversAvailibility('driver_availibility.php','pick')"> Check Free
                                    Drivers Time Slots</a>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        PickUp Information</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Pickup Location *</label></span>
                            <input type="text" name="picklocation" class="form-control" id="picklocation"
                                placeholder="PickUp Location">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Pickup Address *</label></span>
                            <input type="text" name="pickaddress" class="form-control" id="autocomplete"
                                placeholder="PickUp Address">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Suite/Apt/Bld/Room *</label></span>
                            <input type="text" name="psuiteroom" class="form-control" id="psuiteroom"
                                placeholder="Suite/Apt/Bld/Room">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Destination Phone Number</label></span>
                            <input type="text" name="d_phnum" class="form-control" id="d_phnum"
                                placeholder="Destination Phone Number">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">PickUp Instructions</label></span>
                            <textarea name="pickup_instruction" id="pickup_instruction" class="form-control"
                                placeholder="PickUp Instructions"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">PickUp Phone Number</label></span>
                            <input type="text" name="p_phnum" class="form-control" id="p_phnum"
                                placeholder="PickUp Phone Number">
                        </div>
                    </div>



                </div>
            </div>
     <!---First Address-->    
        <div class="form-row">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        First Destination Address</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Drop Location *</label></span>
                            <input type="text" name="droplocation" class="form-control" id="droplocation"
                                placeholder="PickUp Location">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Drop Address *</label></span>
                            <input type="text" name="destination" class="form-control" id="autocomplete2"
                                placeholder="Drop Address">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Suite/Apt/Bld/Room *</label></span>
                            <input type="text" name="dsuiteroom" class="form-control" id="dsuiteroom"
                                placeholder="Suite/Apt/Bld/Room">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Destination Phone Number</label></span>
                            <input type="text" name="d_phnum" class="form-control" id="d_phnum"
                                placeholder="Destination Phone Number">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Destination Instructions</label></span>
                            <textarea name="destination_instruction" id="destination_instruction" class="form-control"
                                placeholder="Destination Instructions"></textarea>
                        </div>
                    </div>



                </div>
            </div>
            <!-- <div class="form-row" id="3rd" style="display: none;">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        Second Destination Address</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="three_pickup_time">2nd Pick Time *</span>
                            <input class="form-control  time" type="text" name="three_pickup" id="three_pickup" value="" maxlength="5" onblur="javascript:time(this.id);" onkeypress="return disableEnterKey(event)">
                            <span class="input-group-addon"><select name="three_pickuprad" id="three_pickuprad">
                                <option value="am">AM</option><option value="pm">PM</option></select></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Will Call *</label></span>
                            <input type="checkbox" id="three_will_call"  name="three_will_call" aria-label="Checkbox for following text input" style="margin-left: 300px; width:40px; height:40px;">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">2nd Destination Address *</label></span>
                            <input type="text" name="droplocation2" class="form-control" id="droplocation2"
                                placeholder="Drop Address">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">2nd Destination Location *</label></span>
                            <input type="text" name="destination2" class="form-control" id="destination2"
                                placeholder="2nd Destination Location">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Suite/Apt/Bld/Room *</label></span>
                            <input type="text" name="dsuiteroom2" class="form-control" id="dsuiteroom2"
                                placeholder="Suite/Apt/Bld/Room">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">2nd Destination Phone Number</label></span>
                            <input type="text" name="d_phnum2" class="form-control" id="d_phnum2"
                                placeholder="Destination Phone Number">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">2nd Destination Instructions</label></span>
                            <textarea name="destination_instruction2" id="destination_instruction2" class="form-control"
                                placeholder="Destination Instructions"></textarea>
                        </div>
                    </div>



                </div>
            </div>
            <div class="form-row" id = "4th" style="display:none">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        Third Destination Address</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="three_pickup_time">3rd Pick Time *</span>
                            <input class="form-control  time" type="text" name="four_pickup" id="four_pickup" value="" maxlength="5" onblur="javascript:time(this.id);" onkeypress="return disableEnterKey(event)">
                            <span class="input-group-addon"><select name="four_pickuprad" id="four_pickuprad">
                                <option value="am">AM</option><option value="pm">PM</option></select></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Will Call *</label></span>
                            <input type="checkbox" id="four_will_call"  name="four_will_call" aria-label="Checkbox for following text input" style="margin-left: 300px; width:40px; height:40px;">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">3rd Destination Location *</label></span>
                            <input type="text" name="droplocation3" class="form-control" id="droplocation3"
                                placeholder="Drop Address">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">3rd Destination Address *</label></span>
                            <input type="text" name="destination3" class="form-control" id="destination3"
                                placeholder="2nd Destination Location">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Suite/Apt/Bld/Room *</label></span>
                            <input type="text" name="dsuiteroom3" class="form-control" id="dsuiteroom3"
                                placeholder="Suite/Apt/Bld/Room">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">3rd Destination Phone Number</label></span>
                            <input type="text" name="d_phnum3" class="form-control" id="d_phnum3"
                                placeholder="Destination Phone Number">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">3rd Destination Phone Number</label></span>
                            <textarea name="destination_instruction3" id="destination_instruction3" class="form-control"
                                placeholder="Destination Instructions"></textarea>
                        </div>
                    </div>



                </div>
            </div> -->
            <div class="form-row" id = "return" style="display:none">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        Last Destination Address</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    
                    
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Use Same Pickup Information</label></span>
                            <input type="checkbox" id="sameadd"  name="sameadd" aria-label="Checkbox for following text input" onclick="Fill(this)" style="margin-left: 200px; width:40px; height:40px;">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Back To Location *</label></span>
                            <input type="text" name="backtolocation" class="form-control" id="backtolocation"
                                placeholder="Return Location">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Back To Address *</label></span>
                            <input type="text" name="backto" class="form-control" id="autocomplete3"
                                placeholder="Return Address">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" style="background-color: rgba(65, 140, 150, 0.151);    height: 50px;"><label for="name">Suite/Apt/Bld/Room *</label></span>
                            <input type="text" name="bsuiteroom" class="form-control" style="height: 50px;" id="bsuiteroom"
                                placeholder="Suite/Apt/Bld/Room">
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-top: 20px;">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Back to Instructions</label></span>
                            <textarea name="backto_instruction" id="backto_instruction" class="form-control"
                                placeholder="Destination Instructions"></textarea>
                        </div>
                    </div>



                </div>
            </div>
            <div class="form-row">
                <div class="row">
                    <div class="col-sm-12 "
                        style="font-size:24px;margin-top:20px;text-align:center;background-color: #141e25;color:#fff;">
                        Comments OR Notes</div>
                </div>
                <div class="row" style="margin-top:20px;margin-left:20px;">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="spanstyle"><label for="name">Comments *</label></span>
                            <textarea name="comments" id="comments" class="form-control" rows="2" placeholder="Enter Trip Comments"></textarea>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:20px; margin-left:50%;">
                <button type="submit" name="submit" id="submit" value="submit" style="background-color: #141e25;color:#fff;" class="btn btn-primary btn-lg">Submit Request</button>
				<!--<button type="reset" name="" class="btn btn-primary btn-lg" >Reset</button>-->
		    </div>
        </form>
          <!-- <iframe src="form.html" frameborder="0" style="width:100%;border:none;"></iframe>
          <script>
 window.onload=function() { 
 window.onmessage=(e)=>{ 
 if(e.data=='scrollToIframe') { 
 document.querySelector('iframe').scrollIntoView(); 
 } 
 if(e.data.split('-')[0]=='height') { 
 document.querySelector('iframe').height=e.data.split('-')[1]+'px'; 
 } 
 }; 
   } 
 </script> -->
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="footwrapper wf-section">
        <div class="container f w-container">
          <div id="w-node-dcbd25a6-dc08-522d-1a2e-a7f00cee5e2f-f300c91e" class="footer-content-block">
            <h4 class="footertitle-2">Our company</h4>
            <a href="../about.html" class="footermenu-2 sub first"><span class="space-2"></span>About Us</a>
            <a href="../medical-transportation.html" class="footermenu-2 sub">Medical Transportation</a>
            <a href="#" class="footermenu-2 sub">Personal Transportation and Shuttles</a>
            <a href="../medical-equipment-transport.html" class="footermenu-2 sub">Medical Equipment Transport</a>
            <a href="../wheelchair-ramps-services.html" class="footermenu-2 sub">Wheelchair Ramps Services</a>
          </div>
          <div id="w-node-dcbd25a6-dc08-522d-1a2e-a7f00cee5e5f-f300c91e" class="footer-content-block">
            <h4 class="footertitle-2">Helpful links</h4>
            <a href="../index.html" class="footermenu-2 sub first"><span class="space-2"></span>Home</a>
            <a href="request-a-trip.html" aria-current="page" class="footermenu-2 sub w--current"><span class="space-2"></span>Book a Trip</a>
            <a href="report-an-incident.html" class="footermenu-2 sub"><span class="space-2"></span>Report an incident</a>
            <a href="/#area" class="footermenu-2 sub">Service Area</a>
            <a href="careers.html" class="footermenu-2 sub"><span class="space-2"></span>Careers</a>
          </div>
          <div id="contact" class="footer-content-block w-node-dcbd25a6-dc08-522d-1a2e-a7f00cee5e7a-f300c91e">
            <h4 class="footertitle-2">Contact</h4>
            <div class="footeritemwrapper"><img src="images/Asset-1.png" loading="lazy" alt="" class="footer_icon-2">
              <p class="footerparagraph link">Fayetteville, NC 28311</p>
            </div>
            <div class="footeritemwrapper"><img src="https://uploads-ssl.webflow.com/60ef0ce44d30f751be71e633/60ef73dcb35502a2596793e0_icon-03.png" loading="lazy" alt="" class="footer_icon-2">
              <p class="footerparagraph link">
                <a href="tel:+19103223087" class="footerlink">(910) 322-3087</a>
              </p>
            </div>
            <div class="footeritemwrapper"><img src="https://uploads-ssl.webflow.com/60ef0ce44d30f751be71e633/60ef73dcb3550255ed6793da_icon-04.png" loading="lazy" alt="" class="footer_icon-2">
              <p class="footerparagraph link">
                <a href="mailto:ncfpellc@gmail.com" class="footerlink hidden-mobile">NCFPELlc@gmail.com</a>
              </p>
            </div>
            <a href="https://www.facebook.com/Roadrunner-Medical-Transportation-104715778576785/" target="_blank" class="footeritemwrapper media w-inline-block"><img src="images/facebook.png" loading="lazy" alt="" class="footer_icon-2 media">
              <p class="footerparagraph">Stay connected</p>
            </a>
          </div>
          <div id="w-node-_9aacbd00-52d2-40af-ac16-4a027fd7b0fd-f300c91e" class="div-block-72">
            <p class="footerparagraph"><strong>Service time</strong>: Monday - Saturday: 6:00 am - 6:00 pm<em> (Extended hours upon request)</em><br><strong>Payment methods: Cash, </strong>Debit &amp; Credit Cards, PayPal, CashApp, Venmo</p>
            <div class="div-block-64"><img src="images/visa1-1920w.png" loading="lazy" alt="" class="paymenticon"><img src="images/mastercard-1920w.png" loading="lazy" alt="" class="paymenticon"><img src="images/americanexpress-1920w.png" loading="lazy" alt="" class="paymenticon"><img src="images/discover-1920w.png" loading="lazy" alt="" class="paymenticon"><img src="images/iconpaypal.png" loading="lazy" alt="" class="paymenticon speical"><img src="images/iconcashapp.png" loading="lazy" sizes="(max-width: 479px) 20vw, (max-width: 1439px) 30px, (max-width: 1919px) 2vw, 30px" srcset="images/iconcashapp-p-500.png 500w, images/iconcashapp-p-800.png 800w, images/iconcashapp-p-1080.png 1080w, images/iconcashapp.png 1200w" alt="" class="paymenticon"><img src="images/iconvenmo.png" loading="lazy" sizes="(max-width: 479px) 20vw, (max-width: 1439px) 30px, (max-width: 1919px) 2vw, 30px" srcset="images/iconvenmo-p-500.png 500w, images/iconvenmo-p-800.png 800w, images/iconvenmo.png 1000w" alt="" class="paymenticon"></div>
          </div>
        </div>
        <div class="sub-footer-3">
          <div class="subfooterwrapper">
            <p class="subfootertext-2">© Copyright FPE Transport | Designed by <a href="https://wholeroute.com/" target="_blank" class="link-4">WholeRoute, LLC</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=623a5ce18ffc148a4dd03d27" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
  <script src="../js/fpe-transport.js" type="text/javascript"></script>
  <script src="../timepicker/dist/wickedpicker.min.js"></script>

<script>
  var twelveHour = $('.timepicker-12-hr').wickedpicker();
            $('.time').text('//JS Console: ' + twelveHour.wickedpicker('time'));
            $('.timepicker-24-hr').wickedpicker({twentyFour: true});
            $('.timepicker-12-hr-clearable').wickedpicker({clearable: true});
</script>

  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
  <style>
.body {
  overflow-x:hidden;
  max-width:100vw;
  }
</style>
</body>
</html>

END;

