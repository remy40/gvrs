
/* ============================================================================================================================
== BUBBLE WITH A RIGHT-ANGLED TRIANGLE
** ============================================================================================================================ */

/* THE SPEECH BUBBLE
------------------------------------------------------------------------------------------------------------------------------- */

.triangle-right {
	position:relative;
	padding:5px;
	margin:1em 0 3em;
	color:#fff;
	background:#075698; /* default background for browsers without gradient support */
	/* css3 */
	/*background:-webkit-gradient(linear, 0 0, 0 100%, from(#2e88c4), to(#075698));
	background:-moz-linear-gradient(#2e88c4, #075698);
	background:-o-linear-gradient(#2e88c4, #075698);
	background:linear-gradient(#2e88c4, #075698);*/
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
        text-align:center;
         background: rgb(46, 136, 196);
         background: rgba(46, 136, 196, 0.6);

       margin-right:2px;

}

/* Variant : for top positioned triangle
------------------------------------------ */

.triangle-right.top {
	background:-webkit-gradient(linear, 0 0, 0 100%, from(#075698), to(#2e88c4));
	background:-moz-linear-gradient(#075698, #2e88c4);
	background:-o-linear-gradient(#075698, #2e88c4);
	background:linear-gradient(#075698, #2e88c4);
}

/* Variant : for left positioned triangle
------------------------------------------ */

.triangle-right.left {
	margin-left:40px;
	background:#075698;
}

/* Variant : for right positioned triangle
------------------------------------------ */

.triangle-right.right {
	margin-right:40px;
	background:#075698;
}

/* THE TRIANGLE
------------------------------------------------------------------------------------------------------------------------------- */

.triangle-right:after {
	content:"";
	position:absolute;
	bottom:-10px; /* value = - border-top-width - border-bottom-width */

	border-width:10px 0 0 10px; /* vary these values to change the angle of the vertex */
	border-style:solid;
        border-color:transparent;
	border-top-color:rgba(46, 136, 196, 0.6); 
        
        
    /* reduce the damage in FF3.0 */
    display:block; 
    width:0;
    
}

/* Variant : top
------------------------------------------ */

.triangle-right.top:after {
	top:-20px; /* value = - border-top-width - border-bottom-width */
	right:50px; /* controls horizontal position */
	bottom:auto;
	left:auto;
	border-width:20px 20px 0 0; /* vary these values to change the angle of the vertex */
	border-color:transparent #075698; 
}

/* Variant : left
------------------------------------------ */

.triangle-right.left:after {
	top:16px; 
	left:-40px; /* value = - border-left-width - border-right-width */
	bottom:auto;
  
	border-width:15px 40px 0 0; /* vary these values to change the angle of the vertex */
	border-color:transparent #075698; 
}

/* Variant : right
------------------------------------------ */

.triangle-right.right:after {
	top:16px; 
	right:-40px; /* value = - border-left-width - border-right-width */
	bottom:auto;
        left:auto;
	border-width:15px 0 0 40px; /* vary these values to change the angle of the vertex */
	border-color:transparent #075698 ; 
}

.frei_room_left_arrow:after{
	left:50px; /* controls horizontal position */
}
.frei_room_right_arrow:after{
border-width:10px 10px 0 0; 
	right:50px; /* controls horizontal position */
}