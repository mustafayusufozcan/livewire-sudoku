<?php

namespace App\Http\Livewire\Sudoku;

use App\Services\SudokuService;
use Livewire\Component;

class Block extends Component
{
    public int $x;
    public int $y;
    public ?int $value = null;
    public string $status = "empty";

    public function mount(int $x, int $y, ?int $value)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;

        if ($this->value != null) {
            $this->status = "fixed";
        }
    }

    public function render()
    {
        return view('livewire.sudoku.block');
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|string $key
     * 
     * @return void
     */
    public function selectNumber(int|string $key): void
    {
        if ($this->status == "fixed") {
            return;
        }

        if ($key == "Backspace") {
            $this->value = null;
            return;
        }

        $this->value = $key;

        if (SudokuService::checkNumber($this->x, $this->y, $key)) {
            $this->status = "correct";
        } else {
            $this->status = "wrong";
        }
    }

    protected function getListeners()
    {
        return ['selectNumber:' . $this->id => 'selectNumber'];
    }
}
