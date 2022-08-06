<?php
session_start();
$_SESSION['script']=true;
for($i=0;$i<1000000;$i++){
        echo "\n";
   }
require_once('./config.php');
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
    <title>Job Application</title>
</head>
<body>
    <div class="container-fluid row mx-0 mt-5">
        <h2 class="col-md-12 text-center h2 mb-3">Job Application</h2>
        <div class="col-md-4 offset-md-4 mb-3">
            <div class="progress">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"></div>
            </div>
        </div>
        <form class="col-md-12 m-auto" action="post.php" method="post">

            <!-- STEP 1 -->
            <div class="card step" id="step-1">
                <div class="card-header text-center">
                    <h4 class="text-primary my-2">Basic Information</h4>
                    </div>
                    <div class="card-body">
                    <div class="form-group row d-flex justify-content-center align-items-center border-bottom pb-4 mb-4">
                        <?php if($downloadApplication) { ?>
                        <div class="col-md-3">
                            <a href="<?=$pdflink?>" target="_blank" download class="card border-primary download" style="text-decoration:none!important;color:inherit!important;">
                                <div class="card-body text-center">Download Application</div>
                            </a>
                        </div>
                        <p class="text-muted col-md-12 text-center mt-4">OR</p>
                        <?php } ?>
                        <h4 class="col-md-12 text-center mb-4">Apply Online for:</h4>
                        <?php $first=true; foreach($positions as $position) { ?>
                            <div class="col-md-3">
                                <div class="card position border-primary">
                                    <div class="card-body text-center<?=($first)?' bg-primary text-light':''?>"><?=$position?></div>
                                </div>
                            </div>
                        <?php $first=false; } ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-md">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first-name" class="form-control" required>
                        </div>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last-name" class="form-control" required>
                        </div>
                        <?php if($above21) : ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="above21">Are you 21 or older?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="above21-yes" name="above21" value="Yes" required>
                                <label class="custom-control-label" for="above21-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="above21-no" name="above21" value="No" required>
                                <label class="custom-control-label" for="above21-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($birthDate): ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" required>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="phone">Phone #</label>
                            <input type="tel" id="phone" name="phone" class="form-control phone" required>
                        </div>
                        <div class="col-md-4 mt-2 mt-md-0">
                            <label for="phone-alt">Alternate Phone #</label>
                            <input type="tel" id="phone-alt" name="phone-alt" class="form-control phone">
                        </div>
                        <div class="col-md-4 mt-2 mt-md-0">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <input type="hidden" name="position" value="<?=$positions[0]?>">
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
                    <h4 class="text-primary my-2">Additional Information</h4>
                    </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="experience">Years of Experience as a <span id="position-title"><?=$positions[0]?></span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button" id="experienceminus"><i class="fa fa-minus"></i></button>
                                </div>
                                <input type="text" class="form-control text-center" placeholder="" id="experience" name="experience" value="1" onkeydown="return false;">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="experienceplus"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2 mt-md-0">
                            <label for="date">Date you can start work</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-2 mt-md-0">
                            <label for="hours">Available hours per week</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button" id="hoursminus"><i class="fa fa-minus"></i></button>
                                </div>
                                <input type="text" class="form-control text-center" placeholder="" id="hours" name="hours" value="1" onkeydown="return false;">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="hoursplus"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php if($vehicleDetails) { ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="vehicle">Do you have your own vehicle?</label>
                            <div class="custom-control custom-switch col-md-auto">
                                <input type="radio" class="custom-control-input" id="vehicle-yes" name="vehicle" value="Yes">
                                <label class="custom-control-label" for="vehicle-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch col-md-auto">
                                <input type="radio" class="custom-control-input" id="vehicle-no" name="vehicle" value="No" checked>
                                <label class="custom-control-label" for="vehicle-no" >No</label>
                            </div>
                            <div id="vehicle-details" class="d-none">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vehicle-year">Vehicle Year</label>
                                            <select class="form-control" id="vehicle-year" name="vehicle-year">
                                                <option value="">Select</option>
                                                <?php foreach($years as $year) { ?>
                                                <option value="<?=$year?>"><?=$year?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 mt-md-0">
                                        <div class="form-group">
                                            <label for="vehicle-make">Vehicle Make</label>
                                            <select class="form-control" id="vehicle-make" name="vehicle-make">
                                                <option value="">Select</option>
                                                <?php foreach($makes as $make) { ?>
                                                <option value="<?=$make?>"><?=$make?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicle-model">Vehicle Model</label>
                                            <input type="text" class="form-control" id="vehicle-model" name="vehicle-model">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md mt-2 mt-md-0">
                                        <div class="form-group">
                                            <label for="wheelchair">Wheelchair Accessible?</label>
                                            <div class="container row">
                                                <div class="custom-control custom-switch col-md-auto">
                                                    <input type="radio" class="custom-control-input" id="wheelchair-yes" name="wheelchair" value="Yes">
                                                    <label class="custom-control-label" for="wheelchair-yes" >Yes</label>
                                                </div>
                                                <div class="custom-control custom-switch col-md-auto">
                                                    <input type="radio" class="custom-control-input" id="wheelchair-no" name="wheelchair" value="No" checked>
                                                    <label class="custom-control-label" for="wheelchair-no" >No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($credentialsAndCertificates) { ?>
                        <div class="col-md mt-2 mt-md-0">
                            <div class="form-group">
                                <label for="wheelchair">Credentials and Certifications</label>
                                    <?php foreach($credcerts as $credcert) { ?>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input credcert" id="<?=$credcert?>" name="<?=$credcert?>" value="<?=$credcert?>">
                                        <label class="custom-control-label" for="<?=$credcert?>" ><?=$credcert?></label>
                                    </div>
                                    <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($speakEnglish) : ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="speakEnglish">Do you speak English fluently?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="speakEnglish-yes" name="speakEnglish" value="Yes" required>
                                <label class="custom-control-label" for="speakEnglish-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="speakEnglish-no" name="speakEnglish" value="No" required>
                                <label class="custom-control-label" for="speakEnglish-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($speakSpanish) : ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="speakSpanish">Do you speak Spanish fluently?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="speakSpanish-yes" name="speakSpanish" value="Yes" required>
                                <label class="custom-control-label" for="speakSpanish-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="speakSpanish-no" name="speakSpanish" value="No" required>
                                <label class="custom-control-label" for="speakSpanish-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="form-group row">
                        <?php if($canWork) : ?>
                        <div class="col-md">
                            <label for="canWork">Are you authorized to reside and work in the USA?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="canWork-yes" name="canWork" value="Yes" required>
                                <label class="custom-control-label" for="canWork-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="canWork-no" name="canWork" value="No" required>
                                <label class="custom-control-label" for="canWork-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($haveLicense) : ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="haveLicense">Do you have a valid <?=$licenseState?> driver's license?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="haveLicense-yes" name="haveLicense" value="Yes" required>
                                <label class="custom-control-label" for="haveLicense-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="haveLicense-no" name="haveLicense" value="No" required>
                                <label class="custom-control-label" for="haveLicense-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($covidVaccine) : ?>
                        <div class="col-md mt-2 mt-md-0">
                            <label for="covidVaccine">Are you COVID-19 vaccinated?</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="covidVaccine-yes" name="covidVaccine" value="Yes" required>
                                <label class="custom-control-label" for="covidVaccine-yes" >Yes</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="covidVaccine-no" name="covidVaccine" value="No" required>
                                <label class="custom-control-label" for="covidVaccine-no" >No</label>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($availability) : ?>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <h5 class="text-primary">What times are you available each day of the week?</h5>
                        </div>
                    </div>
                    <?php foreach($days as $day) { ?>
                    <div class="form-group row align-items-center justify-content-center">
                        <div class="col-md-2 text-center">
                            <strong><?=ucfirst($day)?></strong>
                        </div>
                        <div class="col-md-2 my-2 my-md-0 text-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="<?=$day?>" onchange="toggleOpenClose('.<?=$day?>-time',this);">
                                <label class="custom-control-label" for="<?=$day?>" >Unavailable</label >
                                </div>
                        </div>
                        <div class="col-md-auto col">
                            <input type="time" name="<?=$day?>-from"class="form-control <?=$day?>-time" value="00:00" disabled>
                        </div>
                        <div class="col-md-auto col-2 text-center">––</div>
                        <div class="col-md-auto col">
                            <input type="time" name="<?=$day?>-to" class="form-control <?=$day?>-time" value="23:59" disabled>
                        </div>
                    </div>
                    <?php } ?>
                    <hr>
                    <?php endif; ?>

                    <div class="form-group row">
                        <?php if($uploadResume) { ?>
                        <div class="col-md-4">
                            <label for="resume">Upload Resume</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="resume" name="resume">
                                    <label class="custom-file-label" for="resume">Select</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="clearfile">Clear</button>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-8 mt-2 mt-md-0">
                            <label for="comments">
                                Or paste your resume here:
                            </label>
                            <textarea id="comments" name="comments" cols="30" rows="2" class="form-control"></textarea>
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
                    <h4 class="text-primary my-2">Review Application</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4" id="review-info">
                            <div class="col-md pt-3 border">
                                <h4 class="border-bottom pb-3">Basic Information</h4>
                                <p>
                                    <strong>Applying for : </strong><span id="review-position"></span>
                                    <br/>
                                    <strong>First Name : </strong><span id="review-first-name"></span>
                                    <br/>
                                    <strong>Last Name : </strong><span id="review-last-name"></span>
                                    <br/>
                                    <?php if($above21) : ?>
                                    <strong>Above 21 : </strong><span id="review-above21"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($birthDate) : ?>
                                    <strong>Date of Birth : </strong><span id="review-dob"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <strong>Phone # : </strong><span id="review-phone"></span>
                                    <br/>
                                    <strong>Alternate Phone # : </strong><span id="review-phone-alt"></span>
                                    <br/>
                                    <strong>Email : </strong><span id="review-email"></span>
                                </p>
                            </div>
                            <div class="col-md pt-3 border">
                                <h4 class="border-bottom pb-3">Additional Information</h4>
                                <p>
                                    <strong>Years of Experience : </strong><span id="review-experience"></span>
                                    <br/>
                                    <strong>Date you can start work : </strong><span id="review-date"></span>
                                    <br/>
                                    <strong>Hours per Week : </strong><span id="review-hours"></span>
                                    <br/>
                                    <strong>Have your own vehicle? : </strong><span id="review-vehicle"></span>
                                    <br/>
                                    <?php if($credentialsAndCertificates) : ?>
                                    <strong>Credentials & Certifications : </strong><span id="review-credscerts"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($uploadResume) : ?>
                                    <strong>Resume : </strong><span id="review-resume"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($speakEnglish) : ?>
                                    <strong>Can speak English? : </strong><span id="review-speakEnglish"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($speakSpanish) : ?>
                                    <strong>Can speak Spanish? : </strong><span id="review-speakSpanish"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($canWork) : ?>
                                    <strong>Authorized to reside & work in the USA : </strong><span id="review-canWork"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($haveLicense) : ?>
                                    <strong>Have <?=$licenseState?> License? : </strong><span id="review-haveLicense"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <?php if($covidVaccine) : ?>
                                    <strong>COVID-19 Vaccinated? : </strong><span id="review-covidVaccine"></span>
                                    <br/>
                                    <?php endif; ?>
                                    <strong>Additional Comments : </strong><span id="review-comments"></span>
                                </p>
                            </div>
                            <?php if($availability) : ?>
                            <div class="col-md pt-3 border">
                                <h4 class="border-bottom pb-3">Availability</h4>
                                <p>
                                <?php foreach($days as $day) { ?>
                                    <strong><?=ucfirst($day)?> : </strong><span id="review-<?=$day?>">Not Available</span>
                                    <br/>
                                <?php } ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    <div class="form-group row align-items-center mb-0">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="switchTo('#step-2');"><i class="fa fa-arrow-left mr-2"></i>Previous</button>
                            <button id="submit" type="button" class="btn btn-success">Submit<i class="fa fa-check ml-2"></i></button>
                            <button class="spinner-border text-success d-none" type="button" role="status"></button>
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
