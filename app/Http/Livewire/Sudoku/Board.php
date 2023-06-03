<?php

namespace App\Http\Livewire\Sudoku;

use App\Services\SudokuService;
use Livewire\Component;

class Board extends Component
{
    private SudokuService $sudokuService;
    private array $sudoku;

    public function __construct()
    {
        $this->sudokuService = new SudokuService();
    }

    public function mount()
    {
        $this->sudoku = $this->sudokuService->create();
    }

    public function render()
    {
        return view('livewire.sudoku.board', [
            "sudoku" => $this->sudoku
        ]);
    }

    public function newGame()
    {
        $this->sudoku = $this->sudokuService->create(true);
    }
}
