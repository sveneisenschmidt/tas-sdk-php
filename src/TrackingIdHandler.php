<?php

/*
 * Copyright 2016 trivago GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Trivago\Tas;

final class TrackingIdHandler
{
    /**
     * @var callable
     */
    private $getTrackingId;

    /**
     * @var callable
     */
    private $storeTrackingId;

    /**
     * @var string|null
     */
    private $trackingId;

    public function __construct(callable $getTrackingId, callable $storeTrackingId)
    {
        $this->getTrackingId   = $getTrackingId;
        $this->storeTrackingId = $storeTrackingId;
    }

    /**
     * @return string
     */
    public function get()
    {
        if (isset($this->trackingId)) {
            return $this->trackingId;
        }

        $trackingId       = call_user_func($this->getTrackingId);
        $this->trackingId = is_string($trackingId) ? $trackingId : '';

        return $this->trackingId;
    }

    /**
     * Only stores Tracking-Id if it is set and different from the current one.
     *
     * @param string $newTrackingId
     */
    public function store($newTrackingId)
    {
        $currentTrackingId = $this->get();

        if (null === $newTrackingId || $currentTrackingId === $newTrackingId) {
            return;
        }

        $this->trackingId = $newTrackingId;
        call_user_func($this->storeTrackingId, $this->trackingId);
    }
}
