<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.UserController.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('tickets', function ($user) {
    // Retorne true se o usuário estiver autorizado a ouvir o canal
    return $user; // Substitua com sua lógica de verificação de admin
});

