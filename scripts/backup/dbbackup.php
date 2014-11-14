<?php

// get dbname, username and password

// construct filename i.e 2014_04_16_14_33.sql
$date = date('Y_m_d_H_i');
$filename = $date . '.sql';

// mysqldump
exec('mysqldump --user=homestead --password=secret  homestead > ./' . $filename);

// upload file to drive using cp2google