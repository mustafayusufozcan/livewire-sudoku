<div>
    <div id="board">
        @for ($x = 0; $x < count($sudoku); $x++)
            @for ($y = 0; $y < count($sudoku[$x]); $y++)
                @livewire('sudoku.block', ['x' => $x, "y" => $y, 'value' => $sudoku[$x][$y]["v"], 'status' => $sudoku[$x][$y]["s"]], key(1000 . $x . $y))
            @endfor
        @endfor
    </div>
    <div class="d-flex justify-content-center gap-1 mt-4">
        <a href="javascript:;" wire:click="newGame" class="btn btn-warning">New Game</a>
        <a href="javascript:;" class="btn btn-success">Hint</a>
    </div>
</div>