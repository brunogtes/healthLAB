<?php

namespace App\Http\Controllers;

use App\Models\ModelResultadoExames;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherNotificationController extends Controller
{

    private $objResulExame;

    public function __construct()

    {
        $this->objResulExame = new ModelResultadoExames();
    }


    public function sendNotification()
    {
        //Remember to change this with your cluster name.
        $options = array(
            'cluster' => 'mt1',
            'encrypted' => true
        );

        //Remember to set your credentials below.
        $pusher = new Pusher(
            'deb72aa236b633d47afc',
            'b0ca04dd59a0aa74f924',
            '1405840',
            $options
        );
               
        $exameCustomizado = $this->objResulExame::whereMonth('data_cadastro', now()->month)->whereYear('data_cadastro', now()->year)->whereDay('data_cadastro', now()->day)->where('etapa', 'Aguardando Coleta')->orWhere('etapa', 'Aguardando Resultado')->count();
        $exameVencidos = $this->objResulExame::whereMonth('data_cadastro', now()->month)->whereYear('data_cadastro', now()->year)->whereDay('data_cadastro', now()->day -1)->where('etapa', 'Aguardando Coleta')->orWhere('etapa', 'Aguardando Resultado')->count();

        if ($exameCustomizado == 0) {           
         
        } else if ($exameCustomizado > 0) {

            $message = "Exite {$exameCustomizado} exame(s) pendente(s) para serem finalizados hoje.";

            //Send a message to notify channel with an event name of notify-event
            $pusher->trigger('notification', 'notification-event', $message);
           
        }

        if ($exameVencidos == 0) {           
         
        } else if ($exameVencidos > 0) {

            $message = "Exite {$exameVencidos} exame(s) atradado(s)!";

            //Send a message to notify channel with an event name of notify-event
            $pusher->trigger('notification', 'notification-event', $message);

           
           
        }



         
    }
}

