<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Dr. Detective Game</title> 
<link href="bootstrap/css/bootstrap.css" rel="stylesheet"> 
<link href="tagmanager/bootstrap-tagmanager.css" rel="stylesheet"> 
<link href="game.css" rel="stylesheet">

<?php include "game_options.php"; ?>

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Dr.Detective</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li class="active" ><a href="#">Game</a></li>
              <li><a href="leaders.php">
              High Scores</a></li>
              <li><a href="#about">About</a></li>
            </ul>
            
            <ul class="nav pull-right">
              <li class="navmsg">Hi <span class="navname" id="navuser"></span>! You scored: <span class="navimp" id="navscore"> </span> points</li>
              <li><a href="#" id="notifPopover" rel="popover" data-content="<?php echo $pop_text; ?>"><img src="img/red.png" width="25" height="25"><img src="img/blue.png" width="20" height="20"></a></li>
              <li><a href="login.php">(logout)</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
   </div>
   
   <div class="container" style="float: none; margin: 0 auto;">
   
		 <div class="row"><br><br><br>
				<div class="span4">
				<h5><b>Step 1:</b> Pick the level you want to play:
				<div class="imgpop"><a href="#" id="levelPop" data-content="this is the level of difficulty for the game you will play" rel="popover"><img src="img/question.png" width="15" height="15"></a></div></h5>
					<div class="btn-group">
						<button class="btn btn-large" onclick="pickLevel('quick')" id="quick">Quick Game</button>
						<button class="btn btn-large" onclick="pickLevel('normal')" id="normal">Normal Game</button>
						<button class="btn btn-large" onclick="pickLevel('hard')" id="hard">Hard Game</button>
					</div>
				</div>
			</div>

	<div class="row" ><br/>
		<div class="span11" id="domainsSpan">
		<h5><b>Step 2:</b> Pick your domain:
				<div class="imgpop"><a href="#" id="domainPop" data-content="this is the domain of the case reports you will read" rel="popover"><img src="img/question.png" width="15" height="15"></a></div></h5>
			<ul>
				<li id="domLink0"><a href="#" onclick="pickDomains('Hematology/Oncology');" id="dl0" rel="popover">Hematology/Oncology</a></li>
				<li id="domLink1"><a href="#" onclick="pickDomains('Nephrology');" id="dl1" rel="popover">Nephrology</a></li>
				<li id="domLink2"><a href="#" onclick="pickDomains('Primary Care/Hospitalist/Clinical Practice');" id="dl2" rel="popover">Primary Care/Hospitalist/Clinical Practice</a></li>
				<li id="domLink3"><a href="#" onclick="pickDomains('Viral Infections');" id="dl3" rel="popover">Viral Infections</a></li>
			</ul>
		</div>
		
		</div>
	
	<div id="taskButtons">
		<div class="row">
			<div class="span11"><br>
			<h5><b>Step 3:</b> Pick the task you want to solve:
				<div class="imgpop"><a href="#" id="taskPop" data-content="this is the type of task you will solve on the case reports" rel="popover"><img src="img/question.png" width="15" height="15"></a></div></h5>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<button class="btn btn-large btn-primary" type="button" style="width: 200px !important;" onclick="pickTask('factors', 'annotate');" id="factorsannotate">Identify clues</button>
			</div>
			<div class="span3">
				<button class="btn btn-large btn-primary" type="button" style="width: 200px !important;" onclick="pickTask('factors', 'validate');" id="factorsvalidate">Verify clues</button>
			</div>
		</div>
		<div class="row"><br>
			<div class="span3">
				<button class="btn btn-large btn-primary" type="button" style="width: 200px !important;" onclick="pickTask('relations', 'annotate');" id="relationsannotate">Identify relations</button>
			</div>
			<div class="span3">
				<button class="btn btn-large btn-primary" type="button" style="width: 200px !important;" onclick="pickTask('relations', 'validate');" id="relationsvalidate">Verify relations</button>
			</div>
		</div>
		</div>
		
		
		
  </div>
  
  <form id="startGame" method="POST">
  	<input type="hidden" name="domains" id="domainsInput" />
  	<input type="hidden" name="level" id="levelInput" />
  </form>

	<script src="jquery-2.0.2.min.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>    
	<script type="text/javascript">
			var userName = "<?php echo $wid; ?>";
			$("#navuser").text(userName);
			
			var currScore = <?php echo $current_score ; ?>;
			var savedLevel = "<?php echo $level ; ?>";
			$("#navscore").text(currScore.toFixed(1));
			
			var domainsArray = Array("Hematology/Oncology", "Nephrology", "Primary Care/Hospitalist/Clinical Practice", "Viral Infections");
			var domainsSolved = Array(false, false, false, false);
			
			$(function () {
				$("#notifPopover").popover({trigger: 'hover', placement:'bottom', html : true });  
				
				$("#levelPop").popover({trigger: 'hover', placement:'right', html : true });  
				$("#domainPop").popover({trigger: 'hover', placement:'right', html : true }); 
				$("#taskPop").popover({trigger: 'hover', placement:'right', html : true });
				
				$("#dl0").popover({trigger: 'hover', placement:'right'});
				$("#dl1").popover({trigger: 'hover', placement:'right'});
				$("#dl2").popover({trigger: 'hover', placement:'right'});
				$("#dl3").popover({trigger: 'hover', placement:'right'});
			}); 
	</script>
	
	<?php
		echo "<script type=\"text/javascript\">\n";
		echo "var totDom = Array(";
		for ($i = 0; $i < 4; $i++) {
			if ($i > 0) echo ",\n";
			echo "Array(";
			for ($j = 0; $j < 3; $j++) {
				if ($j > 0) echo ", ";
				echo "'".$domain_count[$i][$j]."'";
			}
			echo ")";
		}
		echo ");\n";
		
		echo "var solvedDom = Array(";
		for ($i = 0; $i < 4; $i++) {
			if ($i > 0) echo ",\n";
			echo "Array(";
			for ($j = 0; $j < 3; $j++) {
				if ($j > 0) echo ", ";
				echo "'".$domain_count_solved[$i][$j]."'";
			}
			echo ")";
		}
		echo ");\n";
		echo "</script>";
	?>
	
	<script src="game_options.js"></script>    
	
</body>
</html>
