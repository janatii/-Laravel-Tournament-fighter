<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('ask', '[1-9][0-9]*');
Route::pattern('user', '[1-9][0-9]*');
Route::pattern('platform', '[1-9][0-9]*');
Route::pattern('game', '[1-9][0-9]*');
Route::pattern('network', '[1-9][0-9]*');
Route::pattern('match', '[1-9][0-9]*');
Route::pattern('round', '[1-9][0-9]*');
Route::pattern('subdomain', '[a-z0-9\-]+');
Route::pattern('pseudo', '[A-Za-z0-9\-_ ]+');
Route::pattern('teamname', '[A-Za-z0-9\-_ ]+');
Route::pattern('notifid', '[a-z0-9\-]+');
Route::pattern('selected_locale', '[A-Za-z\-]+');
Route::pattern('url', '[A-Za-z0-9\-\/]+');

Auth::routes();

// Global public routes
Route::post('/localization/change-locale/{selected_locale}', 'LocalizationController@changeLocale')->name('localization_change_locale');
Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

// Global authentified routes
Route::group(['middleware' => 'auth'], function() {
    Route::delete('/notifications/{notifid}', 'NotificationsController@deleteOne')->name('notifications_deleteone');
    Route::delete('/notifications', 'NotificationsController@deleteAll')->name('notifications_deleteall');
});

// Backend routes
Route::group(['namespace' => 'Admin', 'prefix' => '/admin'], function() {
    // Backend authentified routes
    Route::group(['middleware' => 'auth'], function() {
        Route::group(['middleware' => 'can:admin'], function() {
            Route::group(['namespace' => 'Users', 'prefix' => '/users'], function() {
                Route::get('', 'IndexController@index')->name('admin_users_list');
                
                Route::get('/{user}', 'ShowController@page')->name('admin_users_user');
                
                Route::get('/create', 'CreateController@page')->name('admin_users_create');
                Route::post('', 'CreateController@save');
                
                Route::get('/{user}/edit', 'EditController@page')->name('admin_users_edit');
                Route::patch('/{user}', 'EditController@save');
                Route::get('/{user}/send-confirmation-email', 'EditController@sendConfirmationEmail')->name('admin_users_send_confirmation_email');
                Route::delete('/{user}/avatar', 'EditController@deleteAvatar')->name('admin_users_avatar');
                
                Route::patch('/{user}/lock', 'LockController@lock')->name('admin_users_lock');
                Route::patch('/{user}/unlock', 'LockController@unlock')->name('admin_users_unlock');
                
                Route::delete('/{user}', 'DeleteController@delete');
            });
            
            Route::group(['namespace' => 'Platforms', 'prefix' => '/platforms'], function() {
                Route::get('', 'IndexController@index')->name('admin_platforms_list');
            
                Route::get('/create', 'CreateController@page')->name('admin_platforms_create');
                Route::post('', 'CreateController@save')->name('admin_platforms_create_submit');
            
                Route::get('/{platform}/edit', 'EditController@page')->name('admin_platforms_edit');
                Route::patch('/{platform}', 'EditController@save')->name('admin_platforms_edit_submit');
            
                Route::delete('/{platform}', 'DeleteController@delete')->name('admin_platforms_delete');
            });
            
            Route::group(['namespace' => 'Games'], function() {
                Route::get('/games', 'IndexController@index')->name('admin_games_list');
        
                Route::group(['prefix' => '/game'], function() {
                    Route::get('/create', 'CreateController@page')->name('admin_games_create');
                    Route::post('', 'CreateController@save')->name('admin_games_create_submit');
                    
                    Route::group(['prefix' => '/{game}'], function() {
                        Route::get('/edit', 'EditController@page')->name('admin_games_edit');
                        Route::patch('', 'EditController@save')->name('admin_games_edit_submit');
                
                        Route::patch('/publish', 'PublishController@publish')->name('admin_games_publish');
                        Route::patch('/unpublish', 'PublishController@unpublish')->name('admin_games_unpublish');
                
                        Route::delete('', 'DeleteController@delete')->name('admin_games_delete');
    
                        Route::group(['namespace' => 'Maps'], function() {
                            Route::get('/maps', 'IndexController@index')->name('admin_maps_list');
                            
                            Route::group(['prefix' => '/map'], function() {
                                Route::get('/create', 'CreateController@page')->name('admin_maps_create');
                                Route::post('', 'CreateController@save')->name('admin_maps_create_submit');
                        
                                Route::group(['prefix' => '/{map}'], function() {
                                    Route::get('/edit', 'EditController@page')->name('admin_maps_edit');
                                    Route::patch('', 'EditController@save')->name('admin_maps_edit_submit');
                            
                                    Route::delete('', 'DeleteController@delete')->name('admin_maps_delete');
                                });
                            });
                        });
    
                        Route::group(['namespace' => 'Gamemodes'], function() {
                            Route::get('/gamemodes', 'IndexController@index')->name('admin_gamemodes_list');
                    
                            Route::group(['prefix' => '/gamemode'], function() {
                                Route::get('/create', 'CreateController@page')->name('admin_gamemodes_create');
                                Route::post('', 'CreateController@save')->name('admin_gamemodes_create_submit');
                        
                                Route::group(['prefix' => '/{gamemode}'], function() {
                                    Route::get('/edit', 'EditController@page')->name('admin_gamemodes_edit');
                                    Route::patch('', 'EditController@save')->name('admin_gamemodes_edit_submit');
                            
                                    Route::delete('', 'DeleteController@delete')->name('admin_gamemodes_delete');
                                });
                            });
                        });
                    });
                });
            });
        
            Route::group(['namespace' => 'Networks', 'prefix' => '/networks'], function() {
                Route::get('', 'IndexController@index')->name('admin_networks_list');
            
                Route::get('/create', 'CreateController@page')->name('admin_networks_create');
                Route::post('', 'CreateController@save')->name('admin_networks_create_submit');
            
                Route::get('/{network}/edit', 'EditController@page')->name('admin_networks_edit');
                Route::patch('/{network}', 'EditController@save')->name('admin_networks_edit_submit');
            
                Route::delete('/{network}', 'DeleteController@delete')->name('admin_networks_delete');
            });
            
            Route::group(['namespace' => 'Pages', 'prefix' => '/pages'], function() {
                Route::get('', 'IndexController@index')->name('admin_pages_list');
            
                Route::get('/create', 'CreateController@page')->name('admin_pages_create');
                Route::post('', 'CreateController@save')->name('admin_pages_create_submit');
                
                Route::group(['prefix' => '/{page}'], function() {
                    Route::get('/edit', 'EditController@page')->name('admin_pages_edit');
                    Route::patch('', 'EditController@save')->name('admin_pages_edit_submit');
            
                    Route::delete('', 'DeleteController@delete')->name('admin_pages_delete');
                });
            });
            
            Route::group(['namespace' => 'Wallet', 'prefix' => '/wallet'], function() {
                Route::get('', 'ListController@page')->name('admin_wallet_list');
                Route::post('/{ask}', 'ListController@markDone')->name('admin_wallet_done');
            });
        });
        
        Route::group(['middleware' => 'can:referee'], function() {
            Route::get('/home', 'HomeController@index')->name('admin_home');
            
            Route::group(['namespace' => 'Referee', 'prefix' => '/referee'], function() {
                Route::get('', 'ListController@page')->name('admin_referee_list');
            });
        });
    });
});

