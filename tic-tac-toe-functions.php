<?php
function initializeGame() {
    $gameBoard = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    return [
        'board' => $gameBoard,
        'currentPlayer' => 'X',
        'winner' => null,
        'moves' => 0
    ];
}

function makeMove($row, $col) {
    if (!isset($_SESSION['game'])) {
        return;
    }
    
    $gameState = $_SESSION['game'];
    $board = $gameState['board'];
    $currentPlayer = $gameState['currentPlayer'];

    if ($board[$row][$col] === '') {
        $board[$row][$col] = $currentPlayer;

        $gameState['moves']++;

        $winner = whoIsWinner($board);
        if ($winner) {
            $gameState['winner'] = $winner;
        } elseif ($gameState['moves'] === 9) {
            $gameState['winner'] = 'draw'; 
        } else {
            $gameState['currentPlayer'] = ($currentPlayer === 'X') ? 'O' : 'X';
        }

        $gameState['board'] = $board;
        $_SESSION['game'] = $gameState;
    }
}

function whoIsWinner($board) {
    if (checkWhoHasTheSeries($board, 'X')) {
        return 'X';
    } elseif (checkWhoHasTheSeries($board, 'O')) {
        return 'O';
    }

    // No winner yet
    return null;
}

function checkWhoHasTheSeries($board, $player) {
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] === $player && $board[$i][1] === $player && $board[$i][2] === $player) {
            return true;
        }
        if ($board[0][$i] === $player && $board[1][$i] === $player && $board[2][$i] === $player) {
            return true;
        }
    }
    if ($board[0][0] === $player && $board[1][1] === $player && $board[2][2] === $player) {
        return true;
    }
    if ($board[0][2] === $player && $board[1][1] === $player && $board[2][0] === $player) {
        return true;
    }
    return false;
}

function resetGame() {
    $_SESSION['game'] = initializeGame();
}
?>
