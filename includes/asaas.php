<?php
// includes/asaas.php

/**
 * Funçao auxiliar para enviar requisicao ao Asaas
 * @param string $endpoint O endpoint da API (ex: '/v3/customers')
 * @param array $data O payload da requisicao
 * @param string $method POST ou GET
 * @return array A resposta decodificada ou array com erro
 */
function asaas_request($endpoint, $data = [], $method = 'POST')
{
    global $pdo;

    // Buscar a API Key no banco
    $stmt = $pdo->query("SELECT asaas_api_key FROM settings LIMIT 1");
    $settings = $stmt->fetch();

    // Fallback/Sandbox key can go here if needed during dev
    $apiKey = $settings['asaas_api_key'] ?? '';

    if (empty($apiKey)) {
        return ['error' => true, 'message' => 'Chave API do Asaas não configurada.'];
    }

    $url = 'https://sandbox.asaas.com/api/v3' . $endpoint; // MUDAR PARA PRODUCAO DEPOIS 'https://api.asaas.com/v3'

    $ch = curl_init();

    $headers = [
        'Content-Type: application/json',
        'access_token: ' . $apiKey
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CUSTOMREQUEST => $method,
    ];

    if ($method === 'POST') {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }

    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        return ['error' => true, 'message' => "cURL Error: #:" . $err];
    }

    $decodedValue = json_decode($response, true);

    if ($httpCode >= 400) {
        $msg = $decodedValue['errors'][0]['description'] ?? 'Erro desconhecido na API do Asaas';
        return ['error' => true, 'message' => $msg, 'raw' => $decodedValue];
    }

    $decodedValue['error'] = false;
    return $decodedValue;
}

/**
 * Cria ou recupera o Customer no Asaas
 */
function asaas_create_customer($name, $cpfBase, $email, $phone)
{
    // 1. Verificar se ja existe (Get by Email/CPF)
    // Para simplificar, vamos sempre tentar criar. O Asaas lida razoavelmente bem com isso ou retorna erro se CPF bater
    // O ideal seria fazer GET /v3/customers?cpfCnpj=...

    $payload = [
        'name' => $name,
        'email' => $email,
        'cpfCnpj' => $cpfBase,
        'mobilePhone' => $phone
    ];

    $response = asaas_request('/customers', $payload, 'POST');
    return $response;
}

/**
 * Gera Cobranca PIX
 */
function asaas_create_pix_charge($customerId, $value, $description, $dueDate)
{
    $payload = [
        'customer' => $customerId,
        'billingType' => 'PIX',
        'value' => $value,
        'dueDate' => $dueDate,
        'description' => $description
    ];

    $response = asaas_request('/payments', $payload, 'POST');
    return $response;
}
