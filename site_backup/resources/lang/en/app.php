<?php

return [
    'global' => [
        'exceptions' => [
            'user-locked' => 'Your account is locked !',
            'too-many-requests' => 'Too many requests',
            'unauthenticated' => 'Not Authenticated',
            '403-title' => 'Access denied !',
            '403' => 'Access denied ! What are you doing here ?',
            '404-title' => 'Page not found !',
            '404' => 'Page not found ! Are you lost ?',
            '429-title' => 'Too many attempts...',
            '429' => 'Too many attempts... Please retry later.',
            '503-title' => 'Be right back.',
            '503' => 'Be right back.',
        ],
        'emails' => [
            'regards' => 'Regards',
            'help' => 'If you’re having trouble clicking the ":actionText" button, copy and paste the URL below into your web browser: [:actionUrl](:actionUrl)',
            'confirmation-email' => [
                'title' => 'Your email has been changed',
                'greeting' => 'Notification',
                'button' => 'Click here to confirm your email',
                'outro' => 'Thank you for using Tournament Fighters !',
            ],
            'welcome' => [
                'title' => 'Welcome on Tournament Fighters !',
                'greeting' => 'Hello,',
                'text' => 'We are happy to see you in our members.',
                'button' => 'Click here to confirm your email',
                'outro' => 'Thank you for joining and have fun !',
            ],
        ],
        'notifications' => [
            'welcome' => [
                'title' => 'Welcome on Tournament Fighters !',
                'text' => 'We are happy to see you in our members ! We send you an email with a link to confirm your email address.',
            ],
        ],
        'generic-texts' => [
            'yes' => 'Yes',
            'no' => 'No',
            'show' => 'Show',
            'add' => 'Add',
            'save' => 'Save',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'remove' => 'Remove',
            'back' => 'Back',
            'abort' => 'Abort',
            'toggle-nav' => 'Toggle navigation',
            'actions' => 'Actions',
            'publish' => 'Publish',
            'unpublish' => 'Unpublish',
            'example' => 'Example',
            'required' => 'required',
            'confirm' => 'Confirm',
            'locked' => 'Locked',
            'lock' => 'Lock',
            'unlock' => 'Unlock',
            'current' => 'Current',
            'confirmed' => 'confirmed',
            'not-confirmed' => 'not confirmed',
            'see-more' => 'See more +',
            'male' => 'Male',
            'female' => 'Female',
            'male-funny' => 'Male',
            'female-funny' => 'Female',
            'oops' => 'Oops !',
            'ok' => 'OK',
            'online' => 'Online',
            'offline' => 'Offline',
            'logo' => 'logo',
            'avatar' => 'avatar',
            'error-occured' => 'An error occured',
            'errors-occured' => 'Some errors occured',
            'all-rights-reserved' => 'All rights reserved.',
            'maps' => 'Maps',
            'map' => 'Map',
            'gamemodes' => 'Gamemodes',
            'player' => 'Player',
            'manager' => 'Manager',
            'friendly' => 'Friendly',
            'ranked' => 'Ranked',
            'wager' => 'Wager',
            'free' => 'Free',
            'classic' => 'Classic',
            'with-team' => 'with team',
            'players' => 'Players',
            'confirm-play' => 'Player confirmed',
            'not-confirm-play' => 'Player not confirmed',
            'match-in-progress' => 'Match in progress',
            'round' => 'Round',
            'mode' => 'Mode',
            'i-win' => 'I win !',
            'i-lost' => 'I lost !',
            'rules' => 'Rules',
            'winner' => 'Winner',
            'loser' => '',
            'wait-referee' => 'Waiting a referee',
            'wait-results' => 'Waiting manager results',
            'coming-soon' => 'Coming soon',
            'closed' => 'closed',
            'see' => 'See',
            'link' => 'Link',
            'send' => 'Send',
            'match-end' => 'Fin du match !',
        ],
        'forms-fields' => [
            'gender' => 'Sex',
            'email' => 'Email',
            'repeat-email' => 'Repeat Email',
            'avatar' => 'Avatar',
            'name' => 'Name',
            'username' => 'Username',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'birthdate' => 'Birthdate',
            'language' => 'Language',
            'password' => 'Password',
            'repeat-password' => 'Repeat Password',
            'subdomain' => 'Subdomain',
            'order' => 'Order',
            'banner' => 'Banner',
            'logo' => 'Logo',
            'menu-logo' => 'Menu Logo',
            'logo-list-trainings' => 'Logo Trainings List',
            'platform' => 'Platform',
            'roles' => 'Roles',
            'images-formats-help' => 'Only PNG or JPG images',
            'username-help' => 'Only letters, numbers, dashes and underscores',
            'team-name' => 'Team Name',
            'max-players-per-team' => 'Nb Max Players per Team',
            'max-teams-per-player' => 'Nb Max Teams per Player',
            'max-teams-per-player-premium' => 'Nb Max Teams per Premium Player',
            'title' => 'Title',
            'url' => 'URL',
            'content' => 'Content',
            'visible-in-menu' => 'Visible in menu',
            'gamemodes' => 'Gamemodes',
            'bo-list' => 'BO list',
            'vs-list' => 'VS list',
            'classic-modes-list' => 'Classic modes list',
            'abbrev' => 'Abbreviation',
            'credits' => 'Credits',
            'rules' => 'Rules',
            'network' => 'Network',
            'time_per_round' => 'Time Per Round (Minutes)',
            'id' => 'ID',
            'team1' => 'Team 1',
            'team2' => 'Team 2',
        ],
    ],
    'auth' => [
        'reset-password-title' => 'Reset Password',
        'confirm-you-are-not-a-robot' => 'Please confirm your are not a robot',
        'send-reset-link' => 'Send Password Reset Link',
        'reset-password-button' => 'Reset Password',

        'login-title' => 'Login',
        'forgot-password' => 'Forgot Your Password ?',
        'remember-me' => 'Remember Me',
        'login-button' => 'Login',

        'register-title' => 'Register',
        'register-button' => 'Register',
    ],
    'admin' => [
        'title' => 'Admin Area',
        'menu' => [
            'users' => 'Users',
            'games' => 'Games',
            'networks' => 'Networks',
            'platforms' => 'Game Platforms',
            'pages' => 'Pages',
            'referee' => 'Referee',
            'wallet' => 'Wallet',
        ],
        'user-menu' => [
            'front' => 'Front',
            'profile' => 'Profile',
            'parameters' => 'Parameters',
            'logout' => 'Logout',
        ],
        'dashboard' => [
            'title' => 'Dashboard',
            'description' => 'You are in admin area !',
        ],
        'games' => [
            // Controllers
            'created' => 'Game created',
            'updated' => 'Game updated',
            'deleted' => 'Game deleted',
            'published' => 'Game published',
            'unpublished' => 'Game unpublished',

            // Views
            'list-title' => 'Games',
            'no-games' => 'No Games',
            'add-title' => 'Add a new game',
            'edit-title' => 'Edit game :name',
            'confirm-delete' => 'Do you really want to delete game <b>:name</b> ?',
            'confirm-publish' => 'Do you really want to publish game <b>:name</b> ?',
            'confirm-unpublish' => 'Do you really want to unpublish game <b>:name</b> ?',
        ],
        'maps' => [
            // Controllers
            'created' => 'Map created',
            'updated' => 'Map updated',
            'deleted' => 'Map deleted',
        
            // Views
            'list-title' => 'Maps',
            'no-maps' => 'No Maps',
            'add-title' => 'Add a new map',
            'edit-title' => 'Edit map :name',
            'confirm-delete' => 'Do you really want to delete map <b>:name</b> ?',
        ],
        'gamemodes' => [
            // Controllers
            'created' => 'Gamemode created',
            'updated' => 'Gamemode updated',
            'deleted' => 'Gamemode deleted',
        
            // Views
            'list-title' => 'Gamemodes',
            'no-gamemodes' => 'No Gamemodes',
            'add-title' => 'Add a new gamemode',
            'edit-title' => 'Edit gamemode :name',
            'confirm-delete' => 'Do you really want to delete gamemode <b>:name</b> ?',
        ],
        'networks' => [
            // Controllers
            'created' => 'Network created',
            'updated' => 'Network updated',
            'deleted' => 'Network deleted',

            // Views
            'list-title' => 'Networks',
            'no-networks' => 'No Networks',
            'add-title' => 'Add a new game or social network',
            'edit-title' => 'Edit network :name',
            'confirm-delete' => 'Do you really want to delete network <b>:name</b> ?',
        ],
        'platforms' => [
            // Controllers
            'created' => 'Platform created',
            'updated' => 'Platform updated',
            'deleted' => 'Platform deleted',

            // Views
            'list-title' => 'Platforms',
            'no-platforms' => 'No Platforms',
            'add-title' => 'Add a new game platform',
            'edit-title' => 'Edit platform :name',
            'confirm-delete' => 'Do you really want to delete platform <b>:name</b> ?',
        ],
        'pages' => [
            // Controllers
            'created' => 'Page created',
            'updated' => 'Page updated',
            'deleted' => 'Page deleted',

            // Views
            'list-title' => 'Pages',
            'no-pages' => 'No Pages',
            'add-title' => 'Add a new page',
            'edit-title' => 'Edit page :title',
            'confirm-delete' => 'Do you really want to delete page <b>:title</b> ?',
        ],
        'users' => [
            // Controllers
            'created' => 'User created',
            'updated' => 'User updated',
            'deleted' => 'User deleted',
            'locked' => 'User locked',
            'confirmation-email-sent' => 'Confirmation email sent',
            'email-already-confirmed' => 'Email address already confirmed',
            'avatar-deleted' => 'Avatar deleted',

            // Views
            'list-title' => 'Users',
            'no-users' => 'No Users',
            'list-filters-labels' => [
                'all' => 'All',
                'staff' => 'Staff',
                'users' => 'Users',
                'locked' => 'Locked',
                'unlocked' => 'Unlocked',
            ],
            'add-title' => 'Add a new user',
            'edit-title' => 'Edit user :username',
            'show-title' => 'User :username',
            'email-not-confirmed' => 'Email not confirmed',
            'send-confirmation-email' => 'Send a confirmation email',
            'confirm-delete-user' => 'Do you really want to delete user <b>:username</b> ?',
            'confirm-lock-user' => 'Do you really want to lock user <b>:username</b> ?',
            'confirm-unlock-user' => 'Do you really want to unlock user <b>:username</b> ?',
            'confirm-remove-avatar' => 'Do you really want to remove this avatar ?',
        ],
        'referee' => [
            'list-title' => 'Matches Need Referee',
            'no-platforms' => 'No Match',
        ],
        'wallet' => [
            'list-title' => 'Money Asked',
            'no-ask' => 'No Request',
            'credits' => 'Credits asked',
            'infos' => 'User Infos',
            'date' => 'Request Date',
            'mark-done' => 'Delete',
            'request-done' => 'Request Done !',
            'paypal-or-bank' => 'Paypal/RIB',
        ],
    ],
    'front' => [
        'main-menu' => [
            'trainings' => 'Training',
            'tournaments' => 'Tournament',
            'my-profile' => 'My Profile',
            'my-teams' => 'My Teams',
            'ranking' => 'Ranking',
            'forum' => 'Forum',
            'shop' => 'Shop',
            'lives' => 'Live',
            'change-active-team' => 'Change my current team',
            'no-game-selected' => 'No game selected',
            'select-your-game' => 'Select your game',
        ],

        'user-menu' => [
            'deposit-money' => 'Add Money',
            'elo-ranking' => 'ELO Ranking',
            'match-in-progress' => 'Match in progress',
            'match-wait-confirm' => 'Wager waiting your confirmation',
            'change-active-team' => 'Change my current team',
            'notifications' => 'Notifications',

            'my-profile' => 'My Profile',
            'my-teams' => 'My Teams',
            'my-stats' => 'My Stats',
            'my-safe' => 'My Wallet',
            'become-premium' => 'Become Premium !',
            'parameters' => 'Parameters',
            'logout' => 'Logout',

            'register' => 'Register',
            'login' => 'Login',
        ],
        
        'wallet' => [
            'title' => 'My Wallet',
            'credits' => 'How many credits do you want to exchange ?',
            'paypal-or-rib' => 'Give your Paypal or a Bank Account (Name, Firstname, IBAN and BIC)',
            'send' => 'Send my request',
            'sended' => 'Request sent !',
            'ask-already-exists' => 'You already made a request for some credits, please wait before creating another request.',
            'exchange-for' => 'Credits value :',
        ],

        'parameters' => [
            // Controllers
            'confirmation-email-sent' => 'Confirmation email sent',
            'email-already-confirmed' => 'Email address already confirmed',
            'email-changed' => 'Email changed',
            'nothing-changed' => 'Nothing changed',
            'email-confirmed' => 'Email confirmed',
            'unable-to-confirm-email' => 'Unable to confirm your email',
            'updated' => 'Parameters saved',
            'password-changed' => 'Password changed',
            'become-premium-to-change-username' => 'Become Premium to change your username !',

            // Views
            'menu' => [
                'general' => 'General',
                'email' => 'Email',
                'password' => 'Password',
            ],

            'layout' => [

            ],

            'index' => [
                'title' => 'General',
            ],

            'change-email' => [
                'title' => 'Change your email',
                'email-not-confirmed' => 'Email not confirmed',
                'send-confirmation-email' => 'Send me a confirmation email',
                'confirm-password' => 'Confirm your password',
            ],

            'change-password' => [
                'title' => 'Change your password',
                'confirm-password' => 'Confirm your current password',
                'new-password' => 'New Password',
                'repeat-new-password' => 'Repeat New Password',
            ],
        ],
        
        'home' => [
            'modals' => [
                'select-game' => [
                    'title' => 'Select a game first !',
                ],
            ],
        ],
        
        'shop' => [
            'menu' => [
                'premium' => 'Premium',
                'credits' => 'Credits',
            ],
            
            'errors' => [
                'its-already-your-plan' => 'You have already subscribed this plan',
                'you-cant-change-for-monthly' => 'You can’t change for the monthly plan. You need to wait that your yearly plan terminate.',
                'you-cant-change-before-end' => 'You can’t change your plan. You need to wait that your yearly plan terminate.',
            ],
            
            'texts' => [
                'nbcredits-added' => ':nbcredits credits added to your account !',
                'buy-for' => 'Buy for :price',
                'premium-subscribed' => 'You are now a Premium member !',
                'premium-modified' => 'You plan was changed !',
                'premium-cancelled' => 'Your subscription will not be renewed !',
                'premium-resumed' => 'Your subscription will be renewed !',
                'per-month' => '/month',
                'per-year' => '/year',
                'subscribe' => 'Subscribe',
                'actual-plan' => 'Your current plan',
                'actual-subscription' => 'Your Subscription',
                'until' => 'Until',
                'cancel-subscription' => 'Stop my subscription',
                'resume-subscription' => 'Resume my subscription',
            ],
            
            'premium' => [
                'title' => 'Premium',
                
                'description' => 'Become Premium on TournamentFighters and discover exclusive advantages :<br>- Win 100% of your bet during Wagers<br>- Create unlimited number of teams<br>- Put your Trainings on top of the list<br>- Change your username freely',
                
                'plans' => [
                    'monthly' => 'Monthly Plan',
                    'yearly' => 'Yearly Plan',
                ],
            ],
            
            'credits' => [
                'title' => 'Credits',
                
                'description' => 'TNF credits allows your to participate to Wagers.<br>They can be converted in real money in your wallet.',
                
                'offers' => [
                    '200-credits' => '200 credits',
                    '500-credits' => '500 credits',
                    '1000-credits' => '1000 credits',
                    '2000-credits' => '2000 credits',
                    '5000-credits' => '5000 credits',
                ],
            ],
        ],
        
        'trainings' => [
            'list' => [
                'component' => [
                    'title' => 'Trainings',
                    'no-trainings' => 'No match available',
                    'no-trainings-filters' => 'No match matching filters',
                    'rank' => 'Rank',
                    'join-match' => 'Join',
                    'abort-match' => 'Abort',
                    'my-team-match' => 'My Team',
                    'match-premium' => 'Training Premium',
                    'FRIENDLY' => 'Friendly',
                    'RANKED' => 'Ranked',
                    'WAGER' => 'Wager',
                    
                    'cols' => [
                        'game' => 'Game',
                        'team' => 'Team',
                        'rank' => 'Rank',
                        'rule' => 'Rule',
                        'mode' => 'Mode',
                        'bo' => 'BO',
                        'vs' => 'Players',
                        'style' => 'Style',
                        'join' => 'Join',
                        'details' => 'Details',
                    ],
                ],
                
                'modals' => [
                    'errors' => [
                        'wrong-mode-map' => 'Map :map is not playable in mode :mode',
                        'players-invalid' => 'Check that all players are selected and not present twice',
                        'maps-invalid' => 'Check that all maps are selected and not present twice',
                        'score-invalid' => 'Your team score dont allow you to play in this match',
                        'players-have-match-in-progress' => 'Following players are already in a game : :usernames',
                        'player-not-enough-credits' => 'Player :username have not enough credits',
                        'players-active-team-is-not-your-team' => 'Following players have selected another active team : :usernames',
                        'already-in-progress' => 'This training is already in progress !',
                        'you-have-to-participate' => 'You must be player or manager !',
                        'players-have-no-network-id' => 'Following players miss a game identifier for this game (PSN ID etc) : :usernames',
                    ],
                    
                    'errors-modals' => [
                        'no-active-team' => [
                            'message' => 'You have to select a team before playing !',
                        ],
                        
                        'wrong-game-active-team' => [
                            'message' => 'You have to select a team playing this game !',
                        ],
                        
                        'match-in-progress' => [
                            'message' => 'You already have a match in progress !',
                        ],
                    ],
                    
                    'create-training' => [
                        'open-buttons' => [
                            'create-wager' => 'Create a wager',
                            'create-training' => 'Create a training',
                        ],
                        
                        'training' => [
                            'title' => 'Create a training',
                        
                            'rule' => 'Rule',
                            'bestof' => 'Best Of',
                            'mode' => 'Mode',
                            'maps' => 'Maps',
                            'vs' => 'VS',
                            'manager' => 'Manager',
                            'players' => 'Players',
                            'rank' => 'Rank',
                            
                            'btn-create' => 'Create this training',
                        ],
                        
                        'wager' => [
                            'title' => 'Create a wager',
                        
                            'bestof' => 'Best Of',
                            'mode' => 'Mode',
                            'vs' => 'VS',
                            'manager' => 'Manager',
                            'players' => 'Players',
                            'bet' => 'Every player bet',
                            
                            'btn-create' => 'Create this wager',
                        ],
                    ],
                    
                    'join-training' => [
                        'open-buttons' => [
                            'join' => 'Join',
                        ],
                        
                        'training' => [
                            'title' => 'Join a training',
                        
                            'manager' => 'Manager',
                            'players' => 'Players',
                            
                            'btn-join' => 'Join this training',
                        ],
                        
                        'wager' => [
                            'title' => 'Join a wager',
                        
                            'manager' => 'Manager',
                            'players' => 'Players',
                            
                            'btn-join' => 'Join this wager',
                        ],
                    ],
                    
                    'abort-match' => [
                        'title' => 'Abort This Training ?',
                        
                        'btn-not-abort' => 'Keep it',
                        'btn-abort' => 'Abort it',
                    ],
                ],
            ],
            
            'show' => [
                'error-wait-join' => 'Match is waiting a second squad !',
                'error-aborted' => 'This match was aborted !',
                'confirm-your-participation' => 'Confirm your participation to this WAGER',
                'deny-particpation' => 'Deny',
                'accept-participation' => 'Accept for :bet',
                'match-cancellation' => 'Match Cancellation',
                'continue-match' => 'Continue Match',
                'cancel-match' => 'Cancel Match',
                'you-asked-cancel-wait-other-manager' => 'You asked to cancel this match.<br>We are waiting opponent decision...',
                'other-team-want-cancel-what-do-you-want' => 'Opponent asked to cancel this match. What do you want to do ?',
                'your-manager-asked-cancellation' => 'Your manager asked to cancel this match !',
                'other-manager-asked-cancellation' => 'Opponent manager asked to cancel this match !',
                'user-cancelled-match' => ':username cancelled this match !',
                'user-deny-to-cancel-match' => ':username deny to cancel this match !',
                'rounds-details' => 'Rounds Details',
                'this-round-will-be-unlocked-in' => 'This round will be unlocked in',
                'become-premium' => 'Become Premium !',
                'become-premium-to-win-more' => 'Become Premium to win 100% of your bet !',
                'to-win' => 'to win',
                'training-details-title' => 'Training',
                'see-rules-and-details' => 'See rules and match details',
                'ask-to-cancel' => 'Ask opponent to cancel this match',
                'referee-was-called' => 'A referee was called !',
                'call-referee' => 'Call a referee',
                'error-chat-match-closed' => 'This chat is closed !',
                'team-won-match' => 'Team :team win !',
            ],
        ],
        
        'profile' => [
            // Controllers
            'updated' => 'Profile saved',
            'error-too-many-teams' => 'You can’t have more than :limit teams !',

            // Views
            'layout' => [
                'menu' => [
                    'home' => 'Home',
                    'teams' => 'Teams',
                    'last-matchs' => 'Last Matchs',
                    'statistiques' => 'Statistiques',
                ],
                'change' => 'Change',
                'click-to-change-banner' => 'Click to change your banner',
                'click-to-change-avatar' => 'Click to change<br>your avatar',
                'years-old' => 'years old',
                'member-since' => 'Member since',
                'see-my-website' => 'See my website',
                'tweets-by' => 'Tweets by',
                'description-placeholder' => 'A Short Description',
                'invite-player' => 'Invite',
                'accept-candidate' => 'Accept Candidate',
                'deny-candidate' => 'Deny Candidate',
            ],

            'index' => [
                'matchs-played' => 'Matchs played',
                'matchs-won' => 'Matchs won',
                'matchs-lost' => 'Matchs lost',
            ],

            'teams' => [
                'title' => 'Teams',
                'title_candidatures' => 'Candidate',
                'title_invites' => 'Invites',
                'create-team' => 'Create New Team',
                'activate-team' => 'Activate This Team',
                'current-team' => 'Current Active Team',
                'text-no-teams' => 'You are not member of a team actually.',
    
                'modals' => [
                    'create-team' => [
                        'title' => 'Team Name',
                        'help' => 'Can contain letters, numbers, dashes and spaces',
                        'button' => 'Create',
                    ],
                ],
            ],
        ],
    
        'team' => [
            // Controllers
            'updated' => 'Team saved',
        
            // Views
            'layout' => [
                'menu' => [
                    'home' => 'Home',
                    'members' => 'Members',
                    'last-matchs' => 'Last Matchs',
                    'statistiques' => 'Statistiques',
                ],
                'change' => 'Change',
                'join' => 'Join',
                'leave' => 'Leave',
                'abort-candidate' => 'Abort Candidature',
                'accept-invite' => 'Accept Invite',
                'decline-invite' => 'Decline Invite',
                'you-are-ban' => 'You are blacklisted by this team !',
                'click-to-change-banner' => 'Click to change your banner',
                'click-to-change-avatar' => 'Click to change<br>your avatar',
                'see-my-website' => 'See our website',
                'tweets-by' => 'Tweets by',
                'name-placeholder' => 'Team name',
                'description-placeholder' => 'A Short Description',
                'sure-to-leave-question' => 'Do you really want to leave team :name ?',
            ],
        
            'index' => [
                'matchs-played' => 'Matchs played',
                'matchs-won' => 'Matchs won',
                'matchs-lost' => 'Matchs lost',
            ],
        
            'members' => [
                'title' => 'Members',
                'title_candidatures' => 'Candidates',
                'title_invites' => 'Invites',
                'title_bans' => 'Bans',
    
                'text-no-invites' => 'There are no invites in this team actually.',
                'text-no-members' => 'There are no members in this team actually.',
                'text-no-candidates' => 'There are no candidates for this team actually.',
                'text-no-bans' => 'There are no bans for this team actually.',
    
                'invite' => 'Invite',
                'accept-candidate' => 'Accept',
                'deny-candidate' => 'Deny',
                'promote-manager' => 'Promote',
                'promote-player' => 'Demote',
                'remove-player' => 'Remove',
                'remove-invite' => 'Abort',
                'ban' => 'Ban',
                'unban' => 'Unban',
                
                'confirm-remove' => 'Do you really want to remove member <b>:username</b> ?',
                'confirm-ban' => 'Do you really want to ban member <b>:username</b> ?',
                'confirm-unban' => 'Do you really want to unban member <b>:username</b> ?',
                'confirm-deny' => 'Do you really want to deny member <b>:username</b> ?',
                'confirm-accept' => 'Do you really want to accept member <b>:username</b> ?',
                'confirm-remove-invite' => 'Do you really want to remove <b>:username</b> invitation ?',
    
                'modals' => [
                    'invite-player' => [
                        'title' => 'Invite a Player',
                        'button' => 'Invite',
                        'errors' => [
                            'user-dont-exists' => 'Player not found !',
                            'user-already-invited' => 'Player already invited !',
                            'user-already-member' => 'Player already member !',
                        ],
                    ],
                ],
            ],
        ],

        'search' => [
            'input-placeholder' => 'Search',
            'teams-title' => 'Teams',
            'players-title' => 'Players',
            'no-teams' => 'No team found !',
            'no-players' => 'No player found !',
        ],

        'register' => [
            'title' => 'Register',
            'subtitle' => 'Join us !',
            'sign-up' => 'Sign up',
        ],

        'login' => [
            'title' => 'Login',
            'login' => 'OK',
        ],
    ],
];
