<?php 
session_start();
$_SESSION['script']=true;
for($i=0;$i<1000000;$i++){
        echo "\n";
   }
if($_GET['config']) {
    $_SESSION['config']=$_GET['config'];
    require_once('./'.$_GET['config'].'.php');
} else {
    unset($_SESSION['config']);
    require_once('./config.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./colors.css">
    <link href="https://roadrunner.wholeroute.com/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <title>Report an Incident</title>
</head>
<body>
    <div class="container-fluid row mx-0 mt-5">
        <h2 class="col-md-12 text-center h2 mb-3">Report an Incident</h2>
        <div class="col-md-4 offset-md-4 mb-3">
            <div class="progress">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"></div>
            </div>
        </div>
        <form class="col-md-12 m-auto" action="post.php" method="post">
            
            <!-- STEP 1 -->
            <div class="card step" id="step-1">
                <div class="card-header text-center">
                    <h4 class="text-primary my-2">Your Information</h4>
                    </div>
                    <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first-name" class="form-control" required>        
                        </div>
                        <div class="col-md-4">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last-name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="company">Company</label>
                            <input type="text" id="company" name="company" class="form-control" placeholder="(Optional)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="phone">Phone #</label>
                            <input type="tel" id="phone" name="phone" class="form-control phone" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phone-alt">Alternate Phone #</label>
                            <input type="tel" id="phone-alt" name="phone-alt" class="form-control phone" placeholder="(Optional)">
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="witness_indi">Are you a Witness or Affected Individual?</label>
                            <div class="row container">
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="witness" name="witness_indi" value="Witness" checked>
                                    <label class="custom-control-label" for="witness" >Witness</label>
                                </div>
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="individual" name="witness_indi" value="Affected Individual">
                                    <label class="custom-control-label" for="individual" >Affected Individual</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success" onclick="switchTo('#step-2');">Next<i class="fa fa-arrow-right ml-2"></i></button>
                            <span class="spinner-border text-success d-none" id="loader" role="status">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- STEP 2 -->
            <div class="card step" id="step-2">
                <div class="card-header text-center">
                    <h4 class="text-primary my-2">Incident Information</h4>
                    </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="date-time">Date & Time of Incident</label>
                            <input type="datetime-local" id="date-time" name="date-time" class="form-control" required>        
                        </div>
                        <div class="col-md-6">
                            <label for="address">Where did the incident happen?</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="type">Incident Type</label>
                            <select name="type" class="form-control" id="type">
                                <option value="Vehicle Accident">Vehicle Accident</option>
                                <option value="Reckless Driving">Reckless Driving</option>
                                <option value="Dispute">Dispute</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="incident-description" class="mt-3">Describe the Incident</label>
                            <textarea name="incident-description" class="form-control" id="incident-description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="injuries">Were there any Injuries?</label>
                            <div class="container row">
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="injuries-no" name="injuries" value="No" checked>
                                    <label class="custom-control-label" for="injuries-no" >No</label>
                                </div>
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="injuries-yes" name="injuries" value="Yes">
                                    <label class="custom-control-label" for="injuries-yes" >Yes</label>
                                </div>
                            </div>
                            <label for="injuries-description" class="mt-4">Describe the Injuries</label>
                            <textarea name="injuries-description" class="form-control" id="injuries-description" rows="3" disabled></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="police">Were police involved?</label>
                            <div class="container row">
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="police-no" name="police" value="No" checked>
                                    <label class="custom-control-label" for="police-no" >No</label>
                                </div>
                                <div class="custom-control custom-switch mt-2 col-md-auto">
                                    <input type="radio" class="custom-control-input" id="police-yes" value="Yes" name="police">
                                    <label class="custom-control-label" for="police-yes" >Yes</label>
                                </div>
                            </div>
                            <label for="police-report" class="mt-4">Police Report #</label>
                            <input type="text" name="police-report" class="form-control" id="police-report" placeholder="(If available)" disabled/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="remedy">
                                Explain actions that you see fit to remedy this incident:
                            </label>
                            <textarea id="remedy" name="remedy" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="switchTo('#step-1');"><i class="fa fa-arrow-left mr-2"></i>Previous</button>
                            <button type="button" class="btn btn-success" onclick="switchTo('#step-3');">Next<i class="fa fa-arrow-right ml-2"></i></button>
                            <span class="spinner-border text-success d-none" id="loader" role="status">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- STEP 3 -->
            <div class="card step" id="step-3">
                <div class="card-header text-center">
                    <h4 class="text-primary my-2">Additional Information</h4>
                    </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <h4 class="text-center border-bottom py-2 mb-4">Affected Individuals</h4>
                            <div id="affected">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Full Name</label>
                                        <input type="text" name="affected-name-1" class="form-control"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Contact #</label>
                                        <input type="text" name="affected-phone-1" class="phone form-control"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input type="email" name="affected-email-1" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-end">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block" onclick="addAffected();"><i class="fa fa-plus mr-2"></i>Add Individual</button>
                                    <button type="button" id="remove-affected" class="d-none btn btn-danger btn-block" onclick="removeAffected();"><i class="fa fa-minus mr-2"></i>Remove Individual</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <h4 class="text-center border-bottom py-2 mb-4">Witnesses</h4>
                            <div id="witnesses">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Full Name</label>
                                        <input type="text" name="witness-name-1" class="form-control"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Contact #</label>
                                        <input type="text" name="witness-phone-1" class="phone form-control"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input type="email" name="witness-email-1" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-end">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block" onclick="addWitness();"><i class="fa fa-plus mr-2"></i>Add Witness</button>
                                    <button type="button" id="remove-witness" class="d-none btn btn-danger btn-block" onclick="removeWitness();"><i class="fa fa-minus mr-2"></i>Remove Witness</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="switchTo('#step-2');"><i class="fa fa-arrow-left mr-2"></i>Previous</button>
                            <button type="button" class="btn btn-success" onclick="switchTo('#step-4');">Next<i class="fa fa-arrow-right ml-2"></i></button>
                            <span class="spinner-border text-success d-none" id="loader" role="status">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- STEP 4 -->
            
            <div class="card step" id="step-4">
                <div class="card-header text-center">
                    <h4 class="text-primary my-2">Review Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4" id="review-info">
                            <div class="col-md-4 pt-3 border">
                                <h4 class="border-bottom pb-3">Your Information</h4>
                                <p>
                                    <strong>First Name : </strong><span id="review-first-name"></span>
                                    <br/>
                                    <strong>Last Name : </strong><span id="review-last-name"></span>
                                    <br/>
                                    <strong>Company : </strong><span id="review-company"></span>
                                    <br/>
                                    <strong>Phone # : </strong><span id="review-phone"></span>
                                    <br/>
                                    <strong>Alternate Phone # : </strong><span id="review-phone-alt"></span>
                                    <br/>
                                    <strong>Email : </strong><span id="review-email"></span>
                                    <br/>
                                    <strong>Witness/Affected Individual? : </strong><span id="review-witness_indi"></span>
                                </p>
                            </div>
                            <div class="col-md-4 pt-3 border">
                                <h4 class="border-bottom pb-3">Incident Information</h4>
                                <p>
                                    <strong>Date & Time : </strong><span id="review-date-time"></span>
                                    <br/>
                                    <strong>Location : </strong><span id="review-address"></span>
                                    <br/>
                                    <strong>Incident Type : </strong><span id="review-type"></span>
                                    <br/>
                                    <strong>Incident Description : </strong><span id="review-incident-description"></span>
                                    <br/>
                                    <strong>Injuries? : </strong><span id="review-injuries"></span>
                                    <br/>
                                    <strong>Injuries Description : </strong><span id="review-injuries-description"></span>
                                    <br/>
                                    <strong>Police Involved? : </strong><span id="review-police"></span>
                                    <br/>
                                    <strong>Police Report # : </strong><span id="review-police-report"></span>
                                    <br/>
                                    <strong>Actions that you see fit to remedy this incident : </strong><span id="review-remedy"></span>
                                </p>
                            </div>
                            <div class="col-md-4 pt-3 border">
                                <h4 class="border-bottom pb-3">Additional Information</h4>
                                <p>
                                    <strong>Affected Individuals : </strong><br/>
                                    <span id="review-affected">
                                    </span>
                                    <br/><br/>
                                    <strong>Witnesses : </strong><br/>
                                    <span id="review-witness">
                                    </span>
                                </p>
                            </div>
                        </div>
                    <div class="form-group row align-items-center mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="switchTo('#step-3');"><i class="fa fa-arrow-left mr-2"></i>Previous</button>
                            <button id="submit" type="button" class="btn btn-success">Submit<i class="fa fa-check ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Thank you Modal -->
    <div class="modal fade" id="thank-you" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title">Thank You!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            Your report has been submitted, we will respond back shortly.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success px-5" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
    </div>

    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$GoogleApiKey?>&libraries=places"></script>
    <script id="script" src="./script.php?v=<?=uniqid()?>"></script>
</body>
</html>