<?php


namespace Controllers;

use Router\Router;

class WebSocketController
{

    public static function index(Router $router)
    {



        $router->render("wss/index", [
            "scripts" => ["wss/index"],
            "title" => "Prueba WSS"
        ]);
    }

    public static function ws()
    {



        // set_time_limit(5);
        // $host = 'localhost';
        // $port = 3000;
        // $null = NULL;

        // // Crear el socket del servidor
        // $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        // socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
        // socket_bind($socket, $host, $port);
        // socket_listen($socket);

        // Crear y añadir el socket principal a la lista de clientes
        // $clients = [$socket];

        // while (true) {
        //     // Crear una copia de la lista de clientes
        //     $changed = $clients;

        //     // Esperar nuevas conexiones
        //     socket_select($changed, $null, $null, 0, 10);

        //     // Comprobar si hay una nueva conexión
        //     if (in_array($socket, $changed)) {
        //         exit;
        //         $socket_new = socket_accept($socket);
        //         $clients[] = $socket_new;

        //         $header = socket_read($socket_new, 1024);
        //         perform_handshaking($header, $socket_new, $host, $port);

        //         socket_getpeername($socket_new, $ip);
        //         echo "New connection from $ip\n";

        //         // Eliminar el socket principal de la lista cambiada
        //         $found_socket = array_search($socket, $changed);
        //         unset($changed[$found_socket]);
        //     }

        //     // Iterar a través de todos los clientes conectados
        //     foreach ($changed as $changed_socket) {
        //         // Comprobar si hay datos entrantes
        //         while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
        //             $received_text = unmask($buf);
        //             echo "Received message: $received_text\n";

        //             // Enviar respuesta al cliente
        //             $response_text = mask(json_encode(["message" => "Message received: $received_text"]));
        //             send_message($response_text, $changed_socket);
        //             break 2;
        //         }

        //         $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        //         if ($buf === false) {
        //             // El cliente se ha desconectado
        //             socket_getpeername($changed_socket, $ip);
        //             echo "Client $ip disconnected\n";

        //             // Eliminar cliente de la lista
        //             $found_socket = array_search($changed_socket, $clients);
        //             unset($clients[$found_socket]);
        //         }
        //     }
        // }

        // // Cerrar el socket
        // socket_close($socket);

        // // Funciones auxiliares para manejar el protocolo WebSocket
        // function send_message($msg, $changed_socket)
        // {
        //     @socket_write($changed_socket, $msg, strlen($msg));
        //     return true;
        // }

        // function unmask($text)
        // {
        //     $length = ord($text[1]) & 127;
        //     if ($length == 126) {
        //         $masks = substr($text, 4, 4);
        //         $data = substr($text, 8);
        //     } elseif ($length == 127) {
        //         $masks = substr($text, 10, 4);
        //         $data = substr($text, 14);
        //     } else {
        //         $masks = substr($text, 2, 4);
        //         $data = substr($text, 6);
        //     }
        //     $text = '';
        //     for ($i = 0; $i < strlen($data); ++$i) {
        //         $text .= $data[$i] ^ $masks[$i % 4];
        //     }
        //     return $text;
        // }

        // function mask($text)
        // {
        //     $b1 = 0x80 | (0x1 & 0x0f);
        //     $length = strlen($text);

        //     if ($length <= 125) {
        //         $header = pack('CC', $b1, $length);
        //     } elseif ($length > 125 && $length < 65536) {
        //         $header = pack('CCn', $b1, 126, $length);
        //     } elseif ($length >= 65536) {
        //         $header = pack('CCNN', $b1, 127, $length);
        //     }
        //     return $header . $text;
        // }

        // function perform_handshaking($receved_header, $client_conn, $host, $port)
        // {
        //     $headers = [];
        //     $lines = preg_split("/\r\n/", $receved_header);
        //     foreach ($lines as $line) {
        //         $line = chop($line);
        //         if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
        //             $headers[$matches[1]] = $matches[2];
        //         }
        //     }

        //     $secKey = $headers['Sec-WebSocket-Key'];
        //     $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));

        //     $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        //         "Upgrade: websocket\r\n" .
        //         "Connection: Upgrade\r\n" .
        //         "WebSocket-Origin: $host\r\n" .
        //         "WebSocket-Location: ws://$host:$port/wss/server\r\n" .
        //         "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        //     socket_write($client_conn, $upgrade, strlen($upgrade));
        // }
    }
}
