<?php  
date_default_timezone_set('Asia/Jakarta');
session_start();

$db = mysqli_connect('localhost','root','','pos'); 

if (!$db) 
{
    die('Connect Error: ' . mysqli_connect_errno());
}


function base_url($url = null)

  {
    $base_url = "http://localhost/pos";
    if ($url != null)
    {
    	return $base_url."/".$url;
    }
    else
    {
    	return $base_url;
    }

  } 

?>