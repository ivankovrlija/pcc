<style>
{{ $templateCSS }}
</style>

@php
$template = str_replace('{FNAME}', $lead->first_name, $template);
$template = str_replace('{LNAME}', $lead->last_name, $template);
$template = str_replace('{EMAIL}', $lead->email, $template);

echo $template;
@endphp