
var inServiceCounty = ["Cumberland", "Harnett", "Lee", "Hoke","Wake","Durham","Robeson","Moore","Mecklenburg"];



var inServiceColor = "#0e86c3";
var outOfServiceColor = "#f8f8f8";
var inServiceColorActive = "#1dacf5";
var outOfServiceColorActive = "#cacaca";

var tooltip = document.querySelector('.tooltip');

var oldItemId;
var oldItemInService;

[].forEach.call(document.querySelectorAll('path'), function(item) {

	var inService = inServiceCounty.indexOf(item.id) > -1;
	var content = '';
	if (inService){
		document.getElementById(item.id).style.fill = inServiceColor;
		content = '<strong>'+item.id + '<br>' + '<small style="color:'+inServiceColorActive+'">We Service ' + item.id + '</small></strong>';
	}else{
	    document.getElementById(item.id).style.fill = outOfServiceColor;
		content = '<strong>'+item.id + '<br>' + '<small style="color:#4f5b61">No Service Yet</small></strong>';
	}

  item.addEventListener('mousemove', function(){
    var sel = this,
        pos = sel.getBoundingClientRect();
		
	if(oldItemId){
		if (oldItemInService){
			document.getElementById(oldItemId).style.fill = inServiceColor;
		}else{
			document.getElementById(oldItemId).style.fill = outOfServiceColor;
		}		
	}
	oldItemId = item.id;
	oldItemInService = inService;
		
	if (inService){
		document.getElementById(item.id).style.fill = inServiceColorActive;
	}else{
		document.getElementById(item.id).style.fill = outOfServiceColorActive;
	}		
	tooltip.innerHTML = content;
	
    tooltip.style.display = 'block';
    tooltip.style.top = pos.top + window.scrollY  - 60 +'px';
    //tooltip.style.top = pos.top - tooltip.offsetHeight + 'px';
    tooltip.style.left = pos.left + 'px';
  });

});
 
  document.addEventListener('click', function (event) {
    if (!event.target.matches('path')){
	if(oldItemId){
		if (oldItemInService){
			document.getElementById(oldItemId).style.fill = inServiceColor;
		}else{
			document.getElementById(oldItemId).style.fill = outOfServiceColor;
		}		
	}	
      tooltip.style.display = 'none';
    }
  }, false);
  
	window.onresize = function(event) {
	  tooltip.style.display = 'none';
	};  

