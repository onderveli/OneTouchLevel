<?php include("assets/connection.php"); ?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <script type="text/javascript" src="assets/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="assets/jquery-ui.js"></script>
  <style type="text/css">
    body{
    	font-family: courier new, courier; 
    	font-size: 12px; 
		background-color: black;
		padding: 0px;
		margin: 0px;
	}
	.draggable{
		display: inline-block; 
		cursor: move;
		border-radius:30px;
		width:30px;
		height:30px;
		position: absolute;
		background-color:orange;		
	}
	.guide{
		display: none; 
		position: absolute; 
		left: 0; 
		top: 0; 
	}

	#guide-h{
		border-top: 1px dashed #55f; 
		width: 100%; 
	}

	#guide-v{
		border-left: 1px dashed #55f; 
		height: 100%; 
	}
	#plane{
		width: 480px;
		height: 800px;
		background-color: white;
		overflow:visible;
	}
	  	#position{
		background-color: red;
		color: white;
		padding: 10px;
			 height: 15px;
    padding: 10px;
	}
	#guideH
	{
		width: 480px;
		height: 0px;  
	}
	#guideV
	{
		width: 0px;
		height: 800px;
	}
	#workPlane
	{
		width: 480px;
		float: left;
	}
	#tools
	{
		width: 500px;
		background-color:darkred;
		padding: 10px;
		float: left;
		color: white;
	}
	#pos1
	{
		float: left;
	}
	#posTool
	{
		width: 120px;
		float: right;
	}
	  input
	  {
		  width: 100%;
		  
	  }
  </style>


<script type="text/javascript">
	function ekle()
	{
		var veri="levelid=<?php echo $_GET['levelid'] ?>";
		$.ajax({
			url:"pointAdd.php",
			data:veri,
			type:"POST",
			success: function(sonuc)
			{
				$("#plane").append("<div class='draggable' ondblclick='pointDelete("+sonuc+")' onClick='position_(this,"+sonuc+")'></div>");
				align();
			}
		});
		
	}
	function levelEkle()
	{
		$.ajax({
			url:"levelEkle.php",
			type:"POST",
			success: function(sonuc)
			{
				alert("Level Eklendi");
				location.reload();
			}
		});
		
	}
	function duzenle()
	{
		align();
	}
	function position_(e,id){
		var x1=e.style.top;
		var x=parseInt(x1.substring(0, x1.length -2));
		var y1=e.style.left;
		var y=parseInt(y1.substring(0, y1.length -2));
		
		var veri="id="+id+"&posX="+x+"&posY="+y;
		$.ajax({
			url:"pointUpdate.php",
			data:veri,
			type:"POST",
			success: function(sonuc)
			{
				$("#pos1").html("Position X:"+x+" Y:"+y+" PointID:"+id);
			}
		});
	}
	function levelUpdate()
	{
		var name=$("input[name=levelName]").val();
		var id=$("input[name=levelid]").val();
		var time=$("input[name=levelTime]").val();
		var moveNumber=$("input[name=levelMoveNumber]").val();
		var score=$("input[name=levelScore]").val();
		
		var levelData="name="+name+"&time="+time+"&moveNumber="+moveNumber+"&score="+score+"&id="+id;
		$.ajax({
			type:"POST",
			data:levelData,
			url:"levelUpdate.php",
			success:function(sonuc){
				alert("Değişiklikler Kaydedildi");
			}
		});
	}
	function pointDelete(pointID)
	{
		var deleteData="pointID="+pointID;
		$.ajax({
			type:"POST",
			data:deleteData,
			url:"pointDelete.php",
			success:function(sonuc){
				alert("Point Silindi");
				location.reload();
			}
		});
	}
	function levelreLoad(e)
	{
		window.location = "index.php?levelid="+e.options[e.selectedIndex].value;
	}
	function align(){

	var MIN_DISTANCE = 10; // minimum distance to "snap" to a guide
	var guides = []; // no guides available ... 
	var innerOffsetX, innerOffsetY; // we'll use those during drag ... 

	$( ".draggable" ).draggable({
		start: function( event, ui ) {
			guides = $.map( $( ".draggable" ).not( this ), computeGuidesForElement );
			innerOffsetX = event.originalEvent.offsetX;
			innerOffsetY = event.originalEvent.offsetY;
		}, 
		drag: function( event, ui ){
			// iterate all guides, remember the closest h and v guides
			var guideV, guideH, distV = MIN_DISTANCE+1, distH = MIN_DISTANCE+1, offsetV, offsetH; 
			var chosenGuides = { top: { dist: MIN_DISTANCE+1 }, left: { dist: MIN_DISTANCE+1 } }; 
			var $t = $(this); 
			var pos = { top: event.originalEvent.pageY - innerOffsetY, left: event.originalEvent.pageX - innerOffsetX }; 
			var w = $t.outerWidth() - 1; 
			var h = $t.outerHeight() - 1; 
			var elemGuides = computeGuidesForElement( null, pos, w, h ); 
			$.each( guides, function( i, guide ){
				$.each( elemGuides, function( i, elemGuide ){
					if( guide.type == elemGuide.type ){
						var prop = guide.type == "h"? "top":"left"; 
						var d = Math.abs( elemGuide[prop] - guide[prop] ); 
						if( d < chosenGuides[prop].dist ){
							chosenGuides[prop].dist = d; 
							chosenGuides[prop].offset = elemGuide[prop] - pos[prop]; 
							chosenGuides[prop].guide = guide; 
						}
					}
				} ); 
			} );

			if( chosenGuides.top.dist <= MIN_DISTANCE ){
				$( "#guide-h" ).css( "top", chosenGuides.top.guide.top ).show(); 
				ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset;
			}
			else{
				$( "#guide-h" ).hide(); 
				ui.position.top = pos.top; 
			}

			if( chosenGuides.left.dist <= MIN_DISTANCE ){
				$( "#guide-v" ).css( "left", chosenGuides.left.guide.left ).show(); 
				ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset; 
			}
			else{
				$( "#guide-v" ).hide(); 
				ui.position.left = pos.left; 
			}
		}, 
		stop: function( event, ui ){
			$( "#guide-v, #guide-h" ).hide(); 
		}
	});
	function computeGuidesForElement( elem, pos, w, h ){
		if( elem != null ){
			var $t = $(elem); 
			pos = $t.offset(); 
			w = $t.outerWidth() - 1; 
			h = $t.outerHeight() - 1; 
		}

		return [
			{ type: "h", left: pos.left, top: pos.top }, 
			{ type: "h", left: pos.left, top: pos.top + h }, 
			{ type: "v", left: pos.left, top: pos.top }, 
			{ type: "v", left: pos.left + w, top: pos.top },
			// you can add _any_ other guides here as well (e.g. a guide 10 pixels to the left of an element)
			{ type: "h", left: pos.left, top: pos.top + h/2 },
			{ type: "v", left: pos.left + w/2, top: pos.top } ]; 
		}
	} 
