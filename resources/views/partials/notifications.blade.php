@if(isset($notifications) && $notifications->isNotEmpty())
    <div class="p-4 mb-6 rounded-xl border border-yellow-300 bg-yellow-50 text-yellow-800 shadow">
        <h3 class="text-lg font-semibold mb-2">🔔 Notifications</h3>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach($notifications as $note)
                <li>
                    {{ $note->data['message'] ?? 'Nouvelle notification' }}
                    <span class="text-xs text-gray-500">— {{ $note->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
