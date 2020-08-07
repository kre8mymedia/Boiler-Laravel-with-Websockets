<h2>New Comment on Ticket #{{ $ticket_id }}</h2>

<p><b>From:</b> {{ $email }} at {{ $company }}</p>

<hr>

<p><b>Public:</b> @if($is_public == 1) Yes @else No @endif</p>
<p><b>Comment:</b> {{ $comment }}</p>

<hr>

<p>Regards,</p>
<p>Ngauge Team</p>
<p><small>This is an internal transactional message. The sender of this message is Animus.</small></p>