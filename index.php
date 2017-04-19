<?php include("assets/connection.php"); ?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <script type="text/javascript" src="assets/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="assets/jquery-ui.js"></script>
  <script type="text/javascript" src="assets/script.js"></script>
  <link rel="stylesheet" href="assets/style.css" />
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
			<button onClick="ekle(<?php echo $levelID; ?>)">Add Point</button>
			<button onClick="levelEkle()">New Level</button>
			<button onClick="deleteLevel(<?php echo $levelID; ?>)">Delete This Level</button>
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