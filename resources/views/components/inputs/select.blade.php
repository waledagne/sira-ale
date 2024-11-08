@props(['name','id','options' => [],'label' => null,'value' => ''])
<div class="mb-4">
    @if($label)
    <label class="block text-gray-700" for="job_type"
    >Job Type</label
>
    @endif
    <select
        id="{{$id}}"
        name="{{$name}}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name)
            border-red-500
        @enderror"
    >
    @foreach($options as $optionValue => $optionLable)
    <option value="{{$optionValue}}" {{old($name, $value) == $optionValue ? 'selected' : ''}}>
       {{$optionLable}}
    </option>
    @endforeach


    </select>
    @error($name)
    <p class="text-red-500 text-sm mt-1">{{$message}}</p>
    @enderror
</div>