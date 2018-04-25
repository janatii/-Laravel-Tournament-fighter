<?php

return [
    'global' => [
        'exceptions' => [
            'user-locked' => 'Votre compte est verrouillé !',
            'too-many-requests' => 'Vous avez fait trop de tentatives !',
            'unauthenticated' => 'Vous n’êtes pas authentifié !',
            '403-title' => 'Accès refusé !',
            '403' => 'Accès refusé ! Que faites-vous là ?',
            '404-title' => 'Page introuvable !',
            '404' => 'Page introuvable ! Etes-vous perdu ?',
            '429-title' => 'Trop de tentatives...',
            '429' => 'Trop de tentatives... Réessayez plus tard.',
            '503-title' => 'On revient tout de suite.',
            '503' => 'On revient tout de suite.',
        ],
        'emails' => [
            'regards' => 'Cordialement',
            'help' => 'Si vous n’arrivez pas à cliquer sur le bouton ":actionText", copier/coller l’URL suivante dans votre navigateur: [:actionUrl](:actionUrl)',
            'confirmation-email' => [
                'title' => 'Votre email a été modifié',
                'greeting' => 'Notification',
                'button' => 'Cliquez ici pour confirmer votre email',
                'outro' => 'Merci d’utiliser Tournament Fighters !',
            ],
            'welcome' => [
                'title' => 'Bienvenue sur Tournament Fighters !',
                'greeting' => 'Bonjour,',
                'text' => 'Nous sommes heureux de vous compter parmi nos membres.',
                'button' => 'Cliquez ici pour confirmer votre email',
                'outro' => 'Merci de nous avoir rejoint et amusez-vous bien !',
            ],
        ],
        'notifications' => [
            'welcome' => [
                'title' => 'Bienvenue sur Tournament Fighters !',
                'text' => 'Nous sommes heureux de vous compter parmi nos membres ! Nous venons de vous envoyer un email contenant un lien de confirmation de votre adresse email.',
            ],
        ],
        'generic-texts' => [
            'yes' => 'Oui',
            'no' => 'Non',
            'show' => 'Voir',
            'add' => 'Ajouter',
            'save' => 'Sauvegarder',
            'edit' => 'Editer',
            'delete' => 'Supprimer',
            'remove' => 'Supprimer',
            'back' => 'Retour',
            'abort' => 'Annuler',
            'toggle-nav' => 'Montrer/Cacher la navigation',
            'actions' => 'Actions',
            'publish' => 'Publier',
            'unpublish' => 'Dépublier',
            'example' => 'Exemple',
            'required' => 'obligatoire',
            'confirm' => 'Confirmer',
            'locked' => 'Verrouillé',
            'lock' => 'Verrouiller',
            'unlock' => 'Déverrouiller',
            'current' => 'Actuellement',
            'confirmed' => 'confirmé',
            'not-confirmed' => 'non confirmé',
            'see-more' => 'Voir plus +',
            'male' => 'Homme',
            'female' => 'Femme',
            'male-funny' => 'Gamer',
            'female-funny' => 'Gameuse',
            'oops' => 'Oups !',
            'ok' => 'OK',
            'online' => 'En ligne',
            'offline' => 'Hors ligne',
            'logo' => 'logo',
            'avatar' => 'avatar',
            'error-occured' => 'Une erreur est survenue.',
            'errors-occured' => 'Des erreurs sont survenues.',
            'all-rights-reserved' => 'Tous droits réservés.',
            'maps' => 'Maps',
            'map' => 'Map',
            'gamemodes' => 'Modes de jeu',
            'player' => 'Joueur',
            'manager' => 'Manager',
            'friendly' => 'Amical',
            'ranked' => 'Classé',
            'wager' => 'Wager',
            'free' => 'Gratuit',
            'classic' => 'Classic',
            'with-team' => 'avec l’équipe',
            'players' => 'Joueurs',
            'confirm-play' => 'A confirmé',
            'not-confirm-play' => 'N’a pas confirmé',
            'match-in-progress' => 'Match en cours',
            'round' => 'Round',
            'mode' => 'Mode',
            'i-win' => 'J’ai gagné !',
            'i-lost' => 'J’ai perdu !',
            'rules' => 'Règles',
            'winner' => 'Vainqueur',
            'loser' => '',
            'wait-referee' => 'En attente d’un arbitre',
            'wait-results' => 'En attente des résultats du manager',
            'coming-soon' => 'Bientôt',
            'closed' => 'fermé',
            'see' => 'Voir',
            'link' => 'Lien',
            'send' => 'Envoyer',
            'match-end' => 'Match End !',
        ],
        'forms-fields' => [
            'gender' => 'Sexe',
            'email' => 'Email',
            'repeat-email' => 'Répéter l’email',
            'avatar' => 'Avatar',
            'name' => 'Nom',
            'username' => 'Pseudo',
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'birthdate' => 'Date de naissance',
            'language' => 'Langue',
            'password' => 'Mot de passe',
            'repeat-password' => 'Répéter le mot de passe',
            'subdomain' => 'Sous-domaine',
            'order' => 'Ordre',
            'banner' => 'Bannière',
            'logo' => 'Logo',
            'menu-logo' => 'Logo du menu',
            'logo-list-trainings' => 'Logo Liste Trainings',
            'platform' => 'Platforme',
            'roles' => 'Rôles',
            'images-formats-help' => 'Seulement des images au format PNG ou JPG',
            'username-help' => 'Peut contenir des lettres, des chiffres et des tirets',
            'team-name' => 'Nom d’équipe',
            'max-players-per-team' => 'Nb max joueurs par équipe',
            'max-teams-per-player' => 'Nb max équipes par joueur',
            'max-teams-per-player-premium' => 'Nb max équipes par joueur premium',
            'title' => 'Titre',
            'url' => 'URL',
            'content' => 'Contenu',
            'visible-in-menu' => 'Visible dans le menu',
            'gamemodes' => 'Modes de jeu',
            'bo-list' => 'Liste des BO',
            'vs-list' => 'Liste des VS',
            'classic-modes-list' => 'Liste des modes en classique',
            'abbrev' => 'Abréviation',
            'credits' => 'Crédits',
            'rules' => 'Règles',
            'network' => 'Network',
            'time_per_round' => 'Temps Par Round (Minutes)',
            'id' => 'ID',
            'team1' => 'Team 1',
            'team2' => 'Team 2',
        ],
    ],
    'auth' => [
        'reset-password-title' => 'Réinitialisation du mot de passe',
        'confirm-you-are-not-a-robot' => 'Confirmez que vous n’êtes pas un robot',
        'send-reset-link' => 'Envoyer le lien',
        'reset-password-button' => 'Réinitialiser le mot de passe',

        'login-title' => 'Login',
        'forgot-password' => 'Mot de passe oublié ?',
        'remember-me' => 'Se souvenir de moi',
        'login-button' => 'Login',

        'register-title' => 'Inscription',
        'register-button' => 'S’enregistrer',
    ],
    'admin' => [
        'title' => 'Administration',
        'menu' => [
            'users' => 'Utilisateurs',
            'games' => 'Jeux',
            'networks' => 'Réseaux',
            'platforms' => 'Platformes',
            'pages' => 'Pages',
            'referee' => 'Arbitrages',
            'wallet' => 'Portefeuille',
        ],
        'user-menu' => [
            'front' => 'Front',
            'profile' => 'Profil',
            'parameters' => 'Paramètres',
            'logout' => 'Déconnexion',
        ],
        'dashboard' => [
            'title' => 'Accueil',
            'description' => 'Vous êtes sur l’espace d’administration',
        ],
        'games' => [
            // Controllers
            'created' => 'Jeu créé',
            'updated' => 'Jeu sauvegardé',
            'deleted' => 'Jeu supprimé',
            'published' => 'Jeu publié',
            'unpublished' => 'Jeu dépublié',

            // Views
            'list-title' => 'Jeux',
            'no-games' => 'Aucun jeu',
            'add-title' => 'Ajouter un jeu',
            'edit-title' => 'Edition du jeu :name',
            'confirm-delete' => 'Voulez-vous vraiment supprimer le jeu <b>:name</b> ?',
            'confirm-publish' => 'Voulez-vous vraiment publier le jeu <b>:name</b> ?',
            'confirm-unpublish' => 'Voulez-vous vraiment dépublier le jeu <b>:name</b> ?',
        ],
        'maps' => [
            // Controllers
            'created' => 'Carte créée',
            'updated' => 'Carte sauvegardée',
            'deleted' => 'Carte supprimée',
        
            // Views
            'list-title' => 'Cartes',
            'no-maps' => 'Aucune carte',
            'add-title' => 'Ajouter une carte',
            'edit-title' => 'Edition de la carte :name',
            'confirm-delete' => 'Voulez-vous vraiment supprimer la carte <b>:name</b> ?',
        ],
        'gamemodes' => [
            // Controllers
            'created' => 'Mode de jeu créé',
            'updated' => 'Mode de jeu sauvegardé',
            'deleted' => 'Mode de jeu supprimé',
        
            // Views
            'list-title' => 'Modes de jeu',
            'no-gamemodes' => 'Aucun mode de jeu',
            'add-title' => 'Ajouter un mode de jeu',
            'edit-title' => 'Edition du mode de jeu :name',
            'confirm-delete' => 'Voulez-vous vraiment supprimer le mode de jeu <b>:name</b> ?',
        ],
        'networks' => [
            // Controllers
            'created' => 'Réseau créé',
            'updated' => 'Réseau sauvegardé',
            'deleted' => 'Réseau supprimé',

            // Views
            'list-title' => 'Réseaux',
            'no-networks' => 'Aucun réseau',
            'add-title' => 'Ajouter un nouveau réseau',
            'edit-title' => 'Edition du réseau :name',
            'confirm-delete' => 'Voulez-vous vraiment supprimer le réseau <b>:name</b> ?',
        ],
        'platforms' => [
            // Controllers
            'created' => 'Platforme créée',
            'updated' => 'Platforme sauvegardée',
            'deleted' => 'Platforme supprimée',

            // Views
            'list-title' => 'Platformes',
            'no-platforms' => 'Aucune platforme',
            'add-title' => 'Ajouter une platforme',
            'edit-title' => 'Edition de la platforme :name',
            'confirm-delete' => 'Voulez-vous vraiment supprimer la plateforme <b>:name</b> ?',
        ],
        'pages' => [
            // Controllers
            'created' => 'Page créée',
            'updated' => 'Page sauvegardée',
            'deleted' => 'Page supprimée',

            // Views
            'list-title' => 'Pages',
            'no-pages' => 'Aucune page',
            'add-title' => 'Ajouter une page',
            'edit-title' => 'Edition de la page :title',
            'confirm-delete' => 'Voulez-vous vraiment supprimer la page <b>:title</b> ?',
        ],
        'users' => [
            // Controllers
            'created' => 'Utilisateur créé',
            'updated' => 'Utilisateur sauvegardé',
            'deleted' => 'Utilisateur supprimé',
            'locked' => 'Utilisateur verrouillé',
            'confirmation-email-sent' => 'Email de confirmation envoyé',
            'email-already-confirmed' => 'Adresse email déjà confirmée',
            'avatar-deleted' => 'Avatar supprimé',

            // Views
            'list-title' => 'Utilisateurs',
            'no-users' => 'Aucune utilisateur',
            'list-filters-labels' => [
                'all' => 'Tous',
                'staff' => 'Staff',
                'users' => 'Joueurs',
                'locked' => 'Verrouillés',
                'unlocked' => 'Déverrouillés',
            ],
            'add-title' => 'Ajouter un utilisateur',
            'edit-title' => 'Edition de l’utilisateur :username',
            'show-title' => 'Utilisateur :username',
            'email-not-confirmed' => 'Email non confirmé',
            'send-confirmation-email' => 'Envoyer un email de confirmation',
            'confirm-delete-user' => 'Voulez-vous vraiment supprimer l’utilisateur <b>:username</b> ?',
            'confirm-lock-user' => 'Voulez-vous vraiment verrouiller l’utilisateur <b>:username</b> ?',
            'confirm-unlock-user' => 'Voulez-vous vraiment déverrouiller l’utilisateur <b>:username</b> ?',
            'confirm-remove-avatar' => 'Voulez-vous vraiment supprimer l’avatar ?',
        ],
        'referee' => [
            'list-title' => 'Arbitrages nécessaires',
            'no-match' => 'Aucun match',
        ],
        'wallet' => [
            'list-title' => 'Demandes d’argent',
            'no-ask' => 'Aucune demande',
            'credits' => 'Crédits demandés',
            'infos' => 'Infos Utilisateur',
            'date' => 'Date de demande',
            'mark-done' => 'Supprimer',
            'request-done' => 'Demande traitée !',
            'paypal-or-bank' => 'Paypal/RIB',
        ],
    ],
    'front' => [
        'main-menu' => [
            'trainings' => 'Training',
            'tournaments' => 'Tournoi',
            'my-profile' => 'Mon Profil',
            'my-teams' => 'Mes Teams',
            'ranking' => 'Classement',
            'forum' => 'Forum',
            'shop' => 'Boutique',
            'lives' => 'Live',
            'change-active-team' => 'Changer d’équipe active',
            'no-game-selected' => 'Aucun jeu sélectionné',
            'select-your-game' => 'Choisis ton jeu',
        ],

        'user-menu' => [
            'deposit-money' => 'Déposer de l’argent',
            'elo-ranking' => 'Classement ELO',
            'match-in-progress' => 'Match en cours',
            'match-wait-confirm' => 'Wager en attente de votre confirmation',
            'change-active-team' => 'Changer d’équipe active',
            'notifications' => 'Notifications',

            'my-profile' => 'Mon Profil',
            'my-teams' => 'Mes Teams',
            'my-stats' => 'Mes Statistiques',
            'my-safe' => 'Mon Portefeuille',
            'become-premium' => 'Devenir Premium !',
            'parameters' => 'Paramètres',
            'logout' => 'Se déconnecter',

            'register' => 'S’inscrire',
            'login' => 'Se connecter',
        ],
        
        'wallet' => [
            'title' => 'Mon Portefeuille',
            'credits' => 'Combien de crédits voulez-vous échanger ?',
            'paypal-or-rib' => 'Indiquez une adresse Paypal ou un RIB (Nom, Prénom, IBAN et BIC)',
            'send' => 'Envoyer la demande',
            'sended' => 'Demande envoyée !',
            'ask-already-exists' => 'Vous avez déjà réalisé une demande de crédits. Veuillez patienter avant d’en faire une autre.',
            'exchange-for' => 'Valeur des crédits :',
        ],

        'parameters' => [
            // Controllers
            'confirmation-email-sent' => 'Email de confirmation envoyé',
            'email-already-confirmed' => 'Adresse email déjà confirmée',
            'email-changed' => 'Adresse email modifiée',
            'nothing-changed' => 'Rien n’a changé',
            'email-confirmed' => 'Adresse email confirmée',
            'unable-to-confirm-email' => 'Impossible de confirmer cette adresse',
            'updated' => 'Paramètres enregistrés',
            'password-changed' => 'Mot de passe modifié',
            'become-premium-to-change-username' => 'Devenez Premium pour changer de pseudo !',

            // Views
            'menu' => [
                'general' => 'Général',
                'email' => 'Email',
                'password' => 'Mot de passe',
            ],

            'layout' => [

            ],

            'index' => [
                'title' => 'Général',
            ],

            'change-email' => [
                'title' => 'Changement d’adresse email',
                'email-not-confirmed' => 'Email non confirmé',
                'send-confirmation-email' => 'Renvoyez moi un email de confirmation',
                'confirm-password' => 'Confirmez avec votre mot de passe',
            ],

            'change-password' => [
                'title' => 'Changement de mot de passe',
                'confirm-password' => 'Votre mot de passe actuel',
                'new-password' => 'Nouveau mot de passe',
                'repeat-new-password' => 'Répétez le nouveau mot de passe',
            ],
        ],
    
        'home' => [
            'modals' => [
                'select-game' => [
                    'title' => 'Sélectionnez d’abord un jeu !',
                ],
            ],
        ],
        
        'shop' => [
            'menu' => [
                'premium' => 'Premium',
                'credits' => 'Crédits',
            ],
            
            'errors' => [
                'its-already-your-plan' => 'Vous avez déjà souscrit à cette formule',
                'you-cant-change-for-monthly' => 'Vous ne pouvez pas choisir la formule mensuelle. Vous devez attendre la fin de votre abonnement annuel.',
                'you-cant-change-before-end' => 'Vous devez attendre la fin de votre abonnement annuel pour changer de formule.',
            ],
            
            'texts' => [
                'nbcredits-added' => ':nbcredits crédits ont été ajoutés à votre compte !',
                'buy-for' => 'Acheter pour :price',
                'premium-subscribed' => 'Vous êtes maintenant un membre Premium !',
                'premium-modified' => 'Vous avez changé de formule !',
                'premium-cancelled' => 'Votre abonnement ne sera plus renouvelé !',
                'premium-resumed' => 'Votre abonnement sera renouvelé !',
                'per-month' => '/mois',
                'per-year' => '/an',
                'subscribe' => 'S’abonner',
                'actual-plan' => 'Votre formule actuelle',
                'actual-subscription' => 'Votre abonnement',
                'until' => 'Jusqu’au',
                'cancel-subscription' => 'Arrêter mon abonnement',
                'resume-subscription' => 'Reprendre mon abonnement',
            ],
            
            'premium' => [
                'title' => 'Premium',
                
                'description' => 'Obtiens le Premium sur TournamentFighters et découvre des avantages exclusifs :<br>- Remporte 100% de ta mise lors d’un match Wager<br>- Créer un nombre illimité d’équipes<br>- Mets en avant tes Trainings<br>- Change ton pseudo à volonté',
                
                'plans' => [
                    'monthly' => 'Abonnement Mensuel',
                    'yearly' => 'Abonnement Annuel',
                ],
            ],
            
            'credits' => [
                'title' => 'Crédits',
                
                'description' => 'Les Crédits TNF te permettent de participer aux matchs Wagers.<br>Ils peuvent à tout moment être convertis en argent réel dans ton portefeuille.',
                
                'offers' => [
                    '200-credits' => '200 crédits',
                    '500-credits' => '500 crédits',
                    '1000-credits' => '1000 crédits',
                    '2000-credits' => '2000 crédits',
                    '5000-credits' => '5000 crédits',
                ],
            ],
        ],
        
        'trainings' => [
            'list' => [
                'component' => [
                    'title' => 'Trainings',
                    'no-trainings' => 'Aucun match n’est disponible',
                    'no-trainings-filters' => 'Aucun match ne correspond aux filtres',
                    'rank' => 'Classement',
                    'join-match' => 'Participer',
                    'abort-match' => 'Annuler',
                    'my-team-match' => 'Mon équipe',
                    'match-premium' => 'Training Premium',
                    'FRIENDLY' => 'Amical',
                    'RANKED' => 'Classé',
                    'WAGER' => 'Wager',
                    
                    'cols' => [
                        'game' => 'Jeu',
                        'team' => 'Team',
                        'rank' => 'Classement',
                        'rule' => 'Règle',
                        'mode' => 'Mode',
                        'bo' => 'BO',
                        'vs' => 'Joueurs',
                        'style' => 'Style',
                        'join' => 'Participer',
                        'details' => 'Détails',
                    ],
                ],
                
                'modals' => [
                    'errors' => [
                        'wrong-mode-map' => 'La carte :map n’est pas disponible dans le mode :mode',
                        'players-invalid' => 'Vérifier que tous les joueurs soient sélectionnés et ne soient pas en double',
                        'maps-invalid' => 'Vérifier que toutes les cartes soient sélectionnés et ne soient pas en double',
                        'score-invalid' => 'Le score de votre équipe ne vous autorise pas à jouer ce match',
                        'players-have-match-in-progress' => 'Les joueurs suivants sont déjà dans une partie : :usernames',
                        'player-not-enough-credits' => 'Le joueur :username n’a pas assez de crédits',
                        'players-active-team-is-not-your-team' => 'Les joueurs suivants ont sélectionné une autre équipe active : :usernames',
                        'already-in-progress' => 'Le match a déjà commencé !',
                        'you-have-to-participate' => 'Vous devez être joueur ou manager !',
                        'players-have-no-network-id' => 'Les joueurs suivants n’ont pas d’identifiant pour ce jeu (PSN ID etc) : :usernames',
                    ],
                    
                    'errors-modals' => [
                        'no-active-team' => [
                            'message' => 'Vous devez choisir une équipe pour jouer !',
                        ],
                        
                        'wrong-game-active-team' => [
                            'message' => 'Vous devez choisir une équipe jouant à ce jeu !',
                        ],
                        
                        'match-in-progress' => [
                            'message' => 'Vous avez déjà un match en cours !',
                        ],
                    ],
                    
                    'create-training' => [
                        'open-buttons' => [
                            'create-wager' => 'Créer un wager',
                            'create-training' => 'Créer un training',
                        ],
                        
                        'training' => [
                            'title' => 'Créer un training',
                            
                            'rule' => 'Règle',
                            'bestof' => 'Best Of',
                            'mode' => 'Mode',
                            'maps' => 'Maps',
                            'vs' => 'VS',
                            'manager' => 'Manager',
                            'players' => 'Joueurs',
                            'rank' => 'Classement',
                            
                            'btn-create' => 'Créer ce training',
                        ],
                        
                        'wager' => [
                            'title' => 'Créer un wager',
                        
                            'bestof' => 'Best Of',
                            'mode' => 'Mode',
                            'vs' => 'VS',
                            'manager' => 'Manager',
                            'players' => 'Joueurs',
                            'bet' => 'Chaque joueur pari',
                            
                            'btn-create' => 'Créer ce wager',
                        ],
                    ],
                    
                    'join-training' => [
                        'open-buttons' => [
                            'join' => 'Rejoindre',
                        ],
                        
                        'training' => [
                            'title' => 'Rejoindre un training',
                        
                            'manager' => 'Manager',
                            'players' => 'Joueurs',
                            
                            'btn-join' => 'Rejoindre ce training',
                        ],
                        
                        'wager' => [
                            'title' => 'Rejoindre un wager',
                        
                            'manager' => 'Manager',
                            'players' => 'Joueurs',
                            
                            'btn-join' => 'Rejoindre ce wager',
                        ],
                    ],
                    
                    'abort-match' => [
                        'title' => 'Annuler ce Training ?',
                        
                        'btn-not-abort' => 'Conserver le training',
                        'btn-abort' => 'Annuler le training',
                    ],
                ],
            ],
            
            'show' => [
                'error-wait-join' => 'Match en attente d’une seconde équipe !',
                'error-aborted' => 'Ce match a été annulé !',
                'confirm-your-participation' => 'Confirmez votre participation au WAGER',
                'deny-particpation' => 'Refuser de participer',
                'accept-participation' => 'Accepter pour :bet',
                'match-cancellation' => 'Annulation du match',
                'continue-match' => 'Continuer match',
                'cancel-match' => 'Annuler le match',
                'you-asked-cancel-wait-other-manager' => 'Vous avez demandé l’annulation du match.<br>En attente de réponse du manager de l’équipe adverse...',
                'other-team-want-cancel-what-do-you-want' => 'L’équipe adverse veut annuler le match. Que souhaitez-vous faire ?',
                'your-manager-asked-cancellation' => 'Votre manager a demandé l’annulation du match!',
                'other-manager-asked-cancellation' => 'Le manager de l’équipe adverse a demandé l’annulation du match!',
                'user-cancelled-match' => ':username a annulé le match !',
                'user-deny-to-cancel-match' => ':username a refusé d’annuler le match !',
                'rounds-details' => 'Détails des rounds',
                'this-round-will-be-unlocked-in' => 'Ce round sera débloqué dans',
                'become-premium' => 'Devenez Premium !',
                'become-premium-to-win-more' => 'Devenez premium pour remporter 100% des gains',
                'to-win' => 'à gagner',
                'training-details-title' => 'Training',
                'see-rules-and-details' => 'Voir les détails &amp; règles du match',
                'ask-to-cancel' => 'Demander à l‘adversaire d‘annuler ce match',
                'referee-was-called' => 'Un arbitre a été appelé !',
                'call-referee' => 'Appeler un arbitre',
                'error-chat-match-closed' => 'Ce chat est fermé !',
                'team-won-match' => 'L‘équipe :team a gagné !',
            ],
        ],
        
        'profile' => [
            // Controllers
            'updated' => 'Profil enregistré',
            'error-too-many-teams' => 'Vous ne pouvez pas avoir plus de :limit équipes !',

            // Views
            'layout' => [
                'menu' => [
                    'home' => 'Accueil',
                    'teams' => 'Teams',
                    'last-matchs' => 'Matchs Récents',
                    'statistiques' => 'Statistiques',
                ],
                'change' => 'Modifier',
                'click-to-change-banner' => 'Cliquez pour changer de bannière',
                'click-to-change-avatar' => 'Cliquez pour<br>changer d’avatar',
                'years-old' => 'ans',
                'member-since' => 'Inscrit le',
                'see-my-website' => 'Voir mon site',
                'tweets-by' => 'Tweets de',
                'description-placeholder' => 'Une courte description',
                'invite-player' => 'Inviter',
                'accept-candidate' => 'Accepter Candidat',
                'deny-candidate' => 'Refuser Candidat',
            ],

            'index' => [
                'matchs-played' => 'Matchs joués',
                'matchs-won' => 'Matchs gagnés',
                'matchs-lost' => 'Matchs perdus',
            ],

            'teams' => [
                'title' => 'Teams',
                'title_candidatures' => 'Candidatures',
                'title_invites' => 'Invitations',
                'create-team' => 'Créer une équipe',
                'activate-team' => 'Activer cette équipe',
                'current-team' => 'Equipe active',
                'text-no-teams' => 'Vous n’êtes membre d’aucune équipe pour le moment.',
    
                'modals' => [
                    'create-team' => [
                        'title' => 'Nom d’équipe',
                        'help' => 'Peut contenir des lettres, des chiffres, des tirets et des espaces',
                        'button' => 'Créer',
                    ],
                ],
            ],
        ],
    
        'team' => [
            // Controllers
            'updated' => 'Team enregistrée',
        
            // Views
            'layout' => [
                'menu' => [
                    'home' => 'Accueil',
                    'members' => 'Membres',
                    'last-matchs' => 'Matchs Récents',
                    'statistiques' => 'Statistiques',
                ],
                'change' => 'Modifier',
                'join' => 'Rejoindre',
                'leave' => 'Quitter',
                'accept-invite' => 'Accepter l’invitation',
                'decline-invite' => 'Décliner l’invitation',
                'abort-candidate' => 'Annuler ma candidature',
                'you-are-ban' => 'Vous avez été blacklisté par cette équipe !',
                'click-to-change-banner' => 'Cliquez pour changer de bannière',
                'click-to-change-avatar' => 'Cliquez pour<br>changer d’avatar',
                'see-my-website' => 'Voir notre site',
                'tweets-by' => 'Tweets de',
                'name-placeholder' => 'Nom de Team',
                'description-placeholder' => 'Une courte description',
                'sure-to-leave-question' => 'Voulez-vous vraiment quitter l’équipe :name ?',
            ],
        
            'index' => [
                'matchs-played' => 'Matchs joués',
                'matchs-won' => 'Matchs gagnés',
                'matchs-lost' => 'Matchs perdus',
            ],
        
            'members' => [
                'title' => 'Membres',
                'title_candidatures' => 'Candidats',
                'title_invites' => 'Invitations',
                'title_bans' => 'Bannis',
    
                'text-no-invites' => 'Il n’y a aucun invité dans cette équipe actuellement.',
                'text-no-members' => 'Il n’y a aucun joueur dans cette équipe actuellement.',
                'text-no-candidates' => 'Il n’y a aucune candidature pour cette équipe actuellement.',
                'text-no-bans' => 'Il n’y a aucun ban dans cette équipe actuellement.',
    
                'invite' => 'Inviter',
                'accept-candidate' => 'Accepter',
                'deny-candidate' => 'Refuser',
                'promote-manager' => 'Promouvoir',
                'promote-player' => 'Rétrograder',
                'remove-player' => 'Retirer',
                'remove-invite' => 'Annuler',
                'ban' => 'Bannir',
                'unban' => 'Débannir',
    
                'confirm-remove' => 'Voulez-vous vraiment retirer le membre <b>:username</b> ?',
                'confirm-ban' => 'Voulez-vous vraiment bannir le membre <b>:username</b> ?',
                'confirm-unban' => 'Voulez-vous vraiment débannir le membre <b>:username</b> ?',
                'confirm-deny' => 'Voulez-vous vraiment refuser le membre <b>:username</b> ?',
                'confirm-accept' => 'Voulez-vous vraiment accepter le membre <b>:username</b> ?',
                'confirm-remove-invite' => 'Voulez-vous vraiment annuler l’invitation de <b>:username</b> ?',
    
                'modals' => [
                    'invite-player' => [
                        'title' => 'Inviter un joueur',
                        'button' => 'Inviter',
                        'errors' => [
                            'user-dont-exists' => 'Joueur introuvable !',
                            'user-already-invited' => 'Joueur déjà invité !',
                            'user-already-member' => 'Joueur déjà membre !',
                        ],
                    ],
                ],
            ],
        ],

        'search' => [
            'input-placeholder' => 'Rechercher...',
            'teams-title' => 'Equipes',
            'players-title' => 'Joueurs',
            'no-teams' => 'Aucune équipe trouvée !',
            'no-players' => 'Aucun joueur trouvé !',
        ],

        'register' => [
            'title' => 'Inscription',
            'subtitle' => 'Rejoins nous !',
            'sign-up' => 'S’enregistrer',
        ],

        'login' => [
            'title' => 'Authentification',
            'login' => 'Connexion',
        ],
    ],
];
