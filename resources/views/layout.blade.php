<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Training Institute</title>
    <style>
        :root { font-family: Arial, sans-serif; color: #202b3c; background: #f5f7fa; }
        body { margin: 0; }
        nav { display: flex; flex-wrap: wrap; gap: 1rem; padding: 1rem max(1rem, calc((100% - 1100px) / 2)); background: #17365d; }
        nav a { color: #fff; font-weight: 700; text-decoration: none; }
        main { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        h1 { margin-top: 0; }
        a { color: #175ea8; }
        .actions { display: flex; flex-wrap: wrap; gap: .75rem; align-items: center; }
        .button { display: inline-block; border: 0; border-radius: 4px; padding: .55rem .8rem; background: #175ea8; color: white; font: inherit; text-decoration: none; cursor: pointer; }
        .button.secondary { background: #566579; }
        .button.danger { background: #b42318; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: .75rem; border: 1px solid #d5dce5; text-align: left; vertical-align: top; }
        th { background: #eaf0f6; }
        .table-wrap { overflow-x: auto; }
        .field { margin: 1rem 0; }
        label { display: block; margin-bottom: .35rem; font-weight: 700; }
        input:not([type=checkbox]), textarea, select { box-sizing: border-box; width: 100%; max-width: 560px; padding: .6rem; border: 1px solid #9aa8b8; border-radius: 4px; font: inherit; }
        textarea { min-height: 100px; }
        input[type=checkbox] { margin-right: .4rem; }
        .notice { margin: 1rem 0; padding: .8rem 1rem; border-radius: 4px; }
        .success { background: #e4f5e9; color: #155b2b; }
        .errors { background: #fde9e7; color: #8d1b13; }
        .errors ul { margin-bottom: 0; }
        .empty { padding: 1rem; background: #fff; border: 1px solid #d5dce5; }
        @media (max-width: 600px) {
            main { margin-top: 1.25rem; }
            th, td { padding: .5rem; }
            .actions { gap: .5rem; }
        }
    </style>
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="{{ route('students.index') }}">Students</a>
        <a href="{{ route('courses.index') }}">Courses</a>
    </nav>
    <main>
        @if (session('success'))
            <div class="notice success" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice errors" role="alert">
                <strong>Please correct the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
