@foreach($params as $name => $value)
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
@endforeach
