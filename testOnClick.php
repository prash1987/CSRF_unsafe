<?php

?>

<head>		
   		<script type="text/javascript">
   			function alertMsg(msg){
   			alert("something was clicked")		  ;
			    document.getElementById('t2').value = msg;			  
			}
   		</script>
</head>


<div onclick= 'alertMsg("error")'>click here</div>
<input type="text" id='t2' name='t2'>