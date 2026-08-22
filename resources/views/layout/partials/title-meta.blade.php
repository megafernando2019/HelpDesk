@php
    $filename = Route::currentRouteName(); // use route name instead of PHP_SELF

    $acronyms = ['ui', 'ai', 'js', 'api', 'css', 'html', 'php', 'seo', 'faq', 'rtl'];

    if ($filename === 'index') {
        $title = 'Admin Dashboard';
    } else {
        $parts = explode('-', str_replace('ui-', '', strtolower($filename)));

        $hasIcon = false;
        $hasChart = false;
        $cleaned_parts = [];

        foreach ($parts as $part) {
            if ($part === 'icon') {
                $hasIcon = true;
                continue;
            }
            if ($part === 'chart') {
                $hasChart = true;
                continue;
            }
            if ($part === 'all') {
                continue;
            }
            $cleaned_parts[] = $part;
        }

        $formatted_parts = array_map(function ($word) use ($acronyms) {
            return in_array($word, $acronyms) ? strtoupper($word) : ucfirst($word);
        }, $cleaned_parts);

        if ($hasIcon) {
            $formatted_parts[] = 'Icons';
        }
        if ($hasChart) {
            $formatted_parts[] = 'Charts';
        }

        $title = implode(' ', $formatted_parts);
    }
@endphp

<!-- Meta Tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title> {{ $title }} | Dreams Timer - Time Tracking Boostrap 5 Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Dreams Timer is a sleek time tracking admin dashboard for managing work hours, productivity, and teams.">
<meta name="keywords" content="time tracking dashboard, admin template, workforce management, employee productivity, project time tracker, Dreams Timer admin panel, business dashboard UI">
<meta name="author" content="Dreams Technologies">