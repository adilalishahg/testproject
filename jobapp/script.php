<?php 
   session_start();
   if(!$_SESSION['script']) exit('Silence is golden :)');
   unset($_SESSION['script']);
   for($i=0;$i<1000000;$i++){
       echo "\n";
   }
   require_once('./config.php');
?>

$(document).ready(()=> {
    setTimeout(()=>$('#progress-bar').css('width',100/$('.step').length+'%'),1000);
    //new google.maps.places.Autocomplete(document.getElementById('address')).setComponentRestrictions({country: ["us","ca"]});
    setTimeout(()=>$.get('./script.php'),1000);
    $('.fa-info-circle').tooltip();
    $('#script').remove();
})

$('.position').on('click',(e)=> {
    const position = $(e.target).text();
    $('.position .bg-primary').removeClass('text-light bg-primary');
    $(e.target).toggleClass('bg-primary text-light');
    $('[name=position]').val(position).trigger('change');
    $('#position-title,#position-preview').text(position);
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

$('[name=vehicle]').on('change',(e)=>{
   $('#vehicle-details').toggleClass('d-none'); 
});

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
    if(a=='#step-3') review();
    $('.step').slideUp();
    $(a).slideDown();
    $('#progress-bar').css('width',(a.split('-')[1]*100)/$('.step').length+'%');
    $("html, body").animate({ scrollTop: 0 }, "slow");
}

$(document).on('click','#submit',(e)=>{
   e.preventDefault();
   $('#submit').parent('div').children('button').toggleClass('d-none');
    var formData = new FormData();
    formData.append('review-info',$('#review-info').html());
    formData.append('first-name',$('#first-name').val());
    formData.append('last-name',$('#last-name').val());
    formData.append('email',$('#email').val());
    if($('#resume')[0].files[0]) formData.append('resume',$('#resume')[0].files[0]);

    $.ajax({
            url: "./post.php", 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=='success') {
                    //show thankyou popup
                    $('#thank-you').modal('show');
                } else {
                    alert(data);
                    $('#submit').parent('div').children('button').toggleClass('d-none');
                }
            }
        });
    
});

$('#thank-you').on('hidden.bs.modal', function () {
    location.reload();
});

function review() {
    const infos = ['first-name','last-name',<?php if($birthDate): ?>'dob',<?php endif; ?>'phone','phone-alt','email','position','date','experience','hours',<?php if($uploadResume) : ?>'resume',<?php endif; ?><?=($above21)?"'above21',":""?><?=($speakEnglish)?"'speakEnglish',":""?><?=($speakSpanish)?"'speakSpanish',":""?><?=($canWork)?"'canWork',":""?><?=($haveLicense)?"'haveLicense',":""?><?=($covidVaccine)?"'covidVaccine',":""?>'comments'];
    infos.map(x=>{
       if($('#review-'+x).length) $('#review-'+x).text($('[name='+x+']').val()); 
    });
    <?php if($birthDate) : ?>$('#review-dob').text(new Date($('#review-dob').text()).toLocaleDateString("en-US"));<?php endif; ?>
    $('#review-date').text(new Date($('#review-date').text()).toLocaleDateString("en-US"));
    <?php if($uploadResume) : ?>if($('[name=resume]').val()) $('#review-resume').text($('#resume').next('.custom-file-label').html());<?php endif; ?>
    $('#review-vehicle').text($('[name=vehicle]:checked').val());
    <?php if($vehicleDetails) : ?>
    if($('[name=vehicle]:checked').val()=='Yes') {
        const vehicleinfo = $('#vehicle-year').val()+' '+$('#vehicle-make').val()+' '+$('#vehicle-model').val()+' (Wheelchair Accessible: '+$('[name=wheelchair]:checked').val()+')';
        $('#review-vehicle').text(vehicleinfo);
    }
    <?php endif; ?>
    <?php if($credentialsAndCertificates) : ?>
    let credscerts = [];
    $('.credcert:checked').each((i,v)=>{
        credscerts.push($(v).val());
    });
    $('#review-credscerts').text(credscerts.join(', '));
    <?php endif; ?>
    <?php if($availability) : ?>
    const days = <?=json_encode($days)?>;
    days.map(x=>{
       if($('#'+x).prop('checked')) {
           $('#review-'+x).text(tConv24($('[name='+x+'-from]').val())+' to '+tConv24($('[name='+x+'-to]').val()));
       } else {
            $('#review-'+x).text('Not Available');
       }
    });
    <?php endif; ?>
}
$(document).on("keydown", ":input:not(textarea)", function(event) {
    return event.key != "Enter";
});


$(document).on('click','#experienceplus',(e)=>{
    var experience = $('#experience').val();
    $('#experience').val(parseInt(experience)+1);
});

$(document).on('click','#experienceminus',(e)=>{
    var experience = $('#experience').val();
    if(experience==1) return;
    $('#experience').val(parseInt(experience)-1);    
});
$(document).on('click','#hoursplus',(e)=>{
    var hours = $('#hours').val();
    $('#hours').val(parseInt(hours)+1);
});

$(document).on('click','#hoursminus',(e)=>{
    var hours = $('#hours').val();
    if(hours==1) return;
    $('#hours').val(parseInt(hours)-1);    
});

$('#resume').on('change',function(){
    var fileName = $(this).val().split('\\')[$(this).val().split('\\').length-1];
    $(this).next('.custom-file-label').html(fileName);
})

$('#clearfile').on('click',(e)=>{
    $('#resume').val('');
    $('#resume').next('.custom-file-label').html('Select');
})

function toggleOpenClose(a,b) {
    const label = $(b).parents('.custom-switch').find('label');
    if($(a).attr('disabled')=='disabled') {
        $(a).removeAttr('disabled');
        label.html('Available');
    } else {
        $(a).attr('disabled','disabled');
        label.html('Unavailable');
    }
}

function tConv24(time24) {
  var ts = time24;
  var H = +ts.substr(0, 2);
  var h = (H % 12) || 12;
  h = (h < 10)?("0"+h):h;  // leading 0 at the left for 1 digit hours
  var ampm = H < 12 ? " AM" : " PM";
  ts = h + ts.substr(2, 3) + ampm;
  return ts;
};