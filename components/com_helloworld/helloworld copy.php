<?php
defined('_JEXEC') or die;
// $imgpath=;
// echo '<img src="https://picsum.photos/id/237/200/300" alt="">';
// echo "


// ";

// echo "";
// echo 'hello there';
// // Get an instance of the controller
// $controller = JControllerLegacy::getInstance('Helloworld');

// // Get the task from the request
// $input = JFactory::getApplication()->input;
// $controller->execute($input->getCmd('task'));

// // Redirect if set by the controller
// $controller->redirect();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #005288, #000);
            color: white;
        }
        .navbar {
            background-color: #333;
            padding: 0;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        #content {
            padding: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="#" onclick="loadPage('home.php')">ACCUEIL</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('societe.php')">Société</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('prestation.php')">Nos prestation</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('engagement.php')">Nos engagement</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <h1>Bienvenue sur la page d'accueil</h1>
    </div>

    <script>
        function loadPage(page) {
            fetch(page)
            .then(response => response.text())
            .then(data => {
                document.getElementById("content").innerHTML = data;
            })
            .catch(error => console.error('Error loading page:', error));
        }
    </script>

</body>
</html>




<!-- 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #005288, #000);
            color: white;
        }
        .navbar {
            background-color: #333;
            padding: 0;
        }
        .navbar-nav .nav-item {
            padding: 10px;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .login-form {
            margin-top: 10px;
        }
        .logo {
            max-width: 80px;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: end;
        }
        .form-control {
            border-radius: 5px;
            margin-right: 5px;
        }
        .login-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-3">
        <div class="d-flex justify-content-between align-items-center">

            <img src="logo.png" alt="Logo" class="logo">

            <div class="login-container">
                <input type="text" class="form-control" placeholder="Identifiant">
                <input type="password" class="form-control" placeholder="Mot de passe">
                <button class="login-btn">CONNEXION</button>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="acceil.php">acceil</a></li>
                <li class="nav-item"><a class="nav-link active" href="societe.php">Société</a></li>
                <li class="nav-item"><a class="nav-link" href="prestation.php">Nos prestation</a></li>
                <li class="nav-item"><a class="nav-link" href="engagement.php">Nos engagement</a></li>
            </ul>
        </div>
    </nav>
    <div>
        <h1>Société</h1>

        <p>
        Fondé en 2011, LEPBI Environnement c'est imposé progressivement comme un acteur privé de référence de l'analyse environnementale. 
        Leader dans le domaine analytique de l'amiante de part de son expertise, son savoir faire et sa capacité à proposer des solutions 
        adaptées aux besoins de ses clients; LEPBI Environnement est un partenaire reconnu et incontournable sur l'ensemble des problématiques
        environnementales.
        </p>
        <p>LEPBI Environnement est accrédité selon les critères fixés par le COFRAC sous le numéro 1-2350 et 
        répond aux exigences de la norme NF EN ISO/CEI 17025.</p>

        <p>LEPBI Environnement dispose d'une plateforme dédiée, garni d'équipement de dernière technologie, de techniciens et
        d'ingénieurs compétents lui permettant ainsi, d'assurer efficacement ses missions.</p>

        <p>Fort de des nombreuses années d'expérience consacrées aux activités analytiques, LEPBI Environnement est en mesure d'offrir 
        à ses client toute une panoplie de services dans le cadre d'un full service ou d'analyse spécifiques.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->
