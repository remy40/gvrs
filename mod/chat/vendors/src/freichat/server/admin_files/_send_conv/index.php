<?php
if (!isset($_SESSION['phplogin'])
        || $_SESSION['phplogin'] !== true) {
    header('Location: ../administrator/index.php'); //Replace that if login.php is somewhere else
    exit;
}

class param extends FC_admin{

    public function __construct() {

    parent::__construct();
    $this->themeray = $this->langray = array();
    }

//--------------------------------------------------------------------------------------------

    public function create_config() {
        $parameters = array();
        $parameters["plugins"]["send_conv"]["show"] = 'true';
        $parameters["plugins"]["send_conv"]["mailtype"] = $_POST['mailtype'];
        $parameters["plugins"]["send_conv"]["smtp_server"] = $_POST['smtp_server'];
        $parameters["plugins"]["send_conv"]["smtp_port"] = $_POST['smtp_port'];
        $parameters["plugins"]["send_conv"]["smtp_protocol"] = $_POST['smtp_protocol'];
        $parameters["plugins"]["send_conv"]["from_address"] = $_POST['from_address'];
        $parameters["plugins"]["send_conv"]["from_name"] = $_POST['from_name'];
        return $parameters;
    }
}

$param = new param();
if (isset($_POST['mailtype']) == true) {
    $configs = $param->create_config();
    $param->update_config($configs);
}
$param->build_vars();
?>





<form name="params" action='admin.php?freiload=_send_conv' method="POST">

    <br/><br/>
    <div class="parameters">

        <div id="tabs">
            <ul>
                <li><a href="#client">Send Conversation By Email Plugin</a></li>

            </ul>
            <!-- First TAB -->
            <div id="client">




                <ol>
                    <li>
                        <p>Mail() or SMTP</p>
                        <select name='mailtype'>
                            <option value='mail' <?php $param->default_param(array("plugins", "send_conv","mailtype"), 'mail'); ?>>mail()</option>
                            <option value='smtp'  <?php $param->default_param(array("plugins", "send_conv","mailtype"), 'smtp'); ?>>SMTP</option>

                        </select>
                        <br/><br/><hr/>
                    </li>
                </ol>
                <p><br/><br/><b>SMTP Related Settings(Required if you choose SMTP)</b></p>
                <ol>
                    <li>
                        <p>SMTP server</p>
                        <input name="smtp_server" value="<?php echo $param->default_value(array("plugins", "send_conv", "smtp_server"), 3); ?>" type="text">
                        <br/><br/><hr/>
                    </li>

                    <li>
                        <p>SMTP port</p>
                        <input size="60px" name="smtp_port" value="<?php echo $param->default_value(array("plugins", "send_conv", "smtp_port"), 3); ?>" type="text">
                        <br/><br/><hr/>
                    </li>
                    <li>
                        <p>Use encrypted protocol</p>
                        <select name='smtp_protocol'>
                            <option value='none' <?php $param->default_param(array("plugins", "send_conv","smtp_protocol"), 'none'); ?>>none</option>
                            <option value='ssl'  <?php $param->default_param(array("plugins", "send_conv","smtp_protocol"), 'ssl'); ?>>SSL</option>
                            <option value='tls'  <?php $param->default_param(array("plugins", "send_conv","smtp_protocol"), 'tls'); ?>>TLS</option>
                        </select>
                        <br/><br/><hr/>
                    </li>
                    <li>
                        <p style="font-weight:bold;color:green;">Username and password for SMTP must be defined in arg.php</p><br/><br/><hr/>
                    </li>

                    <li>
                        <p>E-mail from address</p>
                        <input size="60px" name="from_address" value="<?php echo $param->default_value(array("plugins", "send_conv", "from_address"), 3); ?>" type="text">
                        <br/><br/><hr/>
                    </li>
                    <li>
                        <p>E-mail from name</p>
                        <input size="60px" name="from_name" value="<?php echo $param->default_value(array("plugins", "send_conv", "from_name"), 3); ?>" type="text">
                        <br/><br/><hr/>
                    </li>


                </ol>


            </div>


        </div>

    </div>


    <br/>

    <input id="paramsubmit2" type="submit" value="SUBMIT">
</form>
