<?php

namespace EdiExpert\WebapiModels\Models;

use App\Enums\EmailTemplateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalConnection extends Model
{
    use HasFactory;
    protected $connection = 'ticketsender';


    public function externalConnectionMapping(): ?ExternalConnectionMapping
    {
        return ExternalConnectionMapping::where('external_connection_id', $this->id)->first();
    }

    public function getEmailTemplate(int $emailTemplateType): ?EmailTemplate
    {
        return EmailTemplate::where('external_connection_id', $this->id)
            ->where('EmailTemplateType', $emailTemplateType)
            ->where('IsActive', 1)
            ->first();
    }

    public function getMailSettings(): ?MailSetting
    {
        $mapping = $this->externalConnectionMapping();
        return $mapping ? $mapping->mailSetting : null;
    }
}
