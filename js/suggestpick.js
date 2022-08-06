function getXmlHttpRequestObject3() {
 if (window.XMLHttpRequest) {
  return new XMLHttpRequest();
 } else if(window.ActiveXObject) {
  return new ActiveXObject("Microsoft.XMLHTTP");
 } else {
  alert("Your Browser Sucks!");
 }
}
 
//Our XmlHttpRequest object to get the auto suggest
var searchReq3 = getXmlHttpRequestObject3();
 
//Called from keyup on the search textbox.
//Starts the AJAX request.
function searchSuggest3() {
 if (searchReq3.readyState == 4 || searchReq3.readyState == 0) {
  var str = escape(document.getElementById('picklocation').value);
  if(str.length > 2){ //alert('In');
  searchReq3.open("GET", 'searchSuggestpick.php?search=' + str, true);
  searchReq3.onreadystatechange = handlesearchSuggest3;
  searchReq3.send(null); }
 }
}
 
//Called when the AJAX response is returned.
function handlesearchSuggest3() {
 if (searchReq3.readyState == 4) {
         var ss = document.getElementById('layer3');
  var str1 = document.getElementById('picklocation');
  var curLeft=0;
  if (str1.offsetParent){
      while (str1.offsetParent){
   curLeft += str1.offsetLeft;
   str1 = str1.offsetParent;
      }
  }
  var str2 = document.getElementById('picklocation');
  var curTop=20;
  if (str2.offsetParent){
      while (str2.offsetParent){
   curTop += str2.offsetTop;
   str2 = str2.offsetParent;
      }
  }
  var str =searchReq3.responseText.split("\n");
  if(str.length==1)
      document.getElementById('layer3').style.visibility = "hidden";
  else
      ss.setAttribute('style','position:absolute;top:'+curTop+';left:'+curLeft+';width:250;z-index:1;padding:5px;border: 0px solid #000000; overflow:auto; height:105; background-color:#F5F5FF;');
  ss.innerHTML = '';
  for(i=0; i < str.length - 1; i++) {
   //Build our element string.  This is cleaner using the DOM, but
   //IE doesn't support dynamically added attributes.
   var suggest = '<div onmouseover="javascript:suggestOver(this);" ';
            suggest += 'onmouseout="javascript:suggestOut(this);" ';
            suggest += 'onclick="javascript:setSearch3(this.innerHTML);" ';
            suggest += 'class="small">' + str[i] + '</div>';
            ss.innerHTML += suggest;
 
  }
 }
}
 
//Mouse over function
function suggestOver(div_value) {
 div_value.className = 'suggest_link_over';
}
//Mouse out function
function suggestOut(div_value) {
 div_value.className = 'suggest_link';
}
//Click function
function setSearch3(value) {
 document.getElementById('picklocation').value = value;
 document.getElementById('layer3').innerHTML = '';
 document.getElementById('layer3').style.visibility = "hidden";
}
$('body').click(function() {
       $("#layer3").hide();
});