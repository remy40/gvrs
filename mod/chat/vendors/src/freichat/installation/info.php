<?php

session_start();


/* Make me secure */

if (!isset($_SESSION['FREIX']) || $_SESSION['FREIX'] != 'authenticated') {
    header("Location:index.php");
    exit;
}

/* Now i am secure */


function is__writable($path) {
//will work in despite of Windows ACLs bug
//NOTE: use a trailing slash for folders!!!
//see http://bugs.php.net/bug.php?id=27609
//see http://bugs.php.net/bug.php?id=30931

    if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return is__writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}


class Info {

    public function __construct() {
        if (isset($_POST['cms']) == true) {
            
            if($_POST['cms'] == "CBE" && $_POST['CBE_ver'] == '2') {
                $_SESSION['cms'] = 'CBE_2';
            }else{
                $_SESSION['cms'] = $_POST['cms'];
            }
            
        }
    }

    public function set_file() {
        $redir = false;

        
        if(is_file('integ/'.$_SESSION['cms'].'.php')){
          
          $cname=$_SESSION['cms'];
            require 'integ/'.$_SESSION['cms'].'.php';
            $cls=new $cname();
            $redir=$cls->redir;
            $set_file=$cls->set_file;
            
        }
        else{
            $_SESSION['error']='Invalid Integration Driver Selected';
            header("Location: error.php");
            exit(0);
        }
        
        $this->set_path($set_file);

        if ($redir == true) {
            header('Location: params.php');
            exit(0);
        }

        return $set_file;
    }

    public function set_path($set_file) {
        if (isset($_POST['paths']) == true) {
            $_SESSION['config_path'] = $_POST['paths'];
            $_SESSION['config_path'] = str_replace('\\', '/', $_SESSION['config_path']);
            $_SESSION['cms_path'] = str_replace($set_file, "", $_SESSION['config_path']);
        } else {
            $ROOT_path = str_replace('\\', '/', dirname(__FILE__));
            $_SESSION['cms_path'] = str_replace("freichat/installation", "", $ROOT_path);
            $_SESSION['config_path'] = str_replace("freichat/installation", "", $ROOT_path) . $set_file;
        }
    }



    public function get_flags() {
        $flags = Array();

        $flags['flag'] = true;
	$flags['color1'] = $flags['color0']=$flags['color3']=$flags['color4'] = $flags['color5']  =  "green";
	$flags['text1'] = $flags["text0"] = $flags["text3"]= $flags["text4"]= $flags['text5'] = "is writable";

        if (!is_writable("../hardcode.php")) {
            $flags['flag'] = false;
            $flags['color1'] = "red";
            $flags['text1'] = "is not writable(Please change file permissions to 0777)";
        }
        
        if (!is_writable("../cache/perm/request.001")) {
            $flags['flag'] = false;
            $flags['color3'] = "red";
            $flags['text3'] = "is not writable(Please change file permissions to 0777)";
        }  
        
        if(!is__writable('../client/plugins/upload/upload')){
            $flags['flag'] = false;
            $flags['color5'] = "red";
            $flags['text5'] = "is not writable(Please change file permissions to 0777)";
        }
        
        if (!is__writable("../cache/temp/")) {
            $flags['flag'] = false;
            $flags['color4'] = "red";
            $flags['text4'] = "is not writable(change folder permissions to 0777)";
        }         


        if (isset($_SESSION['config_path']) == true) {
            if (is_readable($_SESSION['config_path'])) {
                $flags['color2'] = "green";
                $flags['text2'] = "is readable";
            } else {
                $flags['flag'] = false;
                $flags['color2'] = "red";
                $flags['text2'] = "is not readable";
            }
        }
        return $flags;
    }


}




$info = new Info();



 $set_file = $info->set_file();
 
 
 
$flags=$info->get_flags();


require 'header.php';
?>

<div style="text-align: center">
    <br/> <span  style="font-family: 'Sonsie One', cursive;font-size: 18pt;text-align: center"><b>
            <?php
             if ($flags['flag'] == false) {
                 echo "Please Correct the following";
             }
             else{
                 echo "Everything Seems Alright!";                 
             }
             ?>
        </b></span><br/><br/><br/>
                freichat/hardcode.php <font color='<?php echo $flags['color1']; ?>'><?php echo $flags['text1']; ?> </font><br/>
                freichat/cache/perm/request.001 <font color='<?php echo $flags['color3']; ?>'><?php echo $flags['text3']; ?> </font><br/>     
                freichat/cache/temp <font color='<?php echo $flags['color4']; ?>'><?php echo $flags['text4']; ?> </font><br/>                 
                <p><?php echo $set_file; ?> <font color=<?php echo $flags['color2']; ?>><?php echo $flags['text2']; ?></font><br/>
                freichat/client/plugins/upload/upload <font color='<?php echo $flags['color5']; ?>'><?php echo $flags['text5']; ?> </font><br/>
    



           
<?php
        if ($flags['flag'] == false) {
            
            echo  " <br/>
                    <br/>
                    <br/><form name='path' action='info.php' id='sameform' method='POST'>
                    <span  style=\"font-family: 'Sonsie One', cursive;font-size: 18pt;text-align: center\">is the path to your <font color=green>$set_file</font> file correct?</span><br/>
                   <br/><input style=\"font-family: 'Exo', sans-serif;font-weight:600 ;font-style:italic;font-size:16px;width:500px;\" name='paths' type='text' value= ".$_SESSION['config_path']." /><br/><br/>";

            
            echo '<br/><a href="JavaScript:void(0)" class="refreshbutton" onclick="modify()">Refresh</a>';
        }

        echo "</form>

            <form name='cms' id='nextform' action='params.php' method='POST'>
        <br/>

         ";

        if ($flags['flag'] == true) {
            echo '<br/><br/><a href="JavaScript:void(0)" class="nextbutton" onclick="proceed()">Proceed</a>';
        }

        echo " </form>";
?>
</div>                  
<script type="text/javascript">
    
    function proceed(){
        $('#nextform').submit();
    }
    
    function modify(){
        $('#sameform').submit();
    }
    
</script>
                   
<?php

require 'footer.php';

?>
