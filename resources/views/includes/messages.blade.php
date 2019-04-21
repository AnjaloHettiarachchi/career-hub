@if (count($errors) > 0)
    <div class="ui error message">
        <i class="close icon"></i>
        <div class="header">{{ env('APP_NAME') }}</div>

        @foreach($errors->all() as $error)
            <strong>Error:</strong> {{ $error }}<br>
        @endforeach

    </div>
@endif

@if (session('exc'))
    @if (count(session('exc')) > 0)
        <div class="ui error message">
            <i class="close icon"></i>
            <div class="header">{{ env('APP_NAME') }}</div>

            @foreach(session('exc') as $error)
                <strong>Error:</strong> {{ $error }}<br>
            @endforeach

        </div>
    @endif
@endif

@if (session('success'))

    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">{{ env('APP_NAME') }}</div>
        <p>{{ session('success') }}</p>
    </div>

@endif

@if (session('error'))

    <div class="ui error message">
        <i class="close icon"></i>
        <div class="header">{{ env('APP_NAME') }}</div>
        <p>{{ session('error') }}</p>
    </div>

@endif