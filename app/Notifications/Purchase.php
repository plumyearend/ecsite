<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;

class Purchase extends Notification
{
    use Queueable;

    public function __construct(private Order $order)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $slackMessage = (new SlackMessage)
            ->text('商品が購入されました オーダーID:' . $this->order->id)
            ->headerBlock('商品が購入されました')
            ->contextBlock(function ($block) {
                $block->text('オーダーID: ' . $this->order->id);
                $block->text('購入者: ' . $this->order->user->name);
            })
            ->sectionBlock(function ($block) {
                $block->text('購入内容');
                foreach ($this->order->orderDetails as $orderDetail) {
                    $block->field($orderDetail->product->name . ' x ' . $orderDetail->count . ' ' . number_format($orderDetail->price_tax) . '円')->markdown();
                }
            })
            ->dividerBlock()
            ->sectionBlock(function ($block) {
                $block->text('合計：' . number_format($this->order->total_price) . '円');
            })
            ->sectionBlock(function ($block) {
                $block->text('<' . route('filament.admin.resources.orders.view', ['record' => $this->order->id]) . '|注文詳細>')->markdown();
            });

        return $slackMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
