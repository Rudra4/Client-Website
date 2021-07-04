<pre>
<?php 
require_once 'db.php';
$idtype = false;
$pname = false;
$sql = false;
$fname = false;
$lname = false;
$email = false;
$pwd = false;
$doj = false;
$subArr = false;
$sub = false;
$arr = false;
$sid = false;
$pid = false;
$tid = false;
session_start();
if(isset($_POST['idType'])){
    $idtype = $_POST['idType'];
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $doj = $_POST['doj'];
    $subArr = $_POST['sub'];
    for($i = 0; $i < sizeof($subArr); $i++){
        $sub .= $subArr[$i].",";
    }
    $sub = substr($sub, 0, -1);
    if($idtype === "student"){
        $sql = "SELECT COUNT(*) FROM Website.Student";
        $res = $pdo->query($sql);
        $count = $res->fetchColumn() + 1;
        $sid = "ST".$count;
        
        $sql = "INSERT INTO Website.Student (sid, fname, lname, email, pwd, doj, subject) values (:sid, :fname, :lname, :email, :pwd, :doj, :subject)";
        $arr = array(':sid'=>$sid, ':fname'=>$fname, ':lname'=>$lname, ':email'=>$email, ':pwd'=>$pwd, ':doj'=>$doj, ':subject'=>$sub);
        if(isset($_POST['pName'])){
            $pname =  $_POST['pName'];
            $sql = "INSERT INTO Website.Student (sid, fname, lname, pname, email, pwd, doj, subject) values (:sid, :fname, :lname, :pname, :email, :pwd, :doj, :subject)";
            //array_push($arr, ':pname'=>$pname);
            $arr[':pname'] = $pname;
        }
    }
    if($idtype === "parent"){
        $sql = "SELECT COUNT(*) FROM Website.Parent";
        $res = $pdo->query($sql);
        $count = $res->fetchColumn() + 1;
        $pid = "PA".$count;
        
        $sql = "INSERT INTO Website.Parent (pid, fname, lname, email, pwd, doj, subject) values (:pid, :fname, :lname, :email, :pwd, :doj, :subject)";
        $arr = array(':pid'=>$pid, ':fname'=>$fname, ':lname'=>$lname, ':email'=>$email, ':pwd'=>$pwd, ':doj'=>$doj, ':subject'=>$sub);
    }
    if($idtype === "tutor"){
        $sql = "SELECT COUNT(*) FROM Website.Tutor";
        $res = $pdo->query($sql);
        $count = $res->fetchColumn() + 1;
        $tid = "TU".$count;
        
        $sql = "INSERT INTO Website.Tutor (tid, fname, lname, email, pwd, doj, subject) values (:tid, :fname, :lname, :email, :pwd, :doj, :subject)";
        $arr = array(':tid'=>$tid, ':fname'=>$fname, ':lname'=>$lname, ':email'=>$email, ':pwd'=>$pwd, ':doj'=>$doj, ':subject'=>$sub);
    }
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arr);
        session_destroy();
        header ("Location: ../index.html");
        return;
    } catch (Exception $e) {
        if ($e->errorInfo[1] == 1062) {
            echo '<h1><p style = "color: red">Email already registered. </p><p> Click <a href = "../index.html">here</a> to login.</h1>';
        }else{
            echo '<h1><p style = "color: red">Some error occured during registration. </p><p> Click <a href = "../index.html">here</a> to re-register.</h1>';
        }
    }
    
}

?>
</pre>