<?php

session_start();

require_once '../../../hardcode.php';

if(!isset($_SESSION[$uid . 'FreiChatX_init']))exit;

?><html>
    <title>
        File Sending Wizard
    </title>
    <style type="text/css">
.frei_upload_button {
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
	background:-moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
	background-color:#79bbff;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	color:#ffffff;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:1px 1px 0px #528ecc;
}.frei_upload_button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff) );
	background:-moz-linear-gradient( center top, #378de5 5%, #79bbff 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff');
	background-color:#378de5;
}.frei_upload_button:active {
	position:relative;
	top:1px;
}

body{
    font-family: "Arial Black";
}

    </style>
    <body>
        <div class="frei_upload_border">
        <form name="upload" action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">choose file to send</label><br/><br/>


            <input id ="fromid" type="hidden" name="fromid"/>
            <input id="fromname" type="hidden" name="fromname"/>
            <input id="toid" type="hidden" name="toid"/>
            <input id="toname" type="hidden" name="toname"/>


            <input type="file" name="file" id="file" />
            <br /><br/>
            <input  class ="frei_upload_button" type="submit" name="submit" value="Send" />
        </form>
        </div>
    </body>
</html>
<script>    
    function freiVal(name,value)
    {
        var element = document.getElementById(name);

        if(element != null)
        {
            element.value=value;
        }
        else
        {
            alert("element does not exists");
        }
    }

    freiVal("toid",opener.FreiChat.toid);
    freiVal("fromid",opener.freidefines.GEN.reidfrom);
    freiVal("toname",opener.FreiChat.touser);
    freiVal("fromname",opener.freidefines.GEN.fromname);
</script>
