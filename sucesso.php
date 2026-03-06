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

    <div class="max-w-md w-full px-6">
        <div class="bg-deep-surface/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl text-center">
            
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" class="mx-auto text-[#00ffcc] mb-6">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            
            <h1 class="text-2xl font-bold mb-4 text-white tracking-tighter">Quase tudo pronto!</h1>
            <p class="text-gray-400 text-sm mb-8 leading-relaxed font-sans">
                Sua pré-matrícula foi gerada. Siga os <strong class="text-[#00ffcc]">2 passos abaixo</strong> para finalizar e liberar seu acesso ao curso.
            </p>

            <div class="space-y-4">
                <a href="<?php echo htmlspecialchars($payment_url); ?>" target="_blank" class="flex items-center justify-center gap-2 w-full py-4 bg-[#00ffcc] text-black font-bold rounded-xl hover:bg-white transition-colors transform hover:-translate-y-1 shadow-lg text-sm">
                    1. Acessar Pagamento (Asaas)
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </a>

                <a href="<?php echo htmlspecialchars($whatsapp_url); ?>" target="_blank" class="flex items-center justify-center gap-2 w-full py-4 border border-[#00ffcc]/30 text-[#00ffcc] rounded-xl hover:bg-[#00ffcc]/10 transition-colors text-sm">
                    2. Já paguei! Avisar no WhatsApp
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </a>
            </div>
            
            <p class="mt-8 text-[10px] text-gray-500 font-sans">
                O acesso será liberado assim que o pagamento for confirmado no sistema.
            </p>
        </div>
    </div>

</body>
</html>
