	function ekle(id)
	{
		var veri="levelid="+id;
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
				$("#pos1").html("Position X:"+x+" Y:"+y);
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
	function deleteLevel(levelID)
	{
		var deleteData="levelID="+levelID;
		$.ajax({
			type:"POST",
			data:deleteData,
			url:"levelDelete.php",
			success:function(sonuc){
				alert("Level Silindi");
				window.location = "index.php?levelid=1";
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