<?php
require_once '../arg.php';
require_once 'admin_files/moderate_users/drivers/' . $driver . '.php';

$conn = new FreiChat();
$conn->init_vars();
$mod = new $driver();
$mod->db_prefix = $db_prefix;
$mod->host = $host;
$mod->client_db_name = $client_db_name;
$mod->username = $username;
$mod->password = $password;
$mod->row_username = $row_username;
$mod->row_userid = $row_userid;
$mod->usertable = $usertable;
$mod->db = $conn->db;


$url = $conn->url;

$users = $mod->get_users();
$usernames = array();
$no_of_messages = array();
$ids = array();

foreach ($users as $user) {
    $user['username'] = str_replace("'","",$user['username']);
    $usernames[] = $user['username'];
    $ids[$user['username']] = $user['id'];
    $banned_ids[$user['username']] = $user['user_id'];
    $no_of_messages[$user['username']] = $user['no_of_messages'];
}
$usernames = json_encode($usernames);
$no_of_messages = json_encode($no_of_messages);
$ids = json_encode($ids);
$banned_ids = json_encode($banned_ids);
?>


<link rel="stylesheet" type="text/css" href="admin_files/moderate_users/table_style.css" />
<link rel="stylesheet" type="text/css" href="admin_files/moderate_users/paginator.css" />

<script type='text/javascript' src='admin_files/moderate_users/jquery.jqpagination.min.js'></script>



