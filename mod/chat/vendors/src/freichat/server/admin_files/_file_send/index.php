<?php
if (!isset($_SESSION['phplogin'])
        || $_SESSION['phplogin'] !== true) {
    header('Location: ../administrator/index.php'); //Replace that if login.php is somewhere else
    exit;
}

class param extends FC_admin {

    public function __construct() {
        parent::__construct();
    }

//--------------------------------------------------------------------------------------------

    public function create_file() {
        $parameters = array();
        $parameters["plugins"]["file_sender"]["show"] = 'true';
        $parameters["plugins"]["file_sender"]["file_size"] = $_POST['max_file_size'];
        $parameters["plugins"]["file_sender"]["expiry"] = $_POST['max_file_expiry'];
        $parameters["plugins"]["file_sender"]["valid_exts"] = $_POST['valid_exts'];
        return $parameters;
    }

}
$param = new param();
if (isset($_POST['max_file_size']) == true) {
    $configs = $param->create_file();
    $param->update_config($configs);
}

$param->build_vars();
?>





<form name="params" action='admin.php?freiload=_file_send' method="POST">

    <br/><br/>
    <div class="parameters">

        <div id="tabs">
            <ul>
                <li><a href="#client">File sending Plugin parameters</a></li>

            </ul>
            <!-- First TAB -->
            <div id="client">




                <ol>
                    <li>
                        <p>Maximum file size for uploading </p>
                        <input name="max_file_size" value="<?php echo $param->default_value(array("plugins", "file_sender", "file_size"), 3); ?>" type="text"> KiloBytes
                        <br/><br/><hr/>
                    </li>

                    <li>
                        <p>Uploaded files will be deleted after</p>
                        <input name="max_file_expiry" value="<?php echo $param->default_value(array("plugins", "file_sender", "expiry"), 3); ?>" type="text"> minutes
                        <br/><br/><hr/>
                    </li>

                    <li>
                        <p>Valid file extensions for uploading</p>
                        <input size="60px" name="valid_exts" value="<?php echo $param->default_value(array("plugins", "file_sender", "valid_exts"), 3); ?>" type="text">
                        <br/><br/><hr/>
                    </li>

                </ol>


            </div>


        </div>

    </div>


    <br/>

    <input id="paramsubmit2" type="submit" value="SUBMIT">
</form>