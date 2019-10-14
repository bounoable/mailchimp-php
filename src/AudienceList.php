<?php

namespace Bounoable\Mailchimp;

class AudienceList
{
    /**
     * @var Mailchimp
     */
    private $mailchimp;

    /**
     * @var string
     */
    private $id;

    public function __construct(Mailchimp $mailchimp, string $id)
    {
        $this->mailchimp = $mailchimp;
        $this->id = $id;
    }

    public function get(array $query = []): array
    {
        return $this->mailchimp->sendRequest('GET', "lists/{$this->id}", $query);
    }

    public function members(): ListMembers
    {
        return new ListMembers($this->mailchimp, $this->id);
    }

    public function segment(int $id): ListSegment
    {
        return new ListSegment($this->mailchimp, $this->id, $id);
    }
}
