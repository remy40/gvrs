//------------------------------------------------------------------------------
/*  The SMILEY plugin !*/
FreiChat.smiley = function(id)
{

    var smileys = $jn('#frei_smileys_'+id);

    if(smileys.hasClass('none'))
    {
        smileys.css('display','inline')
        .removeClass('none')
        .addClass('inline');
    }
    else
    {
        smileys.css('display','none')
        .removeClass('inline')
        .addClass('none');
    }
};
//------------------------------------------------------------------------------
FreiChat.smileylist = function(id)
{
    var smileys = freidefines.smileys;
    
    var i=0;
    
    var sm_array = [];
    
    for(i=0;i<smileys.length;i++){
        sm_array[i] = smileys[i].symbol;
    }
    
    var str;
    
    /*
    if(freidefines.thememaker == true) {
        str= '<span class="smileylist">'+FreiChat.mksmileyurl([':)',':(',':B',':\')',':laugh:',':cheer:',';)',':P',':angry:',':unsure:',':ohmy:',':huh:',':dry:',':lol:',':silly:',':woohoo:'], id)+'</span>';
    }else{
        str= '<span class="smileylist">'+FreiChat.mksmileyurl([':)',':(',':B',':\')',':laugh:',':cheer:',';)',':P',':angry:',':unsure:',':ohmy:',':huh:',':o',':0',':dry:',':lol:',':D',':silly:',':woohoo:'], id)+'</span>';
    }*/
    
    
    str= '<span class="smileylist">'+FreiChat.mksmileyurl(sm_array, id)+'</span>';
    
    
    return str;

};
//------------------------------------------------------------------------------
FreiChat.mksmileyurl = function(name,id)
{
    var namelen = name.length;
    var i=0;
    var str = '<tr>';
    var j=0;

    for(i=0; i<=namelen; i++)
    {
        if(name[i] == null || name[i] == undefined)
        {
            break;
        }

        if(j>=5)
        {
            str+='</tr><tr>';
            j=0;
        }
        
        var action;
        
        if(freidefines.thememaker == true) {
            action = ''
        }else{
            action = 'onmousedown=FreiChat.appendsmiley("'+name[i]+'","'+id+'")';
        }

        str += '<td><span class="frei_smiley_image" '+action+' >'+FreiChat.SmileyGenerate(name[i],id)+'</span></td>';
        j++
    }
    //sconsole.log('<table><td>'+str+'</td></table>');
    return '<table class="frei_smileys_table">'+str+'</table>';
};
//------------------------------------------------------------------------------
FreiChat.appendsmiley = function(name,id)
{
    var area = $jn('#chatboxtextarea'+id);

    if(id=='chatroom'){
        area = $jn('#chatroommessagearea');
    }
     
    $jn('#frei_smileys_'+id).css('display','none')
    .removeClass('inline')
    .addClass('none');

    area.val(area.val()+name+" ");
};



FreiChat.SmileyGenerate = function(messages,id)
{
    var replaced_mesg=messages;


    var smileys = freidefines.smileys;
    var i=0;    
    for(i=0;i<smileys.length;i++){
        
        replaced_mesg = replaced_mesg.frei_smiley_replace(smileys[i].symbol,'<img id="smile__'+id+'" src="'+FreiChat.make_url(smileys[i].image_name)+'" alt="smile" />');

    }
    return replaced_mesg;
};
//------------------------------------------------------------------------------
 
String.prototype.frei_smiley_replace = function(name,value){
    name = name.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    var re = new RegExp(name, "g");
    return this.replace(re,value);
}

/*  The SMILEY plugin !*/
//------------------------------------------------------------------------------
/*  The MAIL plugin !*/

