<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';
    protected $table = 'EmailTemplates';
    protected $primaryKey = 'Id';

    public $timestamps = false;


    /**
     * The attributes that are enum.
     *
     * @var array
     */
    protected $enums = [
        'EmailTemplateType″″' => [
            0 => 'NA',
            1 => 'TicketsAsAttachment',
            2 => 'TicketAsDownloadLink',
            3 => 'PaymentLink',
            40 => 'ThnakYou',
            41 => 'ReviewRequest',
            51 => 'InformationRequired',
            52 => 'Delay',
            100 => 'Newsletter'
        ],
    ];

    public function externalConnection()
    {
        return $this->belongsTo(ExternalConnection::class, 'external_connection_id');
    }

    public function getContentForOrder(Order $order): string
    {
        $content = $this->Content;
        $content = str_replace('{Order_Number}', $order->ShopOrderNumber, $content);
        $content = str_replace('{Customer_First_Name}', $order->CustomerName, $content);
        $content = str_replace('{Customer_Email}', $order->CustomerEmail, $content);
        return $content;
    }

    public function getSubjectForOrder(Order $order): string
    {
        $subject = $this->Subject;
        $subject = str_replace('{Order_Number}', $order->ShopOrderNumber, $subject);
        $subject = str_replace('{Customer_First_Name}', $order->CustomerName, $subject);
        return $subject;
    }

    public function fillTemplate(Order $order): void
    {
        $this->Content = $this->getContentForOrder($order);
        $this->Subject = $this->getSubjectForOrder($order);
    }
}
