<?php
	$i = 0;
    $row = 1;
    $colum = 1;
    $maxX = 20;
	$posX = 200;
    $maxY = 20;
	$posY = 10;
    $cellSize = 10;
	$border = 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" language="javascript">
	<?php
	echo "var row = $row;\n";
    echo "var colum = $colum;\n";
    echo "var maxX = $maxX;\n";
    echo "var maxY = $maxY;\n";
    ?>	
	var timer;
	var timerStart = 0;
	var generationCount = 1;
	
	function cellClick(posX,posY) {
		
		cell = document.getElementById(posX+":"+posY);
		if (cell.style.backgroundColor == "black") {
			cell.style.backgroundColor = "white";	
		}	
		else {
			cell.style.backgroundColor = "black";	
		}		
	}
	
	function chance(top,bottom) {
		//(top) in (bottom)
		fate = Math.floor(Math.random()*101);
		devision = 100 / bottom;
		bound = top * devision;
		if (fate < bound) {
			//win
			return 1;
		}
		else {
			//lose
			return 0;
		}
		 	
	}
	
	function rules(row,colum) {
		
		//loop through every cell
		while (colum <= maxY) {
			while (row <= maxX) {
				
				cell = document.getElementById(colum+":"+row);
				if (cell.style.backgroundColor == "black") {
					state = 1;
				}	
				else {
					state = 0;
				}
				
				neighbours = cell[eval("colum:row")];
				
				if (neighbours == 1 && state == 1) {
					colour = "white";	
				}
				else if ((neighbours == 2 && state == 1 )|| neighbours == 3) {
					colour = "black";
				}
				else if (neighbours > 3 && state == 1) {
					colour = "white";	
				}
				else {
					//over pop OR no pop
					colour = "white";	
				}
				cell = document.getElementById(colum+":"+row);
				cell.style.backgroundColor = colour;
		
				row++;
			}
			row = 1;
			colum++;
   		}
			
	}
	
	function cellCheck(posX,posY,colum,row) {
		var returnVar;
		if (row == 1 || row == maxY || colum == 1 || colum == maxX) {
			returnVar = 0;
		}
		else {
			cell = document.getElementById(posX+":"+posY);
			if (cell.style.backgroundColor == "black") {
				returnVar = 1;
			}	
			else {
				returnVar = 0;
			}
		}
		return returnVar;
	}
	
	function checkSuroundings(colum,row) {
		//check above
		posY = row -1;
		posX = colum;
		neighbours = cellCheck(posX,posY,colum,row);
		
		//check above right
		posY = row -1;
		posX = colum +1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
			
		//check right
		posY = row;
		posX = colum + 1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		
		//check below right
		posY = row +1;
		posX = colum +1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		
		//check below
		posY = row +1;
		posX = colum;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		
		//check below left
		posY = row +1;
		posX = colum -1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		
		//check left
		posY = row;
		posX = colum -1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		
		//check top left
		posY = row -1;
		posX = colum-1;
		neighbours = neighbours + cellCheck(posX,posY,colum,row);
		return neighbours;
	}
	
	function tick() {
		
		//loop through every cell
		while (colum <= maxY) {
			while (row <= maxX) {
				
				cell = document.getElementById(colum+":"+row);
				if (cell.style.backgroundColor == "black") {
					state = 1;
				}	
				else {
					state = 0;
				}
				
				neighbours = checkSuroundings(colum,row);
				cell[eval("colum:row")] = neighbours;
				
				row++;
			}
			row = 1;
			colum++;
   		}
		row = 1;
		colum = 1; 
		
		//apply rules & get colored (second pass)
		rules(row,colum);
	
		document.getElementById('generation').innerHTML = generationCount;
		generationCount++;
		timer = setTimeout("tick()",1000);
	}
		
	function startTimer() {
		if (!timerStart) {
			alert("started");
			timerStart=1;
			tick();
		}
		else {
		clearTimeout(timer)
		timerStart=0;
		}
	}
</script>



<style type="text/css">
.cell {
	border: 1px solid #000;
}
</style>

</head>

<body>
<?php
    
    while ($colum <= $maxX) {
    	while ($row <= $maxY) {
        	$output = "<div id='".$row.":".$colum."' class='cell'";
			$output.= " style='width:".$cellSize."px; height:".$cellSize."px; background-color:white; position:absolute; left:".$posX."px; top:".$posY."px;'";
			$output.= " onclick='javascript: cellClick(".$row.",".$colum.");'></div>\n";
			echo $output;
			$output = "";
			$posX = $posX + ($cellSize + $border);
            $row++;
			$i++;
        }
        $posX = $posX - (($cellSize + $border) * $maxX) ;
		$posY = $posY + ($cellSize + $border);
		$row = 1;
        $colum++;
    }
	echo "There are $i cells.";
?>
<div id="generation"> </div><br /><br />
<div style="width:50px; height:50px; background-color:black;" onClick="javascript: startTimer();"> </div>
</body>
</html>
