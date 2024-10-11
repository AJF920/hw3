<?php
session_start();

include 'tic-tac-toe-functions.php';

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = initializeGame();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, '-') !== false) {
            $position = explode('-', $key);
            $row = $position[0] - 1;
            $col = $position[1] - 1;
            makeMove($row, $col);
        }
    }

    if (isset($_POST['reset'])) {
        resetGame();
    }
}

$gameState = $_SESSION['game'];
$board = $gameState['board'];
$currentPlayer = $gameState['currentPlayer'];
$winner = $gameState['winner'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic-Tac-Toe</title>
    <style>
        /* Button background is blue with a black border*/
		button {
			background-color: #3498db;
			height: 100%;
			width: 100%;
			text-align: center;
			font-size: 20px;
			color: white;
			vertical-align: middle;
			border: 0px;
		}

		/* Styles the table cells to look like a tic-tac-toe grid */
		table td {
			text-align: center;
			vertical-align: middle;
			padding: 0px;
			margin: 0px;
			width: 75px;
			height: 75px;
			font-size: 20px;
			border: 3px solid #040404;
			color: white;
		}

		/* This shows a darker blue background when the mouse hovers over the buttons */
		button:hover,
		input[type="submit"]:hover,
		button:focus,
		input[type="submit"]:focus {
			background-color: #04469d;
			text-decoration: none;
			outline: none;
		}

        .x {
            background-color: green; 
            color: white; 
        }

        .o {
            background-color: red;
            color: white;
        }

        .empty {
            background-color: white; 
            color: transparent;
        }
    </style>
</head>
<body>
    <h1>Tic Tac Toe</h1>

    <p>Turn: <?php echo $currentPlayer; ?></p>

    <form method="POST" action="">
        <table>
            <?php for ($row = 0; $row < 3; $row++): ?>
                <tr>
                    <?php for ($col = 0; $col < 3; $col++): ?>
                        <td>
                            <?php if ($board[$row][$col] === ''): ?>
                                <?php if (!$winner): ?>
                                    <button type="submit" name="<?php echo ($row+1) . '-' . ($col+1); ?>">
                                        <?php echo $currentPlayer; ?>
                                    </button>
                                <?php else: ?>
                                    <button class="empty" disabled>
                                        &nbsp;
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button style="background-color: <?php echo $board[$row][$col] === 'X' ? 'green' : 'red'; ?>; color: white;" disabled>
                                    <?php echo $board[$row][$col]; ?>
                                </button>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>

        <div>
            <button type="submit" name="reset">Reset Game</button>
        </div>
    </form>

    <?php if ($winner): ?>
        <p>The winner is <?php echo $winner; ?>!</p>
    <?php elseif ($winner === 'draw'): ?>
        <p>It's a draw!</p>
    <?php endif; ?>

</body>
</html>
