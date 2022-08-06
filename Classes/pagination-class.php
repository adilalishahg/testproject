 <?php 
class pagination {
	var $pageNum;//Current page number
	var $maxRows;//Records per page
	var $totalRows;// total records
    var $startRow;// Starting row on a particular pages
    var $totalPages;// Total number of pages
    var $showDot;
	var $counts;
	var $startPage;
	var $showRecordsMsg;
	var $showPrevieusNextLink;
	var $showFirstLastLink;
	var $outPutString;
	var $xtraquery;
 	function pagination($pageNum = "", $maxRows = "", $totalRows = "", $xtraquery = "")
		{
			$this->pageNum     			= ( !empty( $pageNum ) )  ?  (int)$pageNum      :  0;
			$this->maxRows     			= ( !empty( $maxRows ) )  ?  (int)$maxRows      :  30;
			$this->totalRows   			= ( !empty( $totalRows ) )  ?  (int)$totalRows  :  0;
			$this->showDot     			= 0;
			$this->counts      			= 0;
			$this->startPage   			= 0;
			$this->showRecordsMsg  	 	= 1;
			$this->showPrevieusNextLink = 1;
			$this->showFirstLastLink	= 1;
			$this->outPutString='';
			$this->startRow = $this->pageNum * $this->maxRows;
		    $this->totalPages = ceil($this->totalRows/$this->maxRows);
		    $this->xtraquery = $xtraquery;
		}
   function calculations()
    {
        if($this->pageNum>5){
		if($this->pageNum+5<$this->totalPages){	  
		$this->startPage=$this->pageNum-5;
		}elseif($this->totalPages >11){ 
		$this->startPage=($this->totalPages-10);  
		}else{$this->startPage=0;}
		}else $this->startPage=0;
		$this->counts= $this->startPage;
		if($this->counts+11<$this->totalPages){
		if($this->pageNum==0)
		$this->counts= $this->counts+10;
		else{ 
		$this->counts= $this->counts+11;
		}
		$this->showDot=1;
		}
		else {
		$this->counts=$this->totalPages;
		$this->showDot =0;
		}
   }//end calculations		
    function showDots()
	  { 
	  if($this->showDot==1){ $this->outPutString.='...'; }
	  }
// the first argument is page Number 2nd is rows per page 3rd is total record 
function display_pagination(){
	if($this->totalRows>$this->maxRows){
		$url = "";
		$url .= $PHP_SELF."?".$_SERVER['QUERY_STRING']; 
		$pg=$this->pageNum;
		$url=str_replace('&pageNum='.$pg,'',$url);
		$this->outPutString='
		<div class="pagination" id="pagination" align="center">';
		if($this->showRecordsMsg==1){
		$this->outPutString.='Showing  '.($this->startRow + 1).' to   '.min($this->startRow + $this->maxRows, $this->totalRows).' of  '. $this->totalRows.' &nbsp; Record(s)&nbsp;<br />';
		}
		$this->outPutString.='Pages :: &nbsp;';
		if($this->showFirstLastLink==1){
		if($this->pageNum>5&&$this->totalPages>10)	
		{	
	$this->outPutString.=' <a class="SignUp" href="'.$url.'&pageNum=0'.$this->xtraquery.'">[First]</a>&nbsp;'; 
		} 
		}// endi if($this->showFirstLastLink==1)		
		if($this->showPrevieusNextLink==1){
		if ($this->pageNum  > 0) {
	$this->outPutString.='<a class="SignUp" href="'.$url.'&pageNum='.max(0, $this->pageNum - 1).$this->xtraquery.'">[Previous]</a>';
		}//end if ($this->pageNum  > 0)
		}//end if($this->showPrevieusNextLink==1)
		$this->outPutString.='&nbsp;&nbsp;';
		$this->calculations();
		for ($i=$this->startPage; $i< $this->counts; $i=$i+1){
		if ($i!=$this->pageNum){
		$this->outPutString.=
		'<a class="SignUp" href="'.$url.'&pageNum='.$i.$this->xtraquery.'">'.($i+1).'</a>&nbsp;';
		}else{
		$this->outPutString.='['.($i + 1).']&nbsp;';
		}
		} 
		$this->showDots();
		?>
		<?php 
		if($this->showPrevieusNextLink==1){
		if ($this->pageNum < $this->totalPages - 1) 	{
		$this->outPutString.='&nbsp;<a class="SignUp" href="'.$url.'&pageNum='.min($this->totalPages, $this->pageNum + 1).$this->xtraquery.'">[Next]</a>&nbsp;';
		} 
		}//end if($this->showPrevieusNextLink==1)
		if($this->showFirstLastLink==1){	
		if($this->pageNum+6<$this->totalPages)	{	
		$this->outPutString.='<a class="SignUp" href="'.$url.'&pageNum='.($this->totalPages-1).$this->xtraquery.'">[Last]</a>&nbsp';
		}
		}//end  if($this->showFirstLastLink==1)
		$this->outPutString.='	
		</div>';
		return $this->outPutString;	
	}//end   if($this->totalRows>$this->maxRows)
}// end pagination
}//end class
?>