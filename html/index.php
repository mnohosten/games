<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Div</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: grid;
            place-items: center;
            font-family: monospace;
            font-size: 2rem;
        }
        #board {
            /*width: 100ch; !* Adjust width as needed *!*/
            height: 200px; /* Adjust height as needed */
            background-color: lightgray;
            text-align: center;
            line-height: 200px; /* Same as height for vertical centering */
            padding: 0 2ch;
        }
        #timer {
            width: 100%;
            height: 20px;
            background-color: green;
        }
        @media (max-width: 600px) {
            html, body {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>

<div id="board">
    <div id="timer"></div>
    <span id="a"></span> +
    <span id="b"></span> =
    <span id="c"></span>
</div>
<audio id="audio-good">
    <source src="/audio/good.mp3" type="audio/mp3">
    Your browser does not support the audio tag.
</audio>
<audio id="audio-bad">
    <source src="/audio/bad.mp3" type="audio/mp3">
    Your browser does not support the audio tag.
</audio>
<audio id="audio-error">
    <source src="/audio/error.mp3" type="audio/mp3">
    Your browser does not support the audio tag.
</audio>


<script>
    window.addEventListener('DOMContentLoaded', () => {
        const a = document.getElementById('a');
        const b = document.getElementById('b');
        const c = document.getElementById('c');
        const timer = document.getElementById('timer');
        const board = document.getElementById('board');
        const audioGood = document.getElementById('audio-good');
        const audioBad = document.getElementById('audio-bad');
        const audioError = document.getElementById('audio-error');

        const x = Math.max(1, Math.floor(Math.random() * 9));
        const y = Math.max(1, Math.floor(Math.random() * (10 - x)));
        a.textContent = x;
        b.textContent = y;
        c.textContent = '?';

        const delta = parseInt(timer.getBoundingClientRect().width / 100);
        const stop = setInterval(() => {
            timer.style.width = Math.floor(timer.getBoundingClientRect().width - delta) + 'px';
            if (timer.getBoundingClientRect().width <= 0) {
                clearInterval(stop);
                board.style.background = 'red';
                audioBad.play();
                // c.textContent = x + y;
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
                timer.remove()
            }
        }, 100);
        let tries = 0;
        document.addEventListener('keydown', function(event) {
            if (event.key >= '0' && event.key <= '9') {
                c.textContent = event.key;
                if(parseInt(c.textContent) === (x + y)) {
                    clearInterval(stop);
                    board.style.background = 'green';
                    timer.remove()
                    audioGood.play();
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    tries++;
                    if (tries >= 3) {
                        clearInterval(stop);
                        board.style.background = 'red';
                        audioBad.play();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        timer.remove()
                    } else {
                        audioError.play();
                    }
                }
                console.log('Number key pressed:', event.key);
            }
        });
    })
</script>

</body>
</html>
