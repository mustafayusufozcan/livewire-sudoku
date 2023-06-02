<?php

namespace App\Http\Livewire\Sudoku;

use App\Services\SudokuService;
use Livewire\Component;

class Block extends Component
{
    public int $x;
    public int $y;
    public ?int $value = null;
    public int $status = -1;

    public function mount(int $x, int $y, ?int $value, int $status = -1)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.sudoku.block');
    }

    public function getStatusClassName()
    {
        return match($this->status) {
            -1 => "empty",
            0 => "wrong",
            1 => "correct",
            2 => "fixed"
        };
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
        if ($this->status == 2) {
            return;
        }

        if ($key == "Backspace") {
            $key = null;
        }

        $this->value = $key;

        $this->status = SudokuService::checkNumber($this->x, $this->y, $key);
    }

    protected function getListeners()
    {
        return ['selectNumber:' . $this->id => 'selectNumber'];
    }
}
