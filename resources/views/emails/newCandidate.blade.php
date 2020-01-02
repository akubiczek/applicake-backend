<p>Nowy kandydat zgłosił swoją aplikację na stanowisko {{ $candidate->recruitment->name }}.</p>
<p><a href="{{ Route('candidates.view',['id' => $candidate->id]) }}">[Zobacz jego kartę]</a></p>
<p>Dodatkowe informacje: {{ $candidate->additional_info }}</p>