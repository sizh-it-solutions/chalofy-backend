@extends('layouts.installer')

@section('steps')
    @include('installer.steps')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Server Requirements</h2>
            <p class="card-text">Please make sure your server meets the following requirements:</p>
            <ul class="list-group mb-4">
                @php
                    $checks = [
                        'php' => 'PHP >= 8.2',
                        'bcmath' => 'BCMath PHP Extension',
                        'ctype' => 'Ctype PHP Extension',
                        'json' => 'JSON PHP Extension',
                        'mbstring' => 'Mbstring PHP Extension',
                        'openssl' => 'OpenSSL PHP Extension',
                        'pdo' => 'PDO PHP Extension',
                        'tokenizer' => 'Tokenizer PHP Extension',
                        'xml' => 'XML PHP Extension',
                        'fileinfo' => 'Fileinfo PHP Extension',
                        'intl' => 'Intl PHP Extension',
                        'symlink' => 'Symlink Function Enabled',
                    ];
                @endphp

                @foreach ($checks as $key => $label)
                    <li class="list-group-item">
                        {{ $label }}
                        @if ($requirements[$key])
                            <span class="text-success float-right"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger float-right"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-between">
                <a href="{{ route('installer.index') }}" class="btn btn-secondary">Back</a>

                @php
                    $allRequirementsMet = collect($requirements)->every(fn($value) => $value);
                @endphp

                <a href="{{ route('installer.permissions') }}"
                    class="btn btn-primary @if(!$allRequirementsMet) disabled @endif">Next</a>
            </div>
        </div>
    </div>
@endsection
