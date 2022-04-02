<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <title>Vanilla JavaScript</title>
</head>
<body class="soft-blue">
    @include('components/other/overlay', ['nav' => 'hJSFrameworks'])
    <div class="container jsfchild-container">
        <div class="main-div">
            <h1>Vanilla JavaScript</h1>
        </div>
        <div class="row">
            <div class="project col-md-6" style="--order: 0">
                <div class="calc-container">
                    <h2>Calculator</h2>
                    <input type="text" class="calc-display form-control mb-4" name="cDisplay" id="cDisplay" readonly>
                    <div class="calc-grid" id="cButtonGrid">
                        <button type="button" class="calc-button-op btn" value="^">x<sup>y</sup></button>
                        <button type="button" class="calc-button-op btn" value="(">(</button>
                        <button type="button" class="calc-button-op btn" value=")">)</button>
                        <button type="button" class="calc-button-op btn" id="bAC" value="AC">AC</button>
                        <button type="button" class="calc-button-num btn" value="7">7</button>
                        <button type="button" class="calc-button-num btn" value="8">8</button>
                        <button type="button" class="calc-button-num btn" value="9">9</button>
                        <button type="button" class="calc-button-op btn" value="÷">÷</button>
                        <button type="button" class="calc-button-num btn" value="4">4</button>
                        <button type="button" class="calc-button-num btn" value="5">5</button>
                        <button type="button" class="calc-button-num btn" value="6">6</button>
                        <button type="button" class="calc-button-op btn" value="×">×</button>
                        <button type="button" class="calc-button-num btn" value="1">1</button>
                        <button type="button" class="calc-button-num btn" value="2">2</button>
                        <button type="button" class="calc-button-num btn" value="3">3</button>
                        <button type="button" class="calc-button-op btn" value="-">-</button>
                        <button type="button" class="calc-button-num btn" value="0">0</button>
                        <button type="button" class="calc-button-num btn" value=".">.</button>
                        <button type="button" class="calc-button-equal btn btn-primary" value="=">=</button>
                        <button type="button" class="calc-button-op btn" value="+">+</button>
                    </div>
                </div>
            </div>
            <div class="project col-md-6" style="--order: 1">
                <div class="unitconvert-container">
                    <h2>Unit Converter</h2>
                </div>
                <p class="text-center">Unit Converter is currently WIP.</p>
            </div>
        </div>
    </div>
    <script src="../js/vanilla.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>