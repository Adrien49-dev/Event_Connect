const burgerMenuButton = document.querySelector(".burger-menu-button");
const burgerMenuButtonIcone = document.querySelector(".burger-menu-button i");
const burgerMenu = document.querySelector(".burger-menu");

burgerMenuButton.onclick = function () {
  // Bascule la classe 'open' pour afficher ou masquer le menu
  burgerMenu.classList.toggle("open");

  // Vérifie si le menu est ouvert ou fermé
  const isOpen = burgerMenu.classList.contains("open");

  // Change l'icône en fonction de l'état du menu
  if (isOpen) {
    // Menu ouvert : icône 'X'
    burgerMenuButtonIcone.classList.remove("fa-bars");
    burgerMenuButtonIcone.classList.add("fa-x");
  } else {
    // Menu fermé : icône 'bars'
    burgerMenuButtonIcone.classList.remove("fa-x");
    burgerMenuButtonIcone.classList.add("fa-bars");
  }
};