<script type='text/javascript'>
    typingtimer = [];
    //-------------------------------------------------------------------------------    
    function create_td(username,id,no_of_messages,banned) {   
        return '<tr><td>'+id+'</td><td>'+username+'</td><td>'+no_of_messages+'</td><td style="text-align:left"><span id="options_'+id+'"><span id="ban_'+id+'">ban</span><span style="color:red" id="banstatus_'+id+'">'+banned+'</span></td></tr>';
    }
    
    //-------------------------------------------------------------------------------    
    function todo_user(id) {
        
        var todo = $('#ban_'+id).data("todo");
        
        if(todo == "ban") ban_user(id);
        else unban_user(id);
    }
    //-------------------------------------------------------------------------------    
    function ban_user(id){
        var url = "<?php echo $url; ?>";
        url = url.replace('admin.php','');
        
        //url: ~server/ 
        
        var opt = confirm('Do you really want to ban this user ?');      
        if(opt != true)return;
        
        $.ajax({
            type: "POST",
            url: "admin_files/moderate_users/user_mod.php?mode=ban",
            data: { id:id },
            success: function(data) {  
                $('#ban_'+id+" span").text('unban').button("refresh");
                $('#ban_'+id).data("todo","unban");
                if(typeof typingtimer != "undefined")clearInterval(typingtimer[id]);
                $('#banstatus_'+id).teletype({
                    animDelay: 150,  // the bigger the number the slower the typing
                    text: '  banned',
                    id:id
                });
            }
           
            
        });
    }
    //-------------------------------------------------------------------------------    
    function unban_user(id){
        var url = "<?php echo $url; ?>";
        url = url.replace('admin.php','');
        
        //url: ~server/ 
        
        $.ajax({
            type: "POST",
            url: "admin_files/moderate_users/user_mod.php?mode=unban",
            data: { id:id },
            success: function(data) {  
                
                $('#ban_'+id+" span").text('ban').button("refresh");
                $('#ban_'+id).data("todo","ban");
                
                if(typeof typingtimer != "undefined")clearInterval(typingtimer[id]);
                $('#banstatus_'+id).revdel({
                    animDelay: 150,  // the bigger the number the slower the typing
                    text: ' banned',
                    id:id
                });
            }
            
        });
    }
    
    //-------------------------------------------------------------------------------      
    Array.prototype.chunk = function ( n ) {
        if ( !this.length ) {
            return [];
        }
        return [ this.slice( 0, n ) ].concat( this.slice(n).chunk(n) );
    };
    //-------------------------------------------------------------------------------        
    $.fn.teletype = function(opts){
        var $this = this,
        defaults = {
            animDelay: 150
        },
        settings = $.extend(defaults, opts);
        var str = settings.text;var progress=0;var id = settings.id;
        typingtimer[id] = setInterval(function() {
            $this.text(str.substring(0, progress++));
            if (progress > str.length) clearInterval(typingtimer[id]);
        }, 100);
        
    };
    //-------------------------------------------------------------------------------    
    $.fn.revdel = function(opts){
        var $this = this,
        defaults = {
            animDelay: 150
        },
        settings = $.extend(defaults, opts);
        var str = settings.text;
        var length=str.length;
        var progress = 1;
        var id = settings.id;
        typingtimer[id] = setInterval(function() {
            $this.text(str.substring(0, length-progress));progress++;
            if (progress > length) clearInterval(typingtimer[id]);
        }, 100);
        
    };
    
    
    //-------------------------------------------------------------------------------    
    function paginate_records(page) {
        var i=0;
                
        $.ajax({
            type: "POST",
            url: "admin_files/moderate_users/user_mod.php?mode=get_data",
            dataType: 'json',
            success: function(data) {  
                var i;                      
                var users = [];
                var no_of_messages = [];
                var ids = [];
                var banned_ids = [];
                        

                for(i=0;i<data.length;i++){
                    users[i] = data[i].username;
                    ids[data[i].username] = data[i].id;
                    no_of_messages[data[i].username] = data[i].no_of_messages;
                    banned_ids[data[i].username] = data[i].user_id;
                }                  

                FC.users = users;
                FC.no_of_messages = no_of_messages;
                FC.ids = ids;
                FC.banned_ids = banned_ids;
                search_records(page);

            }
        });
    }  
    //-------------------------------------------------------------------------------    
    function populate_page(page,users,no_of_messages,ids,banned_ids) {
        

        if(typeof users == "undefined")
            var users = FC.users;
        if(typeof no_of_messages == "undefined")
            var no_of_messages = FC.no_of_messages;
        if(typeof ids == "undefined")
            var ids = FC.ids;
        if(typeof banned_ids == "undefined")
            var banned_ids = FC.banned_ids;
        if(typeof page == "undefined")
            var page = 0;
                
        var user_pages=users.chunk(FC.records);   

        $('#table_cl').html('').html(FC.m_str);
        var str='';
        var j=0;
        var banned = ' ';
        var lenx;
        
        if(user_pages.length == 0) {
            $('#table_cl').html('<span class="no_records">No records to display</span>');
            return;
        }
        if(typeof user_pages[page].length != "undefined"){
            lenx = user_pages[page].length;
        }
        
        for(i=0;i<lenx;i++){      
            if(ids[user_pages[page][i]] == banned_ids[user_pages[page][i]]) banned = ' banned';
   
            str+= create_td(user_pages[page][i],ids[user_pages[page][i]],no_of_messages[user_pages[page][i]],banned);
            banned = ' ';   
        }

        FC.max_page = user_pages.length;
        FC.currpage = page+1;

        
        $('#page_nav_input').attr('data-max-page',user_pages.length).val('Page '+(page+1)+' of '+FC.max_page);
        $('#pagination').find('input').data('max-page',user_pages.length);
        if((page+1) == FC.max_page){
            $('#pagination').find('.next, .last').addClass('disabled');
        }else{
            var ele = $('#pagination').find('.next, .last');
            if(ele.hasClass('disabled')){
                ele.removeClass('disabled');
            }
        }
        
        if((page+1) == 1){
            var ele = $('#pagination').find('.first, .previous');
            if(!ele.hasClass('disabled')){
                ele.addClass('disabled');
            }
        }
        // $('#pagination .next')
        
        

        
        $('#table_cl').append(str);
        var id;
        for(i=0;i<user_pages[page].length;i++) {
            id = ids[user_pages[page][i]];         
            if(ids[user_pages[page][i]] == banned_ids[user_pages[page][i]]){
                $('#ban_'+id).data("todo","unban");
                $('#ban_'+id).html('unban').button().mousedown((function(i){
                    return function() { todo_user(i);   }
                })(id));
            }else{
                $('#ban_'+id).data("todo","ban");
                $('#ban_'+id).button().mousedown((function(i){
                    return function() {  todo_user(i);   }
                })(id));
            }
        }
        
    }
    //-------------------------------------------------------------------------------
    function search_records(page) {
        var search = $.trim($('#user_search').val());
        
        if(typeof page == "undefined") page=0;

        if(search == ""){
            populate_page(page);
            return;
        }
                
        var len = FC.users.length;
        var i=0;var u=0;
        var users = [];
        var no_of_messages = [];
        var ids = [];
        var banned_ids = [];
                
        for(i=0;i<len;i++) {
            if(FC.users[i].indexOf(search) != -1) {
                users[u] = FC.users[i];//alert(userdata[i])
                no_of_messages[FC.users[i]] = FC.no_of_messages[FC.users[i]];
                ids[FC.users[i]] = FC.ids[FC.users[i]];
                banned_ids[FC.users[i]] = FC.banned_ids[FC.users[i]];
                u++;
            }
        }
        //console.log(users); 
        populate_page(page,users,no_of_messages,ids,banned_ids);       
    }
    //-------------------------------------------------------------------------------    
    $(document).ready(function(){

        $('#user_search').keyup(function(){
            search_records(0); 
        });
        
        
        var users = <?php echo $usernames; ?>;
        var no_of_messages = <?php echo $no_of_messages; ?>;
        var ids = <?php echo $ids; ?>;
        var banned_ids = <?php echo $banned_ids; ?>;

        var records = 5;
        var m_str = '<tr><th>id</th><th>username</th><th>no. of messages</th><th>options</th></tr>';

        
        FC = {
            no_of_messages:no_of_messages,
            ids:ids,
            banned_ids:banned_ids,
            records:records,
            m_str:m_str,
            users:users
        };
            
        populate_page(0);
        
        
        $('#pagination').jqPagination({
            paged: function(page) {
                page--; //array starts from 0
                paginate_records(page);
            }
            
        });
        
    });
    
    


</script>
<img id="searchimg" src="admin_files/moderate_users/images/search.jpg" />
<input type="search" id="user_search" placeholder="search users"/>
<table class="table_cls" id="table_cl" cellspacing='0'> <!-- cellspacing='0' is important, must stay -->
</table>

<div id="pag">
    <div id="pagination" class="pagination" >
        <a href="#" class="first" data-action="first">&laquo;</a>
        <a href="#" class="previous" data-action="previous">&lsaquo;</a>
        <input id="page_nav_input" type="text" readonly="readonly" data-max-page="'+max_page+'" />
        <a href="#" class="next" data-action="next">&rsaquo;</a>
        <a href="#" class="last" data-action="last">&raquo;</a></div>
</div>