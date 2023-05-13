<div id="board">
    @for ($x = 0; $x < count($sudoku); $x++)
        @for ($y = 0; $y < count($sudoku[$x]); $y++)
            @livewire('sudoku.block', ['x' => $x, "y" => $y, 'value' => $sudoku[$x][$y]])
        @endfor
    @endfor
</div>