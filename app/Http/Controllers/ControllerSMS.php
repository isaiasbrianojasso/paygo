<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Sender;
use App\Models\SMS;
use App\Models\API;
use App\Models\User;

use Exception;

class ControllerSMS extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function enviandoSms(Request $request)
    {
        try {
            //$SMS = SMS::where('sender_id', $request->sender)->get();
            if (isset($request->token)) {

                $user = User::where('api_token', $request->token)->first(); // devuelve un modelo (objeto)

                if (!$user) {
                    return ['header' => 'Error', 'msj' => 'Token expired or does not exist', 'icon' => ''];
                }
            } else {

                $user = User::where('id', Auth::user()->id)->first(); // devuelve un modelo (objeto)
                if (!$user) {
                    return ['header' => 'Error', 'msj' => 'Token expired or does not exist', 'icon' => ''];
                }
            }

            if (!isset($request->sender)) {
                return ['header' => 'Error', 'msj' => 'Sender not provided', 'icon' => ''];
            }
            $servicio = $request->sender;
            $SENDER = SENDER::where('sender_id', $servicio)->first(); // devuelve un modelo (objeto)

            $auth = $this->autoriza($SENDER->costo, $user);
            if ($auth) {
                $API = API::where('api_id', $SENDER->api_id)->first();
                if ($API->nombre == "semysms") {

                    $numero = "+" . $request->number;
                } else {

                    $numero = $request->number;
                }
                $data = array(
                    $API->parametro_msg => $request->msj,
                    $API->parametro_number => $numero,
                    $API->parametro_token => $API->valor_token,
                    $API->parametro_1 => $API->valor_1,
                    $API->parametro_2 => $API->valor_2,
                    $API->parametro_3 => $API->valor_3,
                    $API->parametro_4 => $API->valor_4,
                );
                $respuesta = $this->post($data, $API->url);
                if ($API->json == 1) {
                    $success = [$API->parametro_success => $API->valor_success];
                    // Ejemplo: $success = ["code" => "0"];
                    $respuesta = json_decode($respuesta, true); // $respuesta = ["code" => "0", "id" => 1201158]
                    // Validar que json_decode haya funcionado y que el valor esperado esté presente
                    if (
                        json_last_error() === JSON_ERROR_NONE &&
                        isset($respuesta[$API->parametro_success]) &&
                        $respuesta[$API->parametro_success] == $API->valor_success
                    ) {
                        SMS::create([
                            'id_user' => $user->id,
                            'msj' => $request->msj,
                            'number' => $request->number,
                            'sender' => $SENDER->sender_id,
                            'api_id' => $API->api_id,
                            'status' => 1,
                            'sender_id' => $SENDER->sender_id,
                            'costo' => $SENDER->costo,
                            'sender_name' => $SENDER->sender_name,
                        ]);

                        $update = User::FindOrFail($user->id);
                        $update->creditos -= $SENDER->costo;
                        $update->save();

                        return ['ok' => 'ok', 'header' => 'Enviado', 'msj' => $request->msj, 'icon' => ''];
                    } else {
                        SMS::create([
                            'id_user' => $user->id,
                            'msj' => $request->msj,
                            'number' => $request->number,
                            'sender' => $SENDER->sender_id,
                            'api_id' => $API->api_id,
                            'status' => 0,
                            'sender_id' => $SENDER->sender_id,
                            'costo' => $SENDER->costo,
                            'sender_name' => $SENDER->sender_name,
                        ]);
                        return ['header' => 'No Enviado', 'msj' => $request->msj, 'icon' => ''];
                    }
                }
            } else {
                return ['header' => 'No Enviado sin creditos suficientes', 'msj' => $request->msj, 'icon' => ''];
            }
        } catch (Exception $e) {
            return ['header' => 'Error ', 'msj' => 'Sender Down please try another and let us team work' . $e, 'icon' => ''];
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function autoriza($costo, $user)
    {
        $user = User::FindOrFail($user->id);

        if ($costo <= $user->creditos) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function post($data, $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


}