</script>
</head>
	<body>
		<div id="workPlane">

			<div id="guideH" class="draggable"></div>
			<div id="guideV" class="draggable"></div>
			<div id="plane" class="div">
				<?php
					$levelID=	$_GET['levelid'];
					$pointData=mysqli_query($baglan,"select * from points where levelid=".$levelID);
					while($getPointData=mysqli_fetch_array($pointData))
					{
						echo "<div class='draggable' ondblclick='pointDelete(".$getPointData['id'].")' onclick='position_(this,".$getPointData['id'].")' style='left: ".$getPointData['posY']."px; top: ".$getPointData['posX']."px;'></div>";
						
					}			
				
				?>
			</div>
			<div id="guide-h" class="guide"></div>
			<div id="guide-v" class="guide"></div>
		</div>
		<div id="tools">
		<?php 
			$levelID=	$_GET['levelid'];
			$levelData=mysqli_query($baglan,"select * from levels where id=".$levelID);
			while($getLevelData=mysqli_fetch_array($levelData))
			{
				$name=$getLevelData['name'];
				$time=$getLevelData['time'];
				$score=$getLevelData['score'];
				$moveNumber=$getLevelData['moveNumber'];
				
			}
			?>
			<div id="position">
				<div id="pos1">Position</div>
				<div id="posTool">
					<select name="levels" onChange="levelreLoad(this)">
					<?php
						$levelID=	$_GET['levelid'];
						$levelData=mysqli_query($baglan,"select * from levels");
						while($getLevelData=mysqli_fetch_array($levelData))
						{
							if($levelID==$getLevelData['id'])
							{
								echo '<option selected value="'.$getLevelData['id'].'">'.$getLevelData['name'].'</option>';
							}
							else
							{
								echo '<option value="'.$getLevelData['id'].'">'.$getLevelData['name'].'</option>';
							}
							
						}
					?>
					</select>
					<button onClick="duzenle()">Set Draw</button>
				</div>
					
			</div><br>
			<button onClick="ekle()">Add Point</button>
			<button onClick="levelEkle()">New Level</button>
			<form action="" method="post">
				<label>Name:</label><br>
				<input type="text" value="<?php echo $name; ?>" name="levelName">
				<label>Score:</label><br>
				<input type="text" value="<?php echo $score; ?>" name="levelScore">
				<label>Time:</label><br>
				<input type="text" value="<?php echo $time; ?>" name="levelTime">
				<label>Move Number:</label><br>
				<input type="text" value="<?php echo $moveNumber; ?>" name="levelMoveNumber">
				<input type="hidden" value="<?php echo $levelID; ?>" name="levelid">
				<br>
				<br>
				<input type="button" value="Save" onClick="levelUpdate()">
			</form>
			
		</div>
	</body>
</html>