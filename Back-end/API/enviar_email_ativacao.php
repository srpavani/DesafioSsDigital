<?php
function enviarEmailAtivacao($emailUsuario, $tokenAtivacao) {

    $apiKey = 'bf08ffa3a078f79f27046405b6365bc1';
    $apiSecret = '8f0412ed348cd4703e2ad94e52e37eb9';

    
    $fromEmail = "pavanidiogo1@gmail.com";  
    $fromName = "SSDIGITAL";               
    $subject = "Ativação de Conta";       

    $htmlContent = "
        <h1>Ativação de Conta</h1>
        <p>Obrigado por se registrar! Para ativar sua conta, clique no link abaixo:</p>
        <a href='http://localhost:3000/ativar/{$tokenAtivacao}'>Ativar Conta</a>
    ";


    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $fromEmail,
                    'Name' => $fromName
                ],
                'To' => [
                    [
                        'Email' => $emailUsuario,
                        'Name' => "Usuário"
                    ]
                ],
                'Subject' => $subject,
                'HTMLPart' => $htmlContent
            ]
        ]
    ];

   
    $ch = curl_init();

    
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3.1/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);


    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $apiSecret);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Erro no cURL: ' . curl_error($ch);
        return false;
    } else {
        $response = json_decode($result, true);
        if (isset($response['Messages'][0]['Status']) && $response['Messages'][0]['Status'] == 'success') {
            return true;  
        } else {
            return false;  
        }
    }

    curl_close($ch); //fecha o curl 
}
