<?php

namespace App\Models\Relations;

trait HasManyEventsTrait
{
    /**
     * Get the event relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    /**
     * Delete all events.
     *
     * @return void
     */
    public function deleteEvents()
    {
        foreach ($this->events()->get(['id']) as $event) {
            $event->delete();
        }
    }
}
