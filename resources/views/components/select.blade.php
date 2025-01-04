@props([
    'label',
])
<div class="mb-3">
    <label class="block">
        <span>{{$label}}</span>
        <select
            {{$attributes->class([
                'form-select mt-1.5 w-full rounded-lg border bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent',
                'border-slate-300' => !$errors->has($attributes->get('name')),
                'border-error' => $errors->has($attributes->get('name'))
            ])}}
        >
            {{$slot}}
        </select>
    </label>
    @error($attributes->get('name'))
        <span
            class="text-tiny+ text-error"
        >{{$message}}</span>
    @enderror
</div>