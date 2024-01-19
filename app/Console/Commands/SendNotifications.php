<?php

namespace App\Console\Commands;

use App\DB\Enum\SentBeforeEnum;
use App\DB\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendNotifications extends Command
{
    protected $signature = 'send-notifications';

    protected $description = 'Send notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //persistent - pięć minut przed
        //tugboat - pół godziny przed
        //cashregister - godzinę przed

        $notifications = Notification::query()->get();
        $currentDateTime = Carbon::now();

        foreach ($notifications as $notification) {
            $data = [];
            $targetDate = Carbon::parse($notification->end_at);

            if ($targetDate->diffInMinutes($currentDateTime) <= 5) {
                if ($notification->sent_before !== SentBeforeEnum::MIN5) {
                    $data = [
                        'sound' => 'persistent',
                        'sent_before' => SentBeforeEnum::MIN5
                    ];
                }
            } else {
                if ($targetDate->diffInMinutes($currentDateTime) <= 30) {
                    if ($notification->sent_before !== SentBeforeEnum::MIN30) {
                        $data = [
                            'sound' => 'tugboat',
                            'sent_before' => SentBeforeEnum::MIN30
                        ];
                    }
                } else {
                    if ($targetDate->diffInHours($currentDateTime) <= 1) {
                        if ($notification->sent_before !== SentBeforeEnum::MIN60) {
                            $data = [
                                'sound' => 'cashregister',
                                'sent_before' => SentBeforeEnum::MIN60
                            ];
                        }
                    }
                }
            }

            if ($data !== []) {
                $endAt = Carbon::parse($notification->end_at);
                $currentTime = Carbon::now();
                $minutes = $currentTime->diffInMinutes($endAt);
                $title = "Licytacja kończy się za $minutes minut";
                $this->sendPushoverNotification('<a href="' . $notification->link . '">' . $notification->name . '</a>', $data['sound'], $title);
                $notification->update(['sent_before' => $data['sent_before']]);
            }
        }
    }

    private function sendPushoverNotification($message, $sound = '', $title = null)
    {
        $data = [
            'token' => env('PUSHOVER_API_TOKEN'),
            'user' => env('PUSHOVER_USER_KEY'),
            'title' => $title,
            'message' => $message,
            'html' => 1,
            'sound' => $sound,
        ];

        $response = Http::withHeaders(['Host' => 'api.pushover.net'])
            ->post(env('PUSHOVER_BASE_URL'), $data);

        return !$response->failed();
    }
}
