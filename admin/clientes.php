<?php
// admin/clientes.php
require_once __DIR__ . '/includes/admin_header.php';

$success = '';
$error = '';

// Handle Order Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido.";
    }
    else {
        $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
        $new_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
        
        if ($order_id && in_array($new_status, ['PENDING', 'PAID', 'DELIVERED', 'CANCELLED'])) {
            $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $result = $stmt->execute([$new_status, $order_id]);
            
            if ($result) {
                $success = "Status do pedido atualizado com sucesso!";
            }
            else {
                $error = "Erro ao atualizar status.";
            }
        }
    }
}

// Handle Customer Data Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_customer') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Token de segurança inválido.";
    }
    else {
        $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
        
        if ($order_id && $name && $email) {
            $stmt = $pdo->prepare("UPDATE orders SET customer_name = ?, customer_email = ?, customer_phone = ? WHERE id = ?");
            $result = $stmt->execute([$name, $email, $phone, $order_id]);
            
            if ($result) {
                $success = "Dados do cliente atualizados com sucesso!";
            }
            else {
                $error = "Erro ao atualizar dados.";
            }
        }
    }
}

// Fetch all orders with customer and course info
$stmt = $pdo->query("
    SELECT o.*, c.title as course_title, c.price as course_price 
    FROM orders o 
    LEFT JOIN courses c ON o.course_id = c.id 
    ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll();
?>

<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold tracking-tighter">👥 Clientes e Pedidos</h2>
        <p class="text-gray-400 font-mono text-sm mt-1">Gerencie pedidos e dados dos clientes.</p>
    </div>
</div>

<?php if ($error): ?>
    <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="bg-green-900/50 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6 font-mono text-sm">
        <?php echo $success; ?>
    </div>
<?php endif; ?>

<div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs uppercase bg-white/5 font-mono">
                <tr>
                    <th class="px-6 py-4">Pedido</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Contato</th>
                    <th class="px-6 py-4">Curso</th>
                    <th class="px-6 py-4">Valor</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="8" class="px-6 py-8 text-center">Nenhum pedido encontrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-white font-mono">#<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-white font-medium"><?php echo sanitize_output($order['customer_name']); ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <p class="text-xs"><?php echo sanitize_output($order['customer_email']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo sanitize_output($order['customer_phone']); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-white font-medium"><?php echo sanitize_output($order['course_title']); ?></p>
                            </td>
                            <td class="px-6 py-4 text-[#00ffcc] font-mono">
                                R$ <?php echo number_format($order['course_price'], 2, ',', '.'); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $status_colors = [
                                    'PENDING' => 'bg-yellow-900/50 text-yellow-400',
                                    'PENDING_MANUAL' => 'bg-orange-900/50 text-orange-400',
                                    'PAID' => 'bg-green-900/50 text-green-400',
                                    'DELIVERED' => 'bg-blue-900/50 text-blue-400',
                                    'CANCELLED' => 'bg-red-900/50 text-red-400'
                                ];
                                $status_labels = [
                                    'PENDING' => 'Aguardando',
                                    'PENDING_MANUAL' => 'Aguardando Pagto',
                                    'PAID' => 'Pago',
                                    'DELIVERED' => 'Entregue',
                                    'CANCELLED' => 'Cancelado'
                                ];
                                $color = $status_colors[$order['status']] ?? 'bg-gray-900/50 text-gray-400';
                                $label = $status_labels[$order['status']] ?? $order['status'];
                                ?>
                                <span class="px-2 py-1 rounded <?php echo $color; ?> text-xs font-mono">
                                    <?php echo $label; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <!-- Edit Customer -->
                                    <button onclick="editCustomer(<?php echo $order['id']; ?>, '<?php echo sanitize_output($order['customer_name']); ?>', '<?php echo sanitize_output($order['customer_email']); ?>', '<?php echo sanitize_output($order['customer_phone']); ?>')" 
                                            class="text-blue-400 hover:text-white transition-colors text-xs font-mono" title="Editar Cliente">
                                        ✏️ Editar
                                    </button>
                                    
                                    <!-- Update Status -->
                                    <div class="relative">
                                        <select onchange="updateStatus(<?php echo $order['id']; ?>, this.value)" 
                                                class="bg-black border border-white/20 rounded px-2 py-1 text-xs text-gray-400 hover:border-[#00ffcc] focus:outline-none focus:border-[#00ffcc]">
                                            <option value="">Status</option>
                                            <option value="PENDING" <?php echo $order['status'] === 'PENDING' ? 'selected' : ''; ?>>Aguardando</option>
                                            <option value="PAID" <?php echo $order['status'] === 'PAID' ? 'selected' : ''; ?>>Pago</option>
                                            <option value="DELIVERED" <?php echo $order['status'] === 'DELIVERED' ? 'selected' : ''; ?>>Entregue</option>
                                            <option value="CANCELLED" <?php echo $order['status'] === 'CANCELLED' ? 'selected' : ''; ?>>Cancelado</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-[#0a0a0c] border border-white/10 rounded-2xl p-6 max-w-md w-full">
            <h3 class="text-xl font-bold mb-4">✏️ Editar Dados do Cliente</h3>
            
            <form id="editForm" method="POST" action="" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="update_customer">
                <input type="hidden" name="order_id" id="editOrderId">
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">Nome Completo</label>
                    <input type="text" name="customer_name" id="editName" required 
                           class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc]">
                </div>
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">E-mail</label>
                    <input type="email" name="customer_email" id="editEmail" required 
                           class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc]">
                </div>
                
                <div>
                    <label class="block text-xs font-mono text-gray-400 mb-2 uppercase">WhatsApp</label>
                    <input type="text" name="customer_phone" id="editPhone" required 
                           class="w-full bg-black border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-[#00ffcc]">
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-3 bg-[#00ffcc] text-black font-bold rounded-lg hover:bg-white transition-colors">
                        Salvar Alterações
                    </button>
                    <button type="button" onclick="closeModal()" class="px-6 py-3 border border-white/20 text-gray-400 rounded-lg hover:text-white transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCustomer(orderId, name, email, phone) {
    document.getElementById('editOrderId').value = orderId;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function updateStatus(orderId, newStatus) {
    if (!newStatus) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = 'csrf_token';
    csrfToken.value = '<?php echo generate_csrf_token(); ?>';
    form.appendChild(csrfToken);
    
    const action = document.createElement('input');
    action.type = 'hidden';
    action.name = 'action';
    action.value = 'update_status';
    form.appendChild(action);
    
    const orderIdInput = document.createElement('input');
    orderIdInput.type = 'hidden';
    orderIdInput.name = 'order_id';
    orderIdInput.value = orderId;
    form.appendChild(orderIdInput);
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = newStatus;
    form.appendChild(statusInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
