// Sélectionner le bouton pour afficher le texte
const showTextButton = document.getElementById("showTextButton");

// Sélectionner le conteneur de la citation et le bouton pour cacher le texte
const textContainer = document.getElementById("textContainer");
const hideTextButton = document.getElementById("hideTextButton");

// Fonction pour afficher la citation
showTextButton.addEventListener("click", function() {
    textContainer.style.display = "block";  // Afficher la citation
});

// Fonction pour cacher la citation
hideTextButton.addEventListener("click", function() {
    textContainer.style.display = "none";  // Cacher la citation
});
