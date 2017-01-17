<?php

namespace App\Presenters;

trait OwnerPresenterTrait
{
    /**
     * Get the owner.
     *
     * @return string
     */
    public function owner()
    {
        $user = $this->getWrappedObject()->user()->getResults();

        return $user->first_name.' '.$user->last_name.' ('.$user->email.')';
    }
}
