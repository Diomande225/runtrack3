<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Scroll</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Votre contenu ici -->
    <footer id="footer">
        Footer est juste en bas de page je peux l'ameliorer a tout moment 
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var scrollPercent = (scrollTop / docHeight) * 100;
            
            var footer = document.getElementById("footer");
            var hue = (scrollPercent * 1.2) % 360; // Couleur changeante en fonction du pourcentage de défilement
            
            footer.style.backgroundColor = `hsl(${hue}, 70%, 50%)`;
        });
    </script>

</body>
</html>
