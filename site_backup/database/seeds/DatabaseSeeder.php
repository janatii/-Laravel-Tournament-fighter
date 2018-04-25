<?php

use App\Models\Game;
use App\Models\Gamemode;
use App\Models\Map;
use App\Models\Network;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*============================================================================================================*\
         * Permissions
        \*============================================================================================================*/
        
        $permissionsData = [
            'admin' => 1000,
            'referee' => 2000,
        ];
        
        $permissions = [];
        foreach ($permissionsData as $key => $permissionData) {
            $permissions[$key] = factory(Permission::class)->create([
                'id' => $permissionData,
                'name' => $key,
            ]);
        }
        
        /*============================================================================================================*\
         * Roles
        \*============================================================================================================*/
        
        $rolesData = [
            'superadmin' => [
                'name' => 'superadmin',
                'is_staff' => true,
                'permissions' => [
                    $permissions['admin']->id,
                    $permissions['referee']->id,
                ],
            ],
            'admin' => [
                'name' => 'admin',
                'is_staff' => true,
                'permissions' => [
                    $permissions['admin']->id,
                    $permissions['referee']->id,
                ],
            ],
            'referee' => [
                'name' => 'referee',
                'is_staff' => true,
                'permissions' => [
                    $permissions['referee']->id,
                ],
            ],
            'player' => [
                'name' => 'player',
                'is_staff' => false,
                'permissions' => [
                ],
            ],
        ];
        
        $roles = [];
        foreach ($rolesData as $key => $roleData) {
            $roles[$key] = factory(Role::class)->create([
                'name' => $roleData['name'],
                'is_staff' => $roleData['is_staff'],
            ]);
            $roles[$key]->permissions()->attach($roleData['permissions']);
        }
        
        /*============================================================================================================*\
         * Users
        \*============================================================================================================*/
        
        $usersData = [
            'superadmin1' => [
                'username' => 'superadmin1',
                'roles' => [
                    $roles['superadmin']->id,
                ],
            ],
            'superadmin2' => [
                'username' => 'superadmin2',
                'roles' => [
                    $roles['superadmin']->id,
                ],
            ],
            'admin1' => [
                'username' => 'admin1',
                'roles' => [
                    $roles['admin']->id,
                ],
            ],
            'admin2' => [
                'username' => 'admin2',
                'roles' => [
                    $roles['admin']->id,
                ],
            ],
            'referee1' => [
                'username' => 'referee1',
                'roles' => [
                    $roles['referee']->id,
                ],
            ],
            'referee2' => [
                'username' => 'referee2',
                'roles' => [
                    $roles['referee']->id,
                ],
            ],
        ];
        
        $users = [];
        foreach ($usersData as $key => $userData) {
            $users[$key] = factory(User::class)->create([
                'username' => $userData['username'],
                'email' => $userData['username'] . '@example.net',
                'credits' => 1000000,
            ]);
            $users[$key]->roles()->attach($userData['roles']);
        }
        
        /*============================================================================================================*\
         * Networks
        \*============================================================================================================*/
        
        $networksData = [
            'facebook',
            'googleplus',
            'twitter',
            'youtube',
            'twitch',
            'playstation',
            'xbox',
            'steam',
        ];
        $networks = [];
        foreach ($networksData as $networkData) {
            $networks[$networkData] = factory(Network::class)->create([
                'name' => $networkData,
            ]);
        }
        
        /*============================================================================================================*\
         * Platforms
        \*============================================================================================================*/
        
        $platforms = [];
        
        $platforms['pc'] = Platform::create([
            'name' => 'PC',
            'order' => 1,
        ]);
        
        $platforms['ps4'] = Platform::create([
            'name' => 'PS4',
            'order' => 2,
        ]);
        
        $platforms['xbox'] = Platform::create([
            'name' => 'Xbox One',
            'order' => 3,
        ]);
        
        /*============================================================================================================*\
         * Games
        \*============================================================================================================*/
        
        $gamesData = [
            'codiw' => [
                'global' => [
                    'name' => 'Call of Duty Infinite Warfare',
                    'max_players_per_team' => 10,
                    'max_teams_per_player' => 5,
                    'max_teams_per_player_premium' => 20,
                    'bo_list' => '1,3,5,7',
                    'vs_list' => '1,2,3,4',
                    'classic_modes_list' => 'HP,SND,UPLINK,SND,HP,SND,UPLINK',
                    'published' => true,
                    'order' => 1,
                ],
                'platforms' => [
                    'xbox',
                    'ps4',
                ],
                'gamemodes' => [
                    'HP' => 'Hardpoint',
                    'SND' => 'Search and Destroy',
                    'UPLINK' => 'Uplink',
                ],
                'maps' => [
                    'Breakout' => [
                        'gamemodes' => ['HP'],
                    ],
                    'Crusher' => [
                        'gamemodes' => ['SND'],
                    ],
                    'Frost' => [
                        'gamemodes' => ['UPLINK'],
                    ],
                    'Precinct' => [
                        'gamemodes' => ['UPLINK'],
                    ],
                    'Retaliation' => [
                        'gamemodes' => ['HP', 'SND'],
                    ],
                    'Scorch' => [
                        'gamemodes' => ['HP', 'SND'],
                    ],
                    'Throwback' => [
                        'gamemodes' => ['HP', 'SND', 'UPLINK'],
                    ],
                ],
            ],
            'r6s' => [
                'global' => [
                    'name' => 'Rainbow Six: Siege',
                    'max_players_per_team' => 10,
                    'max_teams_per_player' => 5,
                    'max_teams_per_player_premium' => 20,
                    'bo_list' => '1,3,5,7',
                    'vs_list' => '1,2,3,4,5',
                    'classic_modes_list' => 'BOMB,BOMB,BOMB,BOMB,BOMB,BOMB,BOMB',
                    'published' => true,
                    'order' => 2,
                ],
                'platforms' => [
                    'xbox',
                    'ps4',
                    'pc',
                ],
                'gamemodes' => [
                    'BOMB' => 'Bomb',
                ],
                'maps' => [
                    'Yacht' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Bank' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Chalet' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'ClubHouse' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Consulate' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Hereford Base' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'House' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Kafe Dostoyevsky' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Kanal' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Oregon' => [
                        'gamemodes' => ['BOMB'],
                    ],
                    'Presidential Plane' => [
                        'gamemodes' => ['BOMB'],
                    ],
                ],
            ],
        ];
        
        $games = [];
        foreach ($gamesData as $gameAbbrev => $gameData) {
            foreach ($gameData['platforms'] as $platformAbbrev) {
                $networkToUse = 'steam';
                if ($platformAbbrev == 'xbox') {
                    $networkToUse = 'xbox';
                } elseif ($platformAbbrev == 'ps4') {
                    $networkToUse = 'playstation';
                }
                
                $games["$gameAbbrev-$platformAbbrev"] = $gameTmp = Game::create($gamesData[$gameAbbrev]['global'] + [
                    'subdomain' => "$gameAbbrev-$platformAbbrev",
                    'platform_id' => $platforms[$platformAbbrev]->id,
                    'network_id' => $networks[$networkToUse]->id,
                    'time_per_round' => 1,
                ]);
                
                $gamemodesTmp = [];
                foreach ($gameData['gamemodes'] as $gamemodeAbbrev => $gamemode) {
                    $gamemodesTmp[$gamemodeAbbrev] = Gamemode::create([
                        'game_id' => $gameTmp->id,
                        'name' => $gamemode,
                        'abbrev' => $gamemodeAbbrev,
                    ]);
                }
                
                foreach ($gameData['maps'] as $mapName => $mapData) {
                    $mapTmp = Map::create([
                        'game_id' => $gameTmp->id,
                        'name' => $mapName,
                    ]);
                    
                    foreach ($mapData['gamemodes'] as $gamemodeMap) {
                        $mapTmp->gamemodes()->attach($gamemodesTmp[$gamemodeMap]->id);
                    }
                }
            }
        }
        
        /*============================================================================================================*\
         * Teams
        \*============================================================================================================*/
        
        $teamsData = [
            'rebels' => [
                'name' => "Rebels",
                'slug' => "rebels",
                'description' => "",
                'players' => [
                    "Luke Skywalker",
                    "Leia Organa",
                    "Han Solo",
                    "Chewbacca",
                    "Lando Calrissian",
                    "Wedge Antilles",
                    "Admiral Ackbar",
                    "Mon Mothma",
                ],
            ],
            'jedis' => [
                'name' => "Jedis",
                'slug' => "jedis",
                'description' => "",
                'players' => [
                    "Luke Skywalker",
                    "Obi-Wan Kenobi",
                    "Yoda",
                    "Qui-Gon Jinn",
                    "Anakin Skywalker",
                    "Mace Windu",
                    "Ayla Secura",
                ],
            ],
            'bad-guys' => [
                'name' => "Bad guys",
                'slug' => "bad-guys",
                'description' => "",
                'players' => [
                    "Darth Vader",
                    "Palpatine",
                    "Dooku",
                    "Darth Maul",
                    "Grievous",
                    "Boba Fett",
                    "Jango Fett",
                    "Sebulba",
                    "Jabba The Hutt",
                ],
            ],
            'droids' => [
                'name' => "Droids",
                'slug' => "droids",
                'description' => "",
                'players' => [
                    "R2-D2",
                    "C-3PO",
                    "BB-8",
                    "K-2SO",
                    "Grievous",
                    "R4-P17",
                    "HK-47",
                ],
            ],
            'humans' => [
                'name' => "Humans",
                'slug' => "humans",
                'description' => "",
                'players' => [
                    "Luke Skywalker",
                    "Leia Organa",
                    "Han Solo",
                    "Obi-Wan Kenobi",
                    "Qui-Gon Jinn",
                    "Anakin Skywalker",
                    "Mace Windu",
                    "Palpatine",
                    "Dooku",
                    "Boba Fett",
                    "Jango Fett",
                ],
            ],
            'pilots' => [
                'name' => "Pilots",
                'slug' => "pilots",
                'description' => "",
                'players' => [
                    "Luke Skywalker",
                    "Anakin Skywalker",
                    "Han Solo",
                    "Jango Fett",
                    "Sebulba",
                    "Lando Calrissian",
                    "Wedge Antilles",
                ],
            ],
            'aliens' => [
                'name' => "Aliens",
                'slug' => "aliens",
                'description' => "",
                'players' => [
                    "Greedo",
                    "Jar Jar Binks",
                    "Chewbacca",
                    "Jabba The Hutt",
                    "Admiral Ackbar",
                    "Ayla Secura",
                    "Yoda",
                    "Dark Maul",
                    "Watto",
                    "Nute Gunray",
                    "Bib Fortuna",
                ],
            ],
            'simpsons' => [
                'name' => "Simpsons",
                'slug' => "simpsons",
                'description' => "",
                'players' => [
                    "Homer Simpson",
                    "Marge Simpson",
                    "Bart Simpson",
                    "Lisa Simpson",
                    "Maggie Simpson",
                    "Abraham Simpson",
                    "Ned Flanders",
                    "Montgomery Burns",
                    "Moe Szyslak",
                ],
            ],
            'addams' => [
                'name' => "Addams",
                'slug' => "addams",
                'description' => "",
                'players' => [
                    "Gomez Addams",
                    "Morticia Addams",
                    "Mercredi Addams",
                    "Pugsley Addams",
                    "Fetide Addams",
                    "La Chose",
                    "Lurch",
                    "Grand-mère Addams",
                ],
            ],
            'barbapapas' => [
                'name' => "Barbapapas",
                'slug' => "barbapapas",
                'description' => "",
                'players' => [
                    "Barbapapa",
                    "Barbamama",
                    "Barbalala",
                    "Barbabelle",
                    "Barbotine",
                    "Barbidur",
                    "Barbibul",
                    "Barbidou",
                    "Barbouille",
                ],
            ],
            'futurama' => [
                'name' => "Futurama",
                'slug' => "futurama",
                'description' => "",
                'players' => [
                    "Philip J. Fry",
                    "Bender",
                    "Turanga Leela",
                    "Docteur Zoidberg",
                    "Amy Wong",
                    "Hubert Farnsworth",
                    "Hermes Conrad",
                    "Scruffy",
                    "Nibbler",
                ],
            ],
            'starks' => [
                'name' => "Starks",
                'slug' => "starks",
                'description' => "",
                'players' => [
                    "Eddard Stark",
                    "Catelyn Stark",
                    "Jon Snow",
                    "Bran Stark",
                    "Arya Stark",
                    "Sansa Stark",
                    "Rickon Stark",
                    "Robb Stark",
                ],
            ],
        ];
        
        $gamesTeams = [
            'r6s-ps4' => [
                'rebels',
                'bad-guys',
                'droids',
                'humans',
                'pilots',
                'aliens',
                'simpsons',
                'barbapapas',
            ],
            'r6s-xbox' => [
                'jedis',
                'bad-guys',
                'droids',
                'humans',
                'pilots',
                'aliens',
                'simpsons',
                'futurama',
            ],
            'r6s-pc' => [
                'bad-guys',
                'droids',
                'humans',
                'pilots',
                'aliens',
                'addams',
                'starks',
            ],
            'codiw-ps4' => [
                'addams',
                'barbapapas',
                'simpsons',
                'futurama',
                'starks',
            ],
            'codiw-xbox' => [
                'rebels',
                'jedis',
                'simpsons',
                'addams',
                'barbapapas',
                'futurama',
                'starks',
            ],
        ];
        
        // Save all players
        foreach ($teamsData as $teamData) {
            foreach ($teamData['players'] as $playerName) {
                $slug = str_slug($playerName);
                if (!isset($users[$slug])) {
                    $users[$slug] = factory(User::class)->create([
                        'username' => $slug,
                        'email' => $slug . '@example.net',
                        'credits' => 5000,
                    ]);
                    $users[$slug]->roles()->attach($roles['player']->id);
                }
            }
        }
        
        $teams = [];
        foreach ($gamesTeams as $fullGameAbbrev => $currentGameTeams) {
            $gameId = $games[$fullGameAbbrev]->id;
            
            foreach ($currentGameTeams as $teamId) {
                $firstPlayer = null;
        
                $teamPlayers = [];
                
                $teamData = $teamsData[$teamId];
                foreach ($teamData['players'] as $playerName) {
                    $slug = str_slug($playerName);
            
                    // Add player to team
                    $teamPlayers[] = $users[$slug];
            
                    // Owner
                    if (!$firstPlayer) {
                        $firstPlayer = $users[$slug];
                    }
                }
        
                $tmpTeam = $teams["$fullGameAbbrev-$teamId"] = Team::create([
                    'name' => strtoupper($fullGameAbbrev) . ' ' . $teamData['name'],
                    'slug' => "$fullGameAbbrev-{$teamData['slug']}",
                    'description' => "",
                    'score' => config('app.default-elo'),
                    'game_id' => $gameId,
                    'owner_id' => $firstPlayer->id,
                ]);
        
                $cpt = 0;
                foreach ($teamPlayers as $playerTmp) {
                    if ($cpt < 3) {
                        $tmpTeam->members()->attach($playerTmp, ['role' => 'MANAGER']);
                    } else {
                        $tmpTeam->members()->attach($playerTmp, ['role' => 'PLAYER']);
                    }
                    $cpt++;
                }
            }
        }
    }
}
