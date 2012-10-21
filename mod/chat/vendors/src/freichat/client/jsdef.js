
function Get_Cookie(check_name){
      
    if(typeof(Storage)!=="undefined")
    {
        // Yes! localStorage and sessionStorage support!
        // Some code.....
        //alert(check_name+ " "+localStorage.check_name);
        return localStorage.getItem(check_name);

    }
    else
    {
        // Sorry! No web storage support..
  
        var a_all_cookies=document.cookie.split(';');
        var a_temp_cookie='';
        var cookie_name='';
        var cookie_value='';
        var b_cookie_found=false;
        var i='';
        for(i=0;i<a_all_cookies.length;i++)

        {
                a_temp_cookie=a_all_cookies[i].split('=');
                cookie_name=a_temp_cookie[0].replace(/^\s+|\s+$/g,'');
                if(cookie_name==check_name)

                {
                    b_cookie_found=true;
                    if(a_temp_cookie.length>1)

                    {
                        cookie_value=unescape(a_temp_cookie[1].replace(/^\s+|\s+$/g,''));
                    }
                    return cookie_value;
                    break;
                }
                a_temp_cookie=null;
                cookie_name='';
            }
        if(!b_cookie_found)
        {
            return false;
        }
    }  
}
function Set_Cookie(name,value){
    
    
    if(typeof(Storage)!=="undefined")
    {
        // Yes! localStorage and sessionStorage support!
        // Some code.....
        localStorage.setItem(name,value);
    }
    else
    {
        // Sorry! No web storage support..
        var expires = 0;
        var path = '/';
        var domain = '';
        var secure = '';
        var today=new Date();
        today.setTime(today.getTime());
        if(expires)

        {
            expires=expires*1000*60*60*24;
        }
        var expires_date=new Date(today.getTime()+(expires));
        document.cookie=name+"="+escape(value)+
        ((expires)?";expires="+expires_date.toGMTString():"")+
        ((path)?";path="+path:"")+
        ((domain)?";domain="+domain:"")+
        ((secure)?";secure":"");
    }
}
function Delete_Cookie(name,path,domain){
    if(Get_Cookie(name))document.cookie=name+"="+
        ((path)?";path="+path:"")+
        ((domain)?";domain="+domain:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

if(!Get_Cookie('frei_time')){
    Set_Cookie('frei_time',"<?php echo time(); ?>");
}
if(!Get_Cookie('frei_custom_mesg')){
    Set_Cookie('frei_custom_mesg',"<?php echo $frei_trans['default_status']; ?>");
}


/*-----------------------Definitions--------------------------------------------*/
freidefines = {
     
    // GEN => GENERAL   CONFIGURATION
    GEN : {
        is_guest : '<?php echo $_SESSION[$uid."is_guest"]; ?>',//
        url:'<?php echo $url; ?>',
        ses_status:'<?php echo $_SESSION[$uid."freistatus"]; ?>',//
        reidfrom:'<?php echo $id; ?>',//
        getid:'<?php echo $_GET["id"]; ?>',
        fromname:'<?php echo $pfromname; ?>',
        custom_mesg:Get_Cookie('frei_custom_mesg'),
        time:Get_Cookie('frei_time'),
        referer:window.location.href,
        rtl:'<?php echo $_SESSION[$uid."rtl"]; ?>'
    },
   
    // SET => GENERAL   SETTINGS 
    SET : {
        theme:'<?php echo $cvs->color; ?>',
        fonload:'<?php echo $cvs->load; ?>',
        chatspeed:'<?php echo $cvs->chatspeed; ?>',
        draggable:'<?php echo $cvs->draggable; ?>',
        fxval:'<?php echo $cvs->fxval; ?>', //Jquery Effects
        mesgSendSpeed:'<?php echo $cvs->msgSendSpeed; ?>'
    },  
    
    STATUS : {
        
        IMG : {
            online:'<?php echo $frei_trans["go_online"]; ?>',
            offline:'<?php echo $frei_trans["go_offline"]; ?>',
            busy:'<?php echo $frei_trans["go_busy"]; ?>',
            invisible:'<?php echo $frei_trans["go_invisible"]; ?>' 
        },
        
        TEXT : {
            online:'<?php echo $frei_trans["status_txt_online"]; ?>',
            busy:'<?php echo $frei_trans["status_txt_busy"]; ?>',
            invisible:'<?php echo $frei_trans["status_txt_invisible"]; ?>',
            offline:'<?php echo $frei_trans["status_txt_offline"]; ?>'         
        }        
    },
    
    video_config : {
        api_key: '<?php echo "20319841"; ?>'
    },
 
    TRANS : {
        chat_message_me:'<?php echo $frei_trans["chat_message_me"]; ?>',
        chat_status:'<?php echo $frei_trans["chat_status"]; ?>',
        rtl:'<?php echo $frei_trans["rtl"]; ?> ',
        ban_mesg:'<?php echo $frei_trans["ban_mesg"]; ?>',
        chatroom_label:'<?php echo $frei_trans["chatroom_label"];?>',
        no_search_results:'<?php echo $frei_trans["no_search_results"]; ?>'
        
    },
    
    
    
    smiley_chatroomimg:'<?php echo $smiley_chatroomimg; ?>',
    rtlimg_enabled:'<?php echo $rtlimg_enabled; ?>',
    rtlimg_disabled:'<?php echo $rtlimg_disabled; ?>',
    gchatimg:'<?php echo $gchatimg; ?>',
    mailimg: '<?php echo $mailimg; ?>',
    saveimg: '<?php echo $saveimg; ?>',
    videoimg: '<?php echo $videoimg;?>',
    smileyimg: '<?php echo $smileyimg; ?>',
    arrowimg: '<?php echo $arrowimg; ?>',
    newtopimg: '<?php echo $newtopimg; ?>',
    btopimg:'<?php echo $btopimg; ?>',
    notransimg: '<?php echo $translatedisabledimg; ?>',
    translateimg:'<?php echo $translateimg; ?>',
    uploadimg:'<?php echo $uploadimg; ?>',
    deleteimg:'<?php echo $deleteimg; ?>',
    minimg:'<?php echo $minimg; ?>',
    maximg:'<?php echo $maximg; ?>',
    closeimg:'<?php echo $closeimg; ?>',
    logoutimg:'<?php echo $logoutimg; ?>',
    onlineimg:'<?php echo $onlineimg; ?>',
    busyimg:'<?php echo $busyimg; ?>',
    invisibleimg:'<?php echo $invisibleimg; ?>',
    restoreimg:'<?php echo $restoreimg; ?>',
    offlineimg:'<?php echo $offlineimg; ?>',
    offline:'<?php echo $offline; ?>',
    optimg:'<?php echo $optimg; ?>',
    toolimg:'<?php echo $toolimg; ?>',
    chatroomimg:'<?php echo $chatroomimg; ?>',
    jquery_theme:'<?php echo $jquery_theme; ?>',
    fnopermsht:'<?php echo $fnopermsht; ?>',     //Height When user has no permissions
    fnoonlineht:'<?php echo $fnoonlineht; ?>',   //Height When No one is online
    fone_onlineht:'<?php echo $fone_onlineht; ?>',    //Height When one user online
    fmaxht:'<?php echo $fmaxht; ?>',      //Height when more than one user

    smileys:JSON.parse('<?php echo $smileys; ?>'),
    thememaker:false,
 
    
 
    chatHistoryDeleted:'<?php echo $frei_trans["chatHistoryDeleted"]; ?>',
    chatHistoryNotFound:'<?php echo $frei_trans["chatHistoryNotFound"]; ?>',
    cb_head:'<?php echo $frei_trans["cb_head"]; ?>',
    pwdby:'<?php echo $frei_trans["pwdby"]; ?>',
    nopermsmesg:'<?php echo $frei_trans["noperms"]; ?>',
    nolinemesg:'<?php echo $frei_trans["noline"]; ?>',
    newmesg:'<?php echo $frei_trans["newmesg"]; ?>',
    onfoffline:'<?php echo $frei_trans["on_offline"]; ?>',
    restore_drag_pos:'<?php echo $frei_trans["restore_drag_pos"]; ?>',
    status_txt:'<?php echo $frei_trans["status_txt"]; ?>',
    opt_txt:'<?php echo $frei_trans["opt_txt"]; ?>',
    onOfflinemesg:'<?php echo $frei_trans["onOfflinemesg"]; ?>',

    plugin_trans_disable:'<?php echo $frei_trans["plugin_transdisable"]; ?>',
    plugin_trans_orig:'<?php echo $frei_trans["plugin_trans_orig"]; ?>',

    titles_translate:'<?php echo $frei_trans["titles_translate"]; ?>',
    titles_upload:'<?php echo $frei_trans["titles_upload"]; ?>',
    titles_mail: '<?php echo $frei_trans["titles_mail"]; ?>',
    titles_smiley: '<?php echo $frei_trans["titles_smiley"]; ?>',
    titles_clrcht: '<?php echo $frei_trans["titles_clrcht"]; ?>',
    titles_save: '<?php echo $frei_trans["titles_save"]; ?>',
    titles_videochat: '<?php echo $frei_trans["titles_videochat"]; ?>',

    status_online:'<?php echo $frei_trans["status_online"]; ?>',
    status_busy:'<?php echo $frei_trans["status_busy"]; ?>',
    status_invisible:'<?php echo $frei_trans["status_invisible"]; ?>',
    status_offline:'<?php echo $frei_trans["status_offline"]; ?>',
    default_status:'<?php echo $frei_trans["default_status"]; ?>',

    set_custom_mesg:'<?php echo $frei_trans["set_custom_mesg"]; ?>',
    chat_room_title: '<?php echo $frei_trans["chat_room_title"]; ?>',

    PLUGINS : {
      
        show_file_send:'<?php echo $cvs->show_file_sending_plugin; ?>',
        showtranslate:'<?php echo "disabled"; ?>',
        showsmiley:'<?php echo $cvs->show_smiley_plugin; ?>',
        showsave:'<?php echo $cvs->show_save_plugin; ?>',
        showmail:'<?php echo $cvs->show_mail_plugin; ?>',
        showchatroom:'<?php echo $show_chatroom_plugin; ?>',
        showvideochat:'<?php echo $cvs->show_videochat_plugin; ?>'
    },  



    JSdebug:'<?php echo $cvs->JSdebug; ?>',
    playsound:'<?php echo $cvs->playsound ?>',
    busy_timeOut:'<?php echo $cvs->busy_timeOut; ?>',
    offline_timeOut:'<?php echo $cvs->offline_timeOut; ?>',


    /* ACL => ACESS CONTROL LIST  PERMISSIONS*/

    ACL : {
        FILE : {
            user : '<?php echo $ACL["FILE"]["user"]; ?>',
            guest: '<?php echo $ACL["FILE"]["guest"]; ?>'
        },
        TRANSLATE : {
            user : '<?php echo $ACL["TRANSLATE"]["user"]; ?>',
            guest: '<?php echo $ACL["TRANSLATE"]["guest"]; ?>'
        },
        SAVE : {
            user : '<?php echo $ACL["SAVE"]["user"]; ?>',
            guest: '<?php echo $ACL["SAVE"]["guest"]; ?>'
        },
        SMILEY : {
            user : '<?php echo $ACL["SMILEY"]["user"]; ?>',
            guest: '<?php echo $ACL["SMILEY"]["guest"]; ?>'
        },
        MAIL : {
            user : '<?php echo $ACL["MAIL"]["user"]; ?>',
            guest: '<?php echo $ACL["MAIL"]["guest"]; ?>'
        },
        VIDEOCHAT : {
            user : '<?php echo $ACL["VIDEOCHAT"]["user"]; ?>',
            guest: '<?php echo $ACL["VIDEOCHAT"]["guest"]; ?>'
        }
        
    },

    /* ACL */

    xhash: '<?php echo preg_replace("/\?./","",$_GET["xhash"]); ?>',
    jconflicts:'<?php echo $cvs->conflict; ?>'
};

//COMM_15_DAY_NOTIFY_2



/*----------------------THE-PHP-JS-Bridge---------------------------------------*/



//COMM_EVERY_TIME_CHECK





/* THE main FreiChatX INIT part */




var X_init = false;
if(FreiChat)
{
    X_init = true;
}

var FreiChat = {
    oldtitle:document.title,
    loop:0,
    last_chatroom_msg_id:null,
    last_chatroom_usr_id:null,
    last_chatroom_msg_type:[], //[BUBBLE !!]TRUE ->RIGHT FALSE ->LEFT
    ses_status:freidefines.GEN.ses_status,
    time:0,
    chatroom_mesg_time:0,
    freistatus:null,
    ostatus:null,
    box_count:0,
    box_crt:[],
    box_crt_id:[],
    room_array:[],
    windowFocus:false,
    debug:freidefines.JSdebug, //Set to true to debug with firebug , set to false(default) when over
    cnt:0,
    inact_time:0,      //initial Inactivity time
    busy_timeOut:freidefines.busy_timeOut,  // In seconds
    offline_timeOut:freidefines.offline_timeOut, //In seconds
    inactive:false,  //initially not inactive
    onloadActive:false,
    clrchtids:[],
    bulkmesg:[],
    isOlduser:null,
    load_chatroom_complete:false,
    //Ttext:null,
    temporary_status:0,
    unique:0,
    timer:null,
    change_titletimer:null,
    first:false,
    RequestCompleted_get_members:true,
    RequestCompleted_send_messages:true,
    RequestCompleted_isset_mesg:true,
    SendMesgTimeOut:0,
    passBYpost:false,
    custom_mesg:'i am null',
    in_room:-1,
    chatroom_users : [],
    title: 'General Talk',
    bulkmesg_chatroom:[],
    height:20,
    chatroom_changed:false,
    first_message:true,
    last_chatmessage_usr_id:[],
    msg_access:true,
    long_poll:'true',
    chatroom_written : [false,false,false,false,false,false],
    publish:false,
    subscribe:false,
    inited_video_session:[],
    showed_myvideo:[],
    d_id:freidefines.reidfrom,
    video_session_connected:false
 
};