// Frontend routes
Route::group(['namespace' => 'Front'], function() {
    Route::group(['middleware' => 'gamesubdomain:required', 'domain' => '{subdomain}.' . str_replace(['www.', 'http://', 'https://'], '', config('app.url'))], function() {
        Route::post('/search', 'SearchController@search')->name('search');
    
        Route::group(['namespace' => 'Profile', 'prefix' => '/profile'], function() {
            Route::get('/{pseudo}', 'IndexController@page')->name('profile_main');
            Route::post('/{user}', 'IndexController@save')->name('profile_main_save');
            
            Route::get('/{pseudo}/teams', 'TeamsController@index')->name('profile_teams');
            Route::post('/{user}/teams', 'TeamsController@createTeam')->name('profile_create_team');
        });
        
        Route::group(['namespace' => 'Team', 'prefix' => '/team'], function() {
            Route::get('/{teamname}', 'IndexController@page')->name('team_main');
            Route::post('/{team}', 'IndexController@save')->name('team_main_save');
        
            Route::get('/{teamname}/members', 'MembersController@index')->name('team_members');
            Route::post('/{team}/candidate', 'MembersController@candidate')->name('team_members_candidate');
            Route::delete('/{team}/abort-candidate', 'MembersController@abortCandidate')->name('team_members_abortcandidate');
            Route::post('/{team}/leave', 'MembersController@leave')->name('team_members_leave');
            Route::post('/{team}/members/{user}', 'MembersController@acceptCandidate')->name('team_members_acceptcandidate');
            Route::delete('/{team}/candidate/{user}', 'MembersController@denyCandidate')->name('team_members_denycandidate');
            Route::post('/{team}/members/{user}/promote-manager', 'MembersController@promoteManager')->name('team_members_promotemanager');
            Route::post('/{team}/members/{user}/promote-player', 'MembersController@promotePlayer')->name('team_members_promoteplayer');
            Route::delete('/{team}/members/{user}', 'MembersController@removePlayer')->name('team_members_removeplayer');
    
            Route::post('/{team}/invites', 'MembersController@addInvite')->name('team_members_addinvite');
            Route::post('/{team}/invites_by_id/{user}', 'MembersController@addInviteById')->name('team_members_addinvite_by_id');
            Route::delete('/{team}/invites/{user}', 'MembersController@removeInvite')->name('team_members_removeinvite');
            Route::patch('/{team}/invites/accept', 'MembersController@acceptInvite')->name('team_members_acceptinvite');
            Route::delete('/{team}/invites/decline', 'MembersController@declineInvite')->name('team_members_declineinvite');
    
            Route::post('/{team}/bans/{user}', 'MembersController@banPlayer')->name('team_members_banplayer');
            Route::delete('/{team}/bans/{user}', 'MembersController@unbanPlayer')->name('team_members_unbanplayer');
    
            Route::post('/{team}/select', 'SelectTeamController@select')->name('team_select');
        });

        Route::group(['namespace' => 'Trainings', 'prefix' => '/trainings'], function() {
            Route::get('', 'IndexController@page')->name('trainings_main');
            Route::post('/create', 'CreateController@create')->name('training_create');
            Route::post('/join', 'CreateController@join')->name('training_join');
            Route::delete('/abort', 'AbortController@abort')->name('training_abort');
            
            Route::group(['prefix' => '/{match}'], function() {
                Route::get('', 'ShowController@page')->name('training_show');
                
                Route::group(['middleware' => 'auth'], function() {
                    Route::patch('', 'ShowController@save')->name('training_save');
                    Route::patch('/confirm', 'ShowController@confirmWager')->name('training_confirm');
                    Route::patch('/ask-referee', 'ShowController@askReferee')->name('training_ask_referee');
                    Route::patch('/cancel/ask', 'ShowController@askCancel')->name('training_cancel_ask');
                    Route::patch('/cancel/confirm', 'ShowController@confirmCancel')->name('training_cancel_confirm');
                    Route::patch('/cancel', 'ShowController@cancel')->name('training_cancel');
                    Route::patch('/round/{round}', 'ShowController@sendScoreRound')->name('training_send_score_round');
                    Route::patch('/round/{round}/referee', 'ShowController@arbitrateRound')->name('training_arbitrate_round');
                    
                    Route::get('/messages', 'ChatController@getMessages')->name('training_messages');
                    Route::post('/send-message', 'ChatController@sendMessage')->name('training_sendmessage');
                });
            });
        });
    });
    
    Route::group(['middleware' => 'gamesubdomain:optional', 'domain' => '{subdomain}.' . str_replace(['www.', 'http://', 'https://'], '', config('app.url'))], function() {
        // Front authentified routes
        Route::group(['middleware' => 'auth'], function() {
            Route::group(['namespace' => 'Parameters', 'prefix' => '/parameters'], function() {
                Route::get('', 'IndexController@page')->name('parameters_main');
                Route::post('', 'IndexController@save');
            
                Route::get('/email', 'EmailController@page')->name('parameters_email');
                Route::post('/email', 'EmailController@save');
                Route::get('/email/send-confirmation-email', 'EmailController@sendConfirmationEmail')->name('parameters_send_confirmation_email');
                Route::get('/email/confirm-email/{token}', 'EmailController@confirm')->name('parameters_confirm_email');
            
                Route::get('/password', 'PasswordController@page')->name('parameters_password');
                Route::post('/password', 'PasswordController@save');
            });
            
            Route::group(['namespace' => 'Wallet', 'prefix' => '/wallet'], function() {
                Route::get('', 'IndexController@page')->name('wallet_main');
                Route::post('', 'IndexController@send')->name('wallet_send');
            });
        });
        
        Route::group(['namespace' => 'Shop', 'prefix' => '/shop'], function() {
            Route::get('', 'IndexController@page')->name('shop_main');
            
            Route::get('/credits', 'CreditsController@page')->name('shop_credits');
            
            Route::get('/premium', 'PremiumController@page')->name('shop_premium');
            
            Route::group(['middleware' => 'auth'], function() {
                Route::post('/credits', 'CreditsController@buy')->name('shop_credits_buy');
                Route::post('/premium', 'PremiumController@subscribe')->name('shop_premium_subscribe');
                Route::post('/premium/cancel', 'PremiumController@cancel')->name('shop_premium_cancel');
                Route::post('/premium/resume', 'PremiumController@resume')->name('shop_premium_resume');
            });
        });
        
        Route::get('', 'HomeController@index')->name('home');
        Route::get('{url}', 'PagesController@getPage');
    });
});
