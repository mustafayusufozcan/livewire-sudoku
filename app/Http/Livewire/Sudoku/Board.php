<?php

namespace App\Http\Livewire\Sudoku;

use App\Services\SudokuService;
use Livewire\Component;

class Board extends Component
{
    private array $sudoku;

    public function mount()
    {
        $sudokuService = new SudokuService();
        $this->sudoku = $sudokuService->create();
    }

    public function render()
    {
        return view('livewire.sudoku.board', [
            "sudoku" => $this->sudoku
        ]);
    }
}
