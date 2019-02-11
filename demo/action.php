<?php
session_start();
if ($_SESSION['code'] == strtolower($_POST['code'])){
    echo "true";
} else {
    echo "false";
}