@if ($errors->any())
    <div class="mx-auto w-5/6 mt-8">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-400 mb-3 list-none">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif