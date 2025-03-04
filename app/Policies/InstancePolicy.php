<?php

namespace App\Policies;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_instances');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Instance $instance): bool
    {
        return $user->can('view_instances');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $clientQuantityInstances = Instance::when($user->client, function($query, $client) {
            $query->where('client_id', $client->id);
        })->count();
        
        $isLimitReached = !($user->client && $user->client->plan->quantity_instance >= $clientQuantityInstances);
        
        if($user->client->plan->quantity_instance == 0) {
            $isLimitReached = true;
        }

        
        return $isLimitReached && $user->can('create_instances');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instance $instance): bool
    {
        return $user->client->id == $instance->client_id && $user->can('update_instances');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instance $instance): bool
    {
        return $user->client->id == $instance->client_id && $user->can('delete_instances');;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Instance $instance): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Instance $instance): bool
    {
        return true;
    }
}
