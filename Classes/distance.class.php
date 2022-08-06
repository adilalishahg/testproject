<?php

/**
 * distance.class.php
 *
 * @version $Id$
 * @copyright 2009 3S System Software Support, Gundetswil, Switzerland
 *
 * Calculate the air distance between 2 Cities using Google Maps API
 * Designed to find if a city is within a rayon of another city
 *
 * Usage:
 *
 * $o = new distance(Center City[, Unit]);
 * $d = $o->calcDistance(another city);
 * $l = $o->isInRayon(another city[, rayon]);
 *
 * Example:
 * $oDist = new distance('Zurich, Switzerland' [,'km']);
 * $d1 = $oDist->calcDistance('Geneva Switzerland');
 * $d2 = $oDist->calcDistance('Berne Switzerland');
 *
 * $inRayon = $oDist->isInRayon('Basel, Switzerland', 150);
 * $inRayon = $oDist->isInRayon('Geneva, Switzerland');
 *
 * The methods default distances are in kilometers.
 * You may change the unit by speciying 'mi' for Miles or 'nmi' for nautical miles in the constructor or
   using the setUnit method.
 */


class distance {
	public $aCenter = NULL;
	public $nEradius = 6378.137;
	public $unit = 'km';
	public $rayon = 0;

	// GOOGLE API Key: Please use your own key at http://code.google.com/
//	private $key="ABQIAAAAISyUpSDuJUSEnjS1fMYBDxS86yYvD7-z09Q5cLMRMn9CkyJ4jRT-St7br4dZW1WE67re8huMhXH0kQ";
	private $key="ABQIAAAAISyUpSDuJUSEnjS1fMYBDxTW9fsKZAisiVp5qCkmC-pCibnrtRQ_i2TvIwf8kfdXOdltc_CfIwhblw";

	function __construct($cCenter=NULL, $unit=NULL){
		if ($unit) {
			$this->setUnit($unit);
		}
		if ($cCenter) {
			$this->aCenter = $this->getCoords($cCenter);
		}
	}

	function calcDistance($cLocality, $cCenter=NULL ){
		if ($cCenter) {
			$this->aCenter = $this->getCoords($cCenter);
		}
		$aLocality = $this->getCoords($cLocality);
		if ($aLocality == NULL || $this->aCenter == NULL) {
			return -1;
		}
		$nPi180 = 180 / M_PI;
		$nDistance = acos(  sin($aLocality['lat']/$nPi180) * sin($this->aCenter['lat']/$nPi180) + cos($aLocality['lat']/$nPi180) * cos($this->aCenter['lat']/$nPi180) * cos($this->aCenter['long']/$nPi180 - $aLocality['long']/$nPi180)) * $this->nEradius;
		return $nDistance;
	}

	/* Returns TRUE if the specified city is within the rayon air distance of the previously set center city */
	function isInRayon($cCity, $nRayon=NULL){
		if ($nRayon) {
			$this->nRayon = $nRayon;
		}
		if ($this->aCenter) {
			$d = $this->calcDistance($cCity);
			return $d <= $this->nRayon;
		}
		return FALSE;
	}

	function getCoords($location){
		$loc = urlencode($location);
		$url = "http://maps.google.com/maps/geo?q=$loc&output=csv&key=$this->key";
		$csv = file_get_contents($url);
		$aCsv = explode(',', $csv);
		if ($aCsv[0] == 200) {
			return array('lat'=>(float)$aCsv[2], 'long'=>(float)$aCsv[3], 'prec'=>(int)$aCsv[1]);
		}
		return NULL;
	}

	function setUnit($unit){
		$this->unit = $unit;
		switch($unit){
			case 'km':	// kilometers
				$this->nEradius = 6378.137;
				break;
			case 'mi':  // Miles
				$this->nEradius = 3963.191;
				break;
			case 'nmi':  // Nautical Miles
				$this->nEradius = 3443.918;
				break;
		} // switch
	}
}

