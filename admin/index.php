<?php
// admin/index.php
require_once __DIR__ . '/includes/admin_header.php';

// Get total courses
$stmt = $pdo->query("SELECT COUNT(*) FROM courses");
$total_courses = $stmt->fetchColumn();

// Get total orders
$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$total_orders = $stmt->fetchColumn();

// Get recent orders
$stmt = $pdo->query("SELECT o.*, c.title as course_title FROM orders o JOIN courses c ON o.course_id = c.id ORDER BY o.created_at DESC LIMIT 5");
$recent_orders = $stmt->fetchAll();

?>

<div class="mb-8">
    <h2 class="text-3xl font-bold tracking-tighter">Dashboard</h2>
    <p class="text-gray-400 font-mono text-sm mt-1">Visão Geral do Sistema</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl">
        <h3 class="text-gray-400 font-mono text-xs uppercase tracking-widest mb-2">Cursos Ativos</h3>
        <p class="text-4xl font-bold text-white"><?php echo $total_courses; ?></p>
    </div>
    
    <div class="bg-[#0a0a0c] border border-white/10 p-6 rounded-2xl">
        <h3 class="text-gray-400 font-mono text-xs uppercase tracking-widest mb-2">Total de Pedidos</h3>
        <p class="text-4xl font-bold text-[#00ffcc]"><?php echo $total_orders; ?></p>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-[#0a0a0c] border border-white/10 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-white/10 flex justify-between items-center">
        <h3 class="text-lg font-bold">Últimos Pedidos Associados</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs uppercase bg-white/5 font-mono">
                <tr>
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Estudante</th>
                    <th class="px-6 py-4">Curso</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent_orders)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-mono">Nenhum pedido registrado ainda.</td>
                    </tr>
                <?php
else: ?>
                    <?php foreach ($recent_orders as $order): ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            <td class="px-6 py-4 text-white font-medium"><?php echo sanitize_output($order['customer_name']); ?></td>
                            <td class="px-6 py-4 text-[#00ffcc]"><?php echo sanitize_output($order['course_title']); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded bg-gray-800 text-xs font-mono"><?php echo sanitize_output($order['status']); ?></span>
                            </td>
                        </tr>
                    <?php
    endforeach; ?>
                <?php
endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
