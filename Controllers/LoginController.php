<?php
require_once '../Controllers/Controller.php';
require_once '../Entities/Utilisateur.php';
require_once '../Models/UtilisateurModels.php';

class LoginController extends Controller
{
    public function connexionAction()
    {
        // Vérification si la méthode est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification des données POST
            if (isset($_POST['mail'], $_POST['mdp'])) {
                $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
                $mdp = htmlspecialchars($_POST['mdp'], ENT_QUOTES, 'UTF-8');

                if (!$mail) {
                    echo "<p>Adresse email invalide.</p>";
                    return;
                }

                $UtilisateurModels = new UtilisateurModels();
                $userObject = $UtilisateurModels->findUtilisateur($mail);

                // Si l'utilisateur existe
                if ($userObject) {
                    // On hydrate l'objet Utilisateur
                    $user = new Utilisateur();
                    $user->setId_user($userObject->id_user);
                    $user->setPrenom($userObject->prenom);
                    $user->setNom($userObject->nom);
                    $user->setMail($userObject->mail);
                    $user->setMdp($userObject->mdp);
                    $user->setStatut($userObject->statut);

                    // var_dump($user);
                    // die;

                    // Vérification du mot de passe saisi
                    if ($mdp == $user->getMdp()) {
                        //if (password_verify($mdp, $user->getMdp())) {
                        // Création de la session
                        $_SESSION['nom'] = $user->getNom();
                        $_SESSION['prenom'] = $user->getPrenom();
                        $_SESSION['id_user'] = $user->getId_user();
                        $_SESSION['statut'] = $user->getStatut();
                        setcookie("mail", $user->getMail(), time() + 3600, "/");

                        if ($_SESSION['statut'] == "visiteur") {
?>
                            <meta http-equiv="refresh" content="0;index.php?controller=Accueil&action=home">
                        <?php
                            //header("Location: index.php?controller=Accueil&action=home");
                            exit();
                        } else
                        ?>
                        <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=dashboard">
        <?php

                    //header("Location: index.php?controller=Admin&action=dashboard");
                } else {
                    echo "<p>Mot de passe incorrect.</p>";
                }
            } else {
                echo "<p>Utilisateur introuvable.</p>";
            }
        } else {
            echo "<p>Veuillez remplir tous les champs.</p>";
        }
    }

    // Rendu du formulaire si la méthode n'est pas POST ou si l'authentification a échoué
    $this->render('login');
}

public function deconnexionAction()
{



    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();
        ?>
        <meta http-equiv="refresh" content="0;index.php?controller=Accueil&action=home">
        <?php


        // Rediriger vers la page de connexion
        //header("Location: index.php?controller=Accueil&action=home");
        exit();
    }



    public function inscriptionAction()
    {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données envoyées par le formulaire
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
            $mdp = $_POST['mdp'];
            $statut = 'visiteur';  // Le statut est toujours "visiteur" par défaut

            // Validation des données
            if (!$nom || !$prenom || !$mail || !$mdp) {
                // Si l'un des champs est vide
                echo "<p>Veuillez remplir tous les champs.</p>";
                return;
            }

            if (!$mail) {
                // Si l'email est invalide
                echo "<p>L'email est invalide.</p>";
                return;
            }

            // Hashage du mot de passe pour sécuriser l'enregistrement
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);;
            $UtilisateurModels = new UtilisateurModels();

            // Vérification si l'email est déjà utilisé
            if ($UtilisateurModels->findUtilisateur($mail)) {
                echo "<p>Un utilisateur avec cet email existe déjà.</p>";
                return;
            }

            // Création du nouvel utilisateur dans la base de données
            $UtilisateurModels->createUtilisateur($nom, $prenom, $mail, $mdp, $statut);
        ?>
            <meta http-equiv="refresh" content="0;index.php?controller=Login&action=connexion">
<?php




            //header("Location: index.php?controller=Login&action=connexion");
            exit();
        } else {
            // Si la méthode n'est pas POST, afficher le formulaire d'inscription
            $this->render('register');
        }
    }
}
