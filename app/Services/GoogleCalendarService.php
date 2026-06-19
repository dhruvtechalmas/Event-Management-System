<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event as GoogleEvent;

class GoogleCalendarService
{
    protected static function getCalendar()
    {

        $user = auth()->user();

        if (
            !$user->google_token ||
            (
                $user->google_token_expires_at &&
                now()->greaterThan(
                    $user->google_token_expires_at
                )
            )
        ) {
            return null;
        }
        $token = auth()->user()->google_token;

        if (!$token) {
            return null;
        }

        $client = new Client();

        $client->setClientId(
            config('services.google.client_id')
        );

        $client->setClientSecret(
            config('services.google.client_secret')
        );

        $client->setRedirectUri(
            config('services.google.redirect')
        );

        $client->addScope(
            Calendar::CALENDAR
        );

        $client->setAccessToken([
            'access_token' => $token,
        ]);

        return new Calendar($client);
    }

    public static function createEvent(Event $event)
    {
        $service = self::getCalendar();

        if (!$service) {
            return;
        }

        $start = Carbon::parse(
            $event->event_date . ' ' .
            ($event->event_time ?? '00:00:00')
        );

        $end = $start->copy()->addHour();

        $googleEvent = new GoogleEvent([
            'summary' => $event->event_name,
            'location' => $event->event_location,
            'description' => $event->description,

            'start' => [
                'dateTime' => $start->toIso8601String(),
                'timeZone' => 'Asia/Kolkata',
            ],

            'end' => [
                'dateTime' => $end->toIso8601String(),
                'timeZone' => 'Asia/Kolkata',
            ],
        ]);

        $googleEvent = $service
            ->events
            ->insert('primary', $googleEvent);


        $event->update([
            'google_event_id' => $googleEvent->id,
        ]);
    }

    public static function updateEvent(Event $event)
    {
        if (!$event->google_event_id) {
            return;
        }

        $service = self::getCalendar();

        if (!$service) {
            return;
        }

        $googleEvent = $service
            ->events
            ->get(
                'primary',
                $event->google_event_id
            );

        $start = Carbon::parse(
            $event->event_date . ' ' .
            ($event->event_time ?? '00:00:00')
        );

        $end = $start->copy()->addHour();

        $googleEvent->setSummary(
            $event->event_name
        );

        $googleEvent->setLocation(
            $event->event_location
        );

        $googleEvent->setDescription(
            $event->description
        );

        $googleEvent->setStart(
            new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $start->toIso8601String(),
                'timeZone' => 'Asia/Kolkata',
            ])
        );

        $googleEvent->setEnd(
            new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $end->toIso8601String(),
                'timeZone' => 'Asia/Kolkata',
            ])
        );

        $service
            ->events
            ->update(
                'primary',
                $event->google_event_id,
                $googleEvent
            );
    }

    public static function deleteEvent(Event $event)
    {
        if (!$event->google_event_id) {
            return;
        }

        $service = self::getCalendar();

        if (!$service) {
            return;
        }

        $service
            ->events
            ->delete(
                'primary',
                $event->google_event_id
            );
    }
}