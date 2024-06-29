@props([
    'id',
    'name',
    'options' => [],
    'selected' => NULL,
])

<select id="{{ $id }}" name="{{ $name }}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1']) !!}>

    @foreach ($options as $key => $option)
        <option value="{{ $key }}" @selected($key==$selected)>
            {{ $option }}
        </option>
    @endforeach

</select>
