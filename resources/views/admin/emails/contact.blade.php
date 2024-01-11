@component('mail::message')
# Contact Us Mail

Terima kasih sudah menghubungi kami, pesan Anda akan kami proses secepatnya!
 
<p>Name: {{ $data['fullname'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Subject: {{ $data['subject'] }}</p>
<p>Message: {{ $data['msg'] }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent