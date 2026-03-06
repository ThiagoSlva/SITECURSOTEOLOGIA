<?php
// webhook_asaas.php
require_once __DIR__ . '/includes/db.php';

// 1. Receber o Payload do Asaas
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// 2. Responder 200 OK imediatamente para o Asaas parar de tentar enviar
http_response_code(200);

// Validação básica
if (!$data || !isset($data['event']) || !isset($data['payment']['id'])) {
    die("Payload inválido");
}

$event = $data['event'];
$payment_id = $data['payment']['id'];

// 3. Processar Eventos de Pagamento
if (in_array($event, ['PAYMENT_RECEIVED', 'PAYMENT_CONFIRMED', 'PAYMENT_RECEIVED_IN_CASH'])) {

    // Pagamento Aprovado -> Liberar Curso
    $stmt = $pdo->prepare("UPDATE orders SET status = 'RECEIVED' WHERE asaas_id = ?");
    $stmt->execute([$payment_id]);


}
elseif (in_array($event, ['PAYMENT_DELETED', 'PAYMENT_REFUNDED', 'PAYMENT_CHARGEBACK_REQUESTED', 'PAYMENT_CHARGEBACK_DISPUTE'])) {

    // Pagamento Estornado/Rejeitado -> Bloquear Curso
    $stmt = $pdo->prepare("UPDATE orders SET status = 'REVOKED' WHERE asaas_id = ?");
    $stmt->execute([$payment_id]);


}

echo "Processado";
?>
