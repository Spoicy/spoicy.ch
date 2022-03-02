<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <title>JS-Framework Projects</title>
        <meta name="description" content="Spoicy">
    
        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body class="soft-blue">
        @include('components/other/overlay')
        <div class="container jsframework-container text-center">
            <h1>JavaScript Framework Projects</h1>
            <div class="jsf-grid">
                <a class="jsf-grid-card card-white" href="/jsframework/vanilla">
                    <h2>Vanilla JavaScript</h2>
                    <p>Projects made purely with vanilla JavaScript, no frameworks in sight. JavaScript in its purest form is an important thing to have a great understanding of, as it provides fundamental knowledge for most other aspects of frontend development.</p>
                </a>
                <a class="jsf-grid-card card-blue">
                    <h2>React</h2>
                    <p>Projects made with the React framework. React is a widely used Javascript library maintained by Meta.</p>
                    <p class="font-weight-bold">No projects have been made with this so far. Check back later!</p>
                </a>
                <a class="jsf-grid-card card-dark">
                    <h2>Vue.js</h2>
                    <p>Projects made with the Vue.js framework. Vue.js is another widely used JavaScript Framework and can be integreted easily into various PHP frameworks, like Laravel (the framework this website runs on!).</p>
                    <p class="font-weight-bold">No projects have been made with this so far. Check back later!</p>
                </a>
                <a class="jsf-grid-card card-gray">
                    <h2>TypeScript</h2>
                    <p>Projects made with TypeScript. TypeScript is a programming language built on JavaScript which adds additional syntax for tighter integration and greater tooling. Typically, TypeScript is used in the Angular framework, however it can be ran anywhere JavaScript can also be ran.</p>
                    <p class="font-weight-bold">No projects have been made with this so far. Check back later!</p>
                </a>
            </div>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>