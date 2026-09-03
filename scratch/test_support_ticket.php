<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\SupportTicket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;

$user = User::where('role_id', 2)->first();

if ($user) {
    $ticket = SupportTicket::create([
        'ticket_number' => 'TKT-'.strtoupper(Str::random(6)),
        'user_id' => $user->id,
        'subject' => 'Need help with USDT BEP20 deposit confirmation',
        'category' => 'deposit',
        'priority' => 'high',
        'status' => 'open',
    ]);

    TicketMessage::create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'message' => 'Hello Admin team, I submitted a deposit of $500 via USDT BEP20. Please verify transaction hash.',
        'is_admin_reply' => false,
    ]);

    echo 'Sample Support Ticket created: Ticket #'.$ticket->ticket_number."\n";
} else {
    echo "No member user found.\n";
}
