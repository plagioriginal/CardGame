<!doctype html>

<?php 
	session_start();
	$_SESSION['game_id'] = -1;
?>

<html>

	<head>
		<title>Card game</title>
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.min.css">
		<link rel = "stylesheet" type = "text/css" href = "css/style.css">
	</head>

	<body>
		<div class = "container-fluid">
			<div class = "row">
				<div class = "col-md-8">
					<div class="card">
  						<div class="card-body">
  							<h5 class="card-title" style="display: inline;">Game
  								<div style="float:right;">
            						<button type="button" class="btn btn-success pull-right game-listener" id ="new_game_btn">New Game</button>
  									<button type="button" class="btn btn-dark pull-right game-listener" id ="reset_game_btn">Reset</button>
        						</div>
  							</h5>
  							<hr>
    						<div id = "game-table" class = "text-center"></div>
  						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "card">
						<div class = "card-body">
							<h5 class = "card-title">Best scores</h5>
							<hr>
							<div id = "score-table" class = "text-center"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script type="text/javascript" src = "js/bootstrap.min.js"></script>
	<script type = "text/javascript" src = "js/script.js"></script>

</html>
