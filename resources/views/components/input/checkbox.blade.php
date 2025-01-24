@props([
    'label'
])

<label class="inline-flex items-center space-x-2">
    <input
      {{$attributes->class([
            'form-checkbox is-basic size-5 rounded checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent',
            'border-slate-400/70' => !$errors->has($attributes->get('name')),
            'border-error' => $errors->has($attributes->get('name')),
      ])}}
      type="checkbox"
    />
    <p>{{$label}}</p>  
</label>
@error($attributes->get('name'))
    <span
        class="text-tiny+ text-error"
    >{{$message}}</span>
@enderror
<br/>
<br/>