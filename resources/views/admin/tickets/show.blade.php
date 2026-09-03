@extends('admin.layouts.app')

@section('title', 'Admin Audit Ticket #' . $ticket->ticket_number)

@section('content')
<div class="w-full space-y-6 max-w-5xl mx-auto">

    <!-- Top Ticket Header Box -->
    <div class="p-6 rounded-3xl pdf-package-card space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-amber-500/20 pb-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-black text-amber-400 font-mono text-lg">{{ $ticket->ticket_number }}</span>
                    
                    @if($ticket->status === 'open' || $ticket->status === 'user_reply')
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/50 text-[10px] font-black uppercase animate-pulse">
                            PENDING REPLY
                        </span>
                    @elseif($ticket->status === 'answered')
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/50 text-[10px] font-black uppercase">
                            ANSWERED BY ADMIN
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 text-[10px] font-black uppercase">
                            RESOLVED / CLOSED
                        </span>
                    @endif
                </div>

                <h1 class="text-xl sm:text-2xl font-black text-white font-heading">{{ $ticket->subject }}</h1>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <!-- Status Toggle Form -->
                <form action="{{ route('admin.tickets.close', $ticket->id) }}" method="POST">
                    @csrf
                    @if($ticket->status === 'closed')
                        <input type="hidden" name="status" value="open">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500/20 hover:bg-amber-500/40 border border-amber-500/40 text-amber-300 font-extrabold text-xs flex items-center gap-1.5 transition">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i> Reopen Ticket
                        </button>
                    @else
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-rose-500/20 hover:bg-rose-500/40 border border-rose-500/40 text-rose-300 font-extrabold text-xs flex items-center gap-1.5 transition">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i> Mark Resolved / Close
                        </button>
                    @endif
                </form>

                <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 rounded-xl bg-black/80 hover:bg-black border border-amber-500/40 text-amber-300 font-bold text-xs flex items-center gap-1.5 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Audit List
                </a>
            </div>
        </div>

        <!-- Member Profile Info Bar -->
        <div class="p-4 rounded-2xl bg-black/80 border border-amber-500/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full pdf-gold-badge text-black font-black text-xs flex items-center justify-center shrink-0 shadow-lg">
                    {{ strtoupper(substr($ticket->user->name ?? 'M', 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-black text-white text-sm font-heading">{{ $ticket->user->name ?? 'User Deleted' }}</h4>
                    <p class="text-xs text-amber-400 font-mono">Code: {{ $ticket->user->referral_code ?? 'N/A' }} | Email: {{ $ticket->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            @if($ticket->user)
            <a href="{{ route('admin.users.show', $ticket->user->id) }}" class="px-3.5 py-1.5 rounded-xl pdf-gold-ribbon text-xs font-black uppercase tracking-wider shadow hover:scale-105 transition">
                View Member Profile &rarr;
            </a>
            @endif
        </div>

        <!-- Ticket Meta Info Pills -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-mono">
            <div class="p-3 rounded-2xl bg-black/60 border border-amber-500/20">
                <span class="text-neutral-400 font-sans block text-[10px]">CATEGORY</span>
                <span class="font-black text-amber-300 uppercase">{{ strtoupper($ticket->category) }}</span>
            </div>
            <div class="p-3 rounded-2xl bg-black/60 border border-amber-500/20">
                <span class="text-neutral-400 font-sans block text-[10px]">PRIORITY</span>
                <span class="font-black text-amber-300 uppercase">{{ strtoupper($ticket->priority) }}</span>
            </div>
            <div class="p-3 rounded-2xl bg-black/60 border border-amber-500/20">
                <span class="text-neutral-400 font-sans block text-[10px]">CREATED DATE</span>
                <span class="font-bold text-white">{{ $ticket->created_at ? $ticket->created_at->format('d M Y, h:i A') : 'N/A' }}</span>
            </div>
            <div class="p-3 rounded-2xl bg-black/60 border border-amber-500/20">
                <span class="text-neutral-400 font-sans block text-[10px]">LAST ACTIVITY</span>
                <span class="font-bold text-white">{{ $ticket->updated_at ? $ticket->updated_at->diffForHumans() : 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- CONVERSATION MESSAGES THREAD -->
    <div class="space-y-4">
        @foreach($ticket->messages as $msg)
            @if($msg->is_admin_reply)
                <!-- ADMIN REPLY CHAT BUBBLE (RIGHT ALIGNED) -->
                <div class="flex items-start justify-end gap-3 max-w-3xl ml-auto">
                    <div class="p-5 rounded-3xl pdf-package-card space-y-2 border-2 border-amber-400/80 shadow-2xl relative w-full">
                        <div class="flex items-center justify-between border-b border-amber-500/20 pb-2">
                            <span class="font-black text-amber-300 text-xs font-heading flex items-center gap-1.5">
                                <span>SUPER ADMIN RESPONSE</span>
                                <span class="px-2 py-0.5 rounded bg-amber-500 text-black text-[9px] font-black uppercase">Support Staff</span>
                            </span>
                            <span class="text-[10px] text-neutral-400 font-mono">{{ $msg->created_at ? $msg->created_at->format('d M Y, h:i A') : '' }}</span>
                        </div>
                        <div class="text-neutral-100 text-sm leading-relaxed whitespace-pre-line font-sans">
                            {{ $msg->message }}
                        </div>

                        @if($msg->attachment)
                        <div class="pt-2 border-t border-amber-500/10">
                            <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-black/80 text-amber-300 border border-amber-500/40 text-xs font-bold font-mono hover:underline">
                                <i data-lucide="paperclip" class="w-3.5 h-3.5 text-amber-400"></i>
                                View Admin Attachment
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="w-10 h-10 rounded-2xl pdf-gold-badge text-black font-black text-xs flex items-center justify-center shrink-0 shadow-lg mt-1">
                        👑
                    </div>
                </div>
            @else
                <!-- USER CHAT BUBBLE (LEFT ALIGNED) -->
                <div class="flex items-start gap-3 max-w-3xl">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/50 text-emerald-300 font-black text-xs flex items-center justify-center shrink-0 shadow-lg mt-1">
                        {{ strtoupper(substr($msg->user->name ?? 'M', 0, 1)) }}
                    </div>
                    <div class="p-5 rounded-3xl bg-black/90 border-2 border-emerald-500/60 space-y-2 shadow-xl relative w-full">
                        <div class="flex items-center justify-between border-b border-emerald-500/20 pb-2">
                            <span class="font-black text-emerald-400 text-xs font-heading">
                                {{ $msg->user->name ?? 'User' }} ({{ $msg->user->referral_code ?? 'Member' }})
                            </span>
                            <span class="text-[10px] text-neutral-400 font-mono">{{ $msg->created_at ? $msg->created_at->format('d M Y, h:i A') : '' }}</span>
                        </div>
                        <div class="text-neutral-100 text-sm leading-relaxed whitespace-pre-line font-sans">
                            {{ $msg->message }}
                        </div>

                        @if($msg->attachment)
                        <div class="pt-2 border-t border-emerald-500/10">
                            <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-950/60 text-emerald-300 border border-emerald-500/40 text-xs font-bold font-mono hover:underline">
                                <i data-lucide="paperclip" class="w-3.5 h-3.5 text-emerald-400"></i>
                                View User Attachment
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- POST ADMIN REPLY FORM CONTAINER -->
    <div class="p-6 rounded-3xl pdf-package-card space-y-4">
        <h3 class="text-sm font-black text-white font-heading uppercase tracking-wide flex items-center gap-2">
            <i data-lucide="send" class="w-4 h-4 text-amber-400"></i> Post Admin Support Reply
        </h3>

        <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <textarea name="message" rows="4" placeholder="Write official support reply to user..." required class="w-full p-4 rounded-2xl bg-black/80 border border-amber-500/40 text-white font-medium text-sm focus:outline-none focus:border-amber-400 shadow-inner"></textarea>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <input type="file" name="attachment" accept="image/jpeg,image/png,image/jpg,application/pdf" class="p-2 rounded-xl bg-black/80 border border-amber-500/30 text-neutral-300 font-mono text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:pdf-gold-ribbon file:font-black file:text-[10px] file:uppercase file:cursor-pointer cursor-pointer">

                <button type="submit" class="px-6 py-3 rounded-2xl pdf-gold-ribbon font-black text-xs uppercase tracking-wider shadow-xl hover:scale-105 transition flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4 text-black"></i>
                    <span>Send Official Reply</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
