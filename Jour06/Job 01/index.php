<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaPlateforme_</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LPTF</a>
            <div class="navbar-nav">
                <a class="nav-link" href="#">Accueil</a>
                <a class="nav-link" href="#">Units</a>
                <a class="nav-link" href="#">Jobs</a>
                <a class="nav-link" href="#">Skills</a>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
        <h1 class="text-center mb-4">LaPlateforme_</h1>
        <div class="row">
            <!-- Colonne gauche -->
            <div class="col-md-3">
                <div class="card">
                    <img src="papillon.png" class="card-img-top" alt="Un Papillon">
                    <div class="card-body">
                        <h5 class="card-title">Un Papillon</h5>
                        <p class="card-text">Un papillon, c'est un peu comme une chenille, mais avec des ailes. Ne pas ignorer.</p>
                        <a href="#" class="btn btn-primary">Commander votre propre papillon</a>
                    </div>
                </div>
            </div>

            <!-- Contenu central -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Bonjour, monde!</h2>
                        <p>Il existe plusieurs visions du terme :</p>
                        <ul>
                            <li>Le monde est la matière, l'espace et les phénomènes qui nous sont accessibles par les sens, l'expérience ou la raison.</li>
                            <li>Le sens le plus courant désigne notre planète, la Terre, avec ses habitants et son environnement plus ou moins naturel.</li>
                            <li>Le sens étendu désigne l'univers dans son ensemble.</li>
                        </ul>
                        <button class="btn btn-danger">Rebooter le Monde</button>
                        <div class="pagination mt-3">
                            <button class="btn btn-outline-primary">&lt;</button>
                            <button class="btn btn-primary">1</button>
                            <button class="btn btn-outline-primary">2</button>
                            <button class="btn btn-outline-primary">3</button>
                            <button class="btn btn-outline-primary">&gt;</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite -->
            <div class="col-md-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active">Limbes</li>
                        <li class="list-group-item">Luxure</li>
                        <li class="list-group-item">Gourmandise</li>
                        <li class="list-group-item">Avarice</li>
                        <li class="list-group-item">Colère</li>
                        <li class="list-group-item">Hérésie</li>
                        <li class="list-group-item">Violence</li>
                        <li class="list-group-item">Ruse et Tromperie</li>
                        <li class="list-group-item">Trahison</li>
                        <li class="list-group-item">Internet Explorer</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Installation de AI 9000 -->
        <div class="mt-4">
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">Installation de AI 9000</small>
        </div>

        <!-- Formulaire -->
        <div class="card mt-4">
            <div class="card-body">
                <h2>Recevez votre copie gratuite d'internet 2!</h2>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de Passe</label>
                                <input type="password" class="form-control" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="dogecoin" class="form-label">DogeCoin</label>
                                <input type="number" class="form-control" id="dogecoin" placeholder="00">
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL des Internets 2 et 2.1 Beta</label>
                                <input type="url" class="form-control" id="url" placeholder="https://l33t.lptf.gg/v2/beta">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="password2" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password2">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkMeOut">
                                <label class="form-check-label" for="checkMeOut">Check me out</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>