FreiChat.sendmail = function(user,id)
{
    FreiChat.toid=id;
    FreiChat.touser=user;

    var left   = (screen.width  - 450)/2;
    var top    = (screen.height - 250)/2;

    window.open(freidefines.GEN.url+"client/plugins/mail/html.php",'mailWindow','width=450,height=250,top='+top+',left='+left);
};
/*  The MAIL plugin !*/
//------------------------------------------------------------------------------
/*  The TRANSLATE plugin !*/
FreiChat.changelang = function (lang,id)
{
    var CookieStatus = FreiChat.getCookie(id);

    if(lang == 'disable')
    {
        FreiChat.setCookie( "frei_stat_"+id, "disable&opened&"+CookieStatus.chatwindow_2+"&"+CookieStatus.message+"&"+CookieStatus.pos_top+"&"+CookieStatus.pos_left);
        $jn("#translateimage"+id).attr('src',FreiChat.make_url(freidefines.notransimg));
        $jn("#frei_trans"+id).slideToggle('slow');
    }
    else
    {
        $jn("#translateimage"+id).attr('src',FreiChat.make_url(freidefines.translateimg));
        FreiChat.setCookie( "frei_stat_"+id, lang+"&opened&"+CookieStatus.chatwindow_2+"&"+CookieStatus.message+"&"+CookieStatus.pos_top+"&"+CookieStatus.pos_left);
        $jn("#frei_trans"+id).slideToggle('slow');
    }
};
//------------------------------------------------------------------------------
FreiChat.translate = function(id)
{
    $jn("#frei_trans"+id).slideToggle();
};
//------------------------------------------------------------------------------
FreiChat.langlist = function(id)
{
    var str= '<span class="langlist">'+FreiChat.makelangurl(['en','de','zh','cy','tr','uk','ru','it','ja','el','iw','fr','gl','ar'], id)+'<br/><a href="javascript:void(0)" onmousedown=FreiChat.changelang("disable",\''+id+'\')>'+freidefines.plugin_trans_disable+'</a>&nbsp;</span>';
    return str;
};
//------------------------------------------------------------------------------
FreiChat.makelangurl = function(name,id)
{
    var namelen = name.length;
    var i=0;
    var str = '';
    for(i=0; i<=namelen; i++)
    {
        if(name[i] == null || name[i] == undefined)
        {
            break;
        }
        str += '<a href="javascript:void(0)" onmousedown=FreiChat.changelang("'+name[i]+'",\''+id+'\')>'+name[i]+'</a>&nbsp;';
    }
    return str;
};
//------------------------------------------------------------------------------
FreiChat.appendtranslate = function(language,id,arr)
{
    var div = null;
    if(arr[0] == 'callbyget')
    {
        div = $jn('#msg_'+arr[1]);
        div.translate(language,{
            not:'.notranslate'
        });
    }
    else
    {
        div = $jn("#frei_"+id+" .chatboxcontent");
        if(arr == null || arr == '')
        {
            div.translate(language,{
                not:'.notranslate'
            });
        }
        else
        {
            div.translate(language,{
                not:'.notranslate'
            });

        }

    }

};
//------------------------------------------------------------------------------
FreiChat.show_original_text = function(me,id)
{
    var show_by_delaying = function(){

        var pos = $jn(me).position();

        if($jn("#frei_orig_"+id).hasClass('iamtobehovered'))
        {
            $jn("#frei_orig_"+id).css( {
                "left": (pos.left-30) + "px",
                "top":(pos.top-50)+"px" ,
                "display" : "block"
            } );
        }
    };

    FreiChat.timer = setTimeout(show_by_delaying,500);
};
//------------------------------------------------------------------------------
FreiChat.show_original_text_onhover = function(me)
{
    if($jn(me).hasClass('iamtobehovered'))
    {
        $jn(me).addClass('iambeinghovered');
    }
    
 
};
//------------------------------------------------------------------------------
FreiChat.hide_original_text = function(id)
{
    var a = function(){
        if(!$jn("#frei_orig_"+id).hasClass('iambeinghovered'))

        {
            $jn("#frei_orig_"+id).css("display","none");
        }
    };
    setTimeout(a,500);
    clearTimeout(FreiChat.timer);
};
//------------------------------------------------------------------------------
FreiChat.hide_original_text_onout = function(id)
{

    var hide_by_delaying= function(){

        $jn("#frei_orig_"+id).removeClass('iambeinghovered');
        $jn("#frei_orig_"+id).css("display","none");
    };

    setTimeout(hide_by_delaying,500);

};
/*  The TRANSLATE plugin !*/
//------------------------------------------------------------------------------
/*  The UPLOAD plugin !*/
FreiChat.upload = function(user,id)
{
    FreiChat.toid=id;
    FreiChat.touser=user;
    var left   = (screen.width  - 400)/2;
    var top    = (screen.height - 200)/2;
    
    FreiChat.secure_upload = true;
    
    window.open(freidefines.GEN.url+"client/plugins/upload/html.php",'uploadWindow','width=400,height=200,top='+top+',left='+left);
};
/*  The UPLOAD plugin !*/
//------------------------------------------------------------------------------
/*  The VIDEO plugin !*/

//-------------------------------------------------------------------------------
/* Time */

FreiChat.getlocal_time = function(GMT_time) {
    
    
    
    if(GMT_time == 0){
        GMT_time = FreiChat.getGMT_time();   
    }    
       
    var d = FreiChat.Date;
    var offset = d.getTimezoneOffset()*60000;
    var timestamp = GMT_time - offset;
        
    var dTime = new Date(timestamp);
    var hours = dTime.getHours();
    var minute = dTime.getMinutes();
    
    if(minute < 10) {
        minute = "0"+minute;
    }
    /*
    var period = "AM";
    if (hours > 12) {
        period = "PM"
    }
    else {
        period = "AM";
    }*/
    //hours = ((hours > 12) ? hours - 12 : hours)
    return hours + ":" + minute + " ";// + period
}
//-----------------------------------------------------------------------------------------------
FreiChat.getGMT_time = function() {
    
    var d = new Date();
    var localtime = d.getTime();
    var offset = d.getTimezoneOffset()*60000;
    return localtime + offset;
}
//-----------------------------------------------------------------------------------------------
FreiChat.show_time = function(id){
    $jn("#freichat_time_"+id).css("visibility","visible");
}
//-----------------------------------------------------------------------------------------------
FreiChat.hide_time = function(id){
    $jn("#freichat_time_"+id).css("visibility","hidden");
}
//-----------------------------------------------------------------------------------------------
/* Time */
/* profile link */

FreiChat.show_profilelink = function(id) {
    $jn("#freichat_profile_link_"+id).css("visibility","visible");
    $jn("#freichat_user_"+id).addClass('freichat_userlist_hover');
}
FreiChat.hide_profilelink = function(id) {
    $jn("#freichat_user_"+id).removeClass('freichat_userlist_hover'); 
    $jn("#freichat_profile_link_"+id).css("visibility","hidden");
}


/* profile link */

/* API */
//TODO: implement API

FreiChat.logout = function(id) {
    
    if(typeof id == "undefined")id='me';
    
    $jn.get
    
}


/* API */