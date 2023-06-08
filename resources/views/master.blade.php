<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sudoku</title>

    @livewireStyles
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex flex-column min-vh-100 min-vw-100">
        <div class="d-flex flex-grow-1 justify-content-center align-items-center">
            @livewire('sudoku.board')
        </div>
    </div>
   
    @livewireScripts

    <script>
        function handleKeyup(el, e) {
            const key = (e.key !== "Backspace" ? parseInt(e.key) : "Backspace")
            if((isNaN(key) || key > 9 || key < 1) && key != "Backspace") {
                return;
            }

            if(el.getInnerHTML().trim() == key) {
                return;
            }

            Livewire.emit("selectNumber:" + el.getAttribute("wire:id"), key)
        }

        function setActive(el) {
            document.querySelectorAll("div.block:not(.fixed)").forEach(element => {
                element.classList.remove("active");
            });

            if(!el.classList.contains("fixed"))
                el.classList.add('active')
        }
    </script>
</body>
</html>