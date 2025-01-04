<div class="mb-3">
    <label class="block">
        <input
          {{$attributes->class([
            'form-input w-full rounded-lg border bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent',
            'border-slate-300' => !$errors->has($attributes->get('name')),
            'border-error' => $errors->has($attributes->get('name')),
          ])}}
        />
    </label>
    @error($attributes->get('name'))
        <span
            class="text-tiny+ text-error"
        >{{$message}}</span>
    @enderror
</div>