<?php
// sucesso.php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/security.php';

$order_id = filter_input(INPUT_GET, 'order', FILTER_VALIDATE_INT);
$payment_url = filter_input(INPUT_GET, 'pay_url', FILTER_SANITIZE_URL);

if (!$order_id) {
    die("Pedido não encontrado.");
}

// Fetch order and settings (for WhatsApp number)
$stmt = $pdo->prepare("
    SELECT o.*, c.title as course_title, s.whatsapp_number 
    FROM orders o 
    JOIN courses c ON o.course_id = c.id 
    JOIN settings s ON s.id = 1
    WHERE o.id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    die("Pedido não encontrado no sistema.");
}

$phone = preg_replace('/[^0-9]/', '', $order['whatsapp_number']);
$message = "Olá! Acabei de gerar o pagamento para o curso: *" . $order['course_title'] . "*. \nMeu nome é " . $order['customer_name'] . ".\n\nAqui está o link do meu pagamento caso precise conferir: " . $order['payment_url'];
$whatsapp_url = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($message);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processando Pedido - CGADRB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .loader {
            border: 3px solid rgba(255,255,255,0.1);
            border-left-color: #00ffcc;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-black text-white min-h-screen flex items-center justify-center font-mono">

    <div class="text-center max-w-md px-6">
        <div class="flex justify-center mb-8">
            <div class="loader"></div>
        </div>
        
        <h1 class="text-2xl mb-4 text-[#00ffcc]">Pedido Gerado com Sucesso!</h1>
        <p class="text-gray-400 text-sm mb-8 leading-relaxed">
            Estamos redirecionando você para o <span class="text-white">WhatsApp</span> da coordenação para confirmar sua matrícula e enviar o comprovante.
        </p>

        <a href="<?php echo htmlspecialchars($whatsapp_url); ?>" id="manual-btn" class="px-6 py-3 border border-[#00ffcc]/50 text-[#00ffcc] rounded-full text-xs hover:bg-[#00ffcc] hover:text-black transition-colors">
            Clique aqui se o redirecionamento falhar
        </a>
        
        <div class="mt-8 text-xs text-gray-600">
            <p>Seu link Asaas: <a href="<?php echo htmlspecialchars($payment_url); ?>" target="_blank" class="underline hover:text-white">Acessar Cobrança</a></p>
        </div>
    </div>

    <!-- Redirecionamento Automático -->
    <script>
        setTimeout(() => {
            window.location.href = "<?php echo $whatsapp_url; ?>";
        }, 3000);
    </script>
</body>
</html>
