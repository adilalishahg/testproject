<?php
//Google API Key
$GoogleApiKey='AIzaSyAEOYRvV48LM5Tl7ndfjXHiW1vZoaaBvuo';

//Enable / Disable features
$downloadApplication=false;
$pdflink='/DRIVERAPPLICATIONvwa.pdf';
$uploadResume=true;
$credentialsAndCertificates=false;
$vehicleDetails=true;
$birthDate=true;
$above21=false;
$speakEnglish=true;
$speakSpanish=true;
$canWork=true;
$haveLicense=true;
$licenseState=''; //meh
$covidVaccine=true;
$availability=true;

//Job Openings
$positions=[
    'Driver'
   
];

//Certifications and Credentials
$credcerts=[
  'CPR Certified',
  'Defensive Driving',
  'Other'  
];

//vehicle years
$years=[
    '2020','2019','2018','2017','2016','2015','2014','2013','2012','2011','2010','2009','2008','2007','2006','2005','2004','2003','2002','2001','2000','1999','1998','1997','1996','1995','1994','1993','1992','1991','1990','1989','1988','1987','1986','1985','1984','1983','1982','1981','1980','1979','1978','1977','1976','1975','1974','1973','1972','1971','1970','1969','1968','1967','1966','1965','1964','1963','1962','1961','1960','1959','1958','1957','1956','1955','1954','1953','1952','1951','1950','1949','1948','1947','1946','1945','1944','1943'
];

//vehicle makes
$makes=[
    'Acura','Alfa Romeo','American Motors','Audi','BMW','Buick','Cadillac','Chevrolet','Chrysler','Dodge','Fiat','Ford','Geo','GMC','Honda','Hummer','Hyundai','Infiniti','Isuzu','Jaguar','Jeep','Kia','KTM','Lexus','Lincoln','Mazda','Mercedes Benz','Mercury','Mini','Mitsubishi','Nissan','Oldsmobile','Peugeot','Plymouth','Pontiac','Porche','Ram','Renault','Saab','Saturn','Scion','Smart','Subaru','Suzuki','Toyota','Triumph','Volkswagen','Volvo'
];

//days to ask availability
$days=[
    'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'
];

//Set email to receive application
// $sendApplicationTo=['jr@wholeroute.com','bwarr009@odu.edu']; //production
$sendApplicationTo=['ncfpellc@gmail.com']; //local

?>