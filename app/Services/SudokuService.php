<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class SudokuService
{

    /**
     * Sudoku instance.
     * @var array|null
     */
    private ?array $sudoku;

    public function create(int $difficulty = 40): array
    {
        if (!$this->getSudoku()) {
            for ($x = 0; $x < 9; $x++) {
                for ($y = 0; $y < 9; $y++) {
                    $number = $this->findNumber($x, $y);
                    if ($number === false) {
                        $this->sudoku[$x] = [];
                        $y = -1;
                        continue;
                    }
                    $isFixed = rand(1, 100) <= $difficulty ? true : false;
                    //status= -1: boş, 0: hatalı, 1: doğru, 2: sabit
                    $this->sudoku[$x][$y] = [
                        "a" => $number,
                        "v" => $isFixed ? $number : null,
                        "s" => $isFixed ? 2 : -1,
                    ];
                }
            }
            $this->setSudoku();
        }
        return $this->sudoku;
    }

    private function getSudoku(): bool
    {
        $sudoku = json_decode(Cookie::get("sudoku"), true);
        if ($sudoku !== null) {
            $this->sudoku = $sudoku;

            return true;
        }
        return false;
    }

    public function setSudoku(): void
    {
        cookie()->queue(cookie()->forever("sudoku", json_encode($this->sudoku)));
    }

    private function findNumber(int $x, int $y): int|bool
    {
        $numberKey = null;
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        do {
            if ($numberKey !== null) {
                unset($numbers[$numberKey]);
            }
            if (empty($numbers)) {
                return false;
            }
            $numberKey = array_rand($numbers);
            $number = $numbers[$numberKey];
        } while ($this->checkNumberIsExists($number, $x, $y));
        return $number;
    }

    private function checkNumberIsExists(int $number, int $x, int $y)
    {
        if ($this->checkBlock($x, $y, $number) || $this->checkRow($x, $number) || $this->checkColumn($y, $number)) {
            return true;
        }
        return false;
    }

    private function checkBlock(int $x, int $y, int $number)
    {
        $blockX = floor($x / 3);
        $blockY = floor($y / 3);

        $blockXStart = $blockX * 3;
        $blockXEnd = ($blockX + 1) * 3;

        $blockYStart = $blockY * 3;
        $blockYEnd = ($blockY + 1) * 3;

        for ($blockXIterator = $blockXStart; $blockXIterator < $blockXEnd; $blockXIterator++) {
            for ($blockYIterator = $blockYStart; $blockYIterator < $blockYEnd; $blockYIterator++) {
                if (isset($this->sudoku[$blockXIterator][$blockYIterator])) {
                    if ($this->sudoku[$blockXIterator][$blockYIterator]["a"] == $number) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function checkRow(int $x, int $number)
    {
        for ($rowIterator = 0; $rowIterator < 10; $rowIterator++) {
            if (isset($this->sudoku[$x][$rowIterator])) {
                if ($this->sudoku[$x][$rowIterator]["a"] == $number) {
                    return true;
                }
            }
        }
        return false;
    }

    private function checkColumn(int $y, int $number)
    {
        for ($columnIterator = 0; $columnIterator < 10; $columnIterator++) {
            if (isset($this->sudoku[$columnIterator][$y])) {
                if ($this->sudoku[$columnIterator][$y]["a"] == $number)
                    return true;
            }
        }
        return false;
    }

    public static function checkNumber(int $x, int $y, ?int $number): string
    {
        $sudoku = new self();
        $sudoku->getSudoku();
        
        $sudoku->sudoku[$x][$y]["v"] = $number;

        $status = 0;
        if ($sudoku->sudoku[$x][$y]["a"] === $number) {
            $status = 1;
        } elseif($number == null) {
            $status = -1;
        }

        $sudoku->sudoku[$x][$y]["s"] = $status;
        $sudoku->setSudoku();

        return $status;
    }
}
