@if ($errors->any())
    <div class="errors" style="display: none;">
        @foreach ($errors->all() as $error)
            <div class="form-error hidden">{{ $error }}</div>
        @endforeach
    </div>
@endif
