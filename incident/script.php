<?php 
   session_start();
   if(!$_SESSION['script']) exit('Silence is golden :)');
   unset($_SESSION['script']);
   for($i=0;$i<1000000;$i++){
       echo "\n";
   }
?>

$(document).ready(()=> {
    setTimeout(()=>$('#progress-bar').css('width',100/$('.step').length+'%'),1000);
    new google.maps.places.Autocomplete(document.getElementById('address')).setComponentRestrictions({country: ["us","ca"]});
    setTimeout(()=>$.get('./script.php'),1000);
    $('.fa-info-circle').tooltip();
    $('#script').remove();
})

$(document).on('input','.phone', function (e) {
    if(e.target.value.replace(/\D/g, '').length>10) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = '+'+x[1]+'('+x[2]+')'+x[3]+'-'+x[4];
    } else {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    }
  });

$('[name=injuries]').on('change',(e)=>{
    if($('#injuries-description').attr('disabled')) {
        $('#injuries-description').removeAttr('disabled');
    } else {
        $('#injuries-description').attr('disabled','disabled');
    }
})

$('[name=police]').on('change',(e)=>{
    if($('#police-report').attr('disabled')) {
        $('#police-report').removeAttr('disabled');
    } else {
        $('#police-report').attr('disabled','disabled');
    }
})

var valid=true;

function validator(a) {
    $(a).find('input').each((i,x)=>{
        if(!$(x)[0].checkValidity()) {
            $(x)[0].reportValidity();
            valid=false;
            return false;
        }
    });
}

switchTo = (a) => {
    valid=true;
    if(a=='#step-2') validator('#step-1');
    if(a=='#step-3') validator('#step-2');
    if(!valid) return false;
    if(a=='#step-4') review();
    $('.step').slideUp();
    $(a).slideDown();
    $('#progress-bar').css('width',(a.split('-')[1]*100)/$('.step').length+'%');
    $("html, body").animate({ scrollTop: 0 }, "slow");
}

$(document).on('click','#submit',(e)=>{
   e.preventDefault();
    $.post('./post.php',{
        "review-info": $('#review-info').html(),
        "first-name": $('#first-name').val(),
        "last-name": $('#last-name').val(),
        "email": $('#email').val(),
        "date-time": $('#review-date-time').text()
    });
    //show thankyou popup
    $('#thank-you').modal('show');
});

$('#thank-you').on('hidden.bs.modal', function () {
    location.reload();
});

let affected=1;
let witness=1;

function addAffected() {
    affected++;
    let content = `
    <div class="row mt-2" id="affected-${affected}">
        <div class="col-md-4">
            <label>Full Name</label>
            <input type="text" name="affected-name-${affected}" class="form-control"/>
        </div>
        <div class="col-md-4">
            <label>Contact #</label>
            <input type="text" name="affected-phone-${affected}" class="phone form-control"/>
        </div>
        <div class="col-md-4">
            <label>Email</label>
            <input type="email" name="affected-email-${affected}" class="form-control"/>
        </div>
    </div>
    `;
    $('#affected').append(content);
    $('#remove-affected').removeClass('d-none');
}

function removeAffected() {
    $('#affected-'+affected).remove();
    affected--;
    if(affected==1) $('#remove-affected').addClass('d-none');
}


function addWitness() {
    witness++;
    let content = `
    <div class="row mt-2" id="witness-${witness}">
        <div class="col-md-4">
            <label>Full Name</label>
            <input type="text" name="witness-name-${witness}" class="form-control"/>
        </div>
        <div class="col-md-4">
            <label>Contact #</label>
            <input type="text" name="witness-phone-${witness}" class="phone form-control"/>
        </div>
        <div class="col-md-4">
            <label>Email</label>
            <input type="email" name="witness-email-${witness}" class="form-control"/>
        </div>
    </div>
    `;
    $('#witnesses').append(content);
    $('#remove-witness').removeClass('d-none');
}

function removeWitness() {
    $('#witness-'+witness).remove();
    witness--;
    if(witness==1) $('#remove-witness').addClass('d-none');
}

function review() {
    const infos = ['first-name','last-name','company','phone','phone-alt','email','witness_indi','date-time','address','type','incident-description','injuries','injuries-description','police','police-report','remedy'];
    infos.map(x=>{
       $('#review-'+x).text($('[name='+x+']').val()); 
    });
    $('#review-witness_indi').text($('[name=witness_indi]:checked').val());
    $('#review-injuries').text($('[name=injuries]:checked').val());
    $('#review-police').text($('[name=police]:checked').val());
    $('#review-date-time').text(new Date($('#review-date-time').text()).toLocaleString("en-US"));
    let reviewAffected= [];
    let reviewWitness= [];
    for(var i=1;i<=affected;i++) {
        reviewAffected.push($('[name=affected-name-'+i+']').val()+(($('[name=affected-phone-'+i+']').val())?', ':'')+$('[name=affected-phone-'+i+']').val()+(($('[name=affected-email-'+i+']').val())?', ':'')+$('[name=affected-email-'+i+']').val());
    }
    $('#review-affected').html(reviewAffected.join('<br/>'));
    for(var i=1;i<=witness;i++) {
        reviewWitness.push($('[name=witness-name-'+i+']').val()+(($('[name=witness-phone-'+i+']').val())?', ':'')+$('[name=witness-phone-'+i+']').val()+(($('[name=witness-email-'+i+']').val())?', ':'')+$('[name=witness-email-'+i+']').val());
    }
    $('#review-witness').html(reviewWitness.join('<br/>'));
}

$(document).on("keydown", ":input:not(textarea)", function(event) {
    return event.key != "Enter";
});