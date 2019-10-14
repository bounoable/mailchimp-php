<?php

namespace Bounoable\Mailchimp;

class ListSegment
{
    /**
     * @var Mailchimp
     */
    private $mailchimp;

    /**
     * @var string
     */
    private $listId;

    /**
     * @var int
     */
    private $segmentId;

    public function __construct(Mailchimp $mailchimp, string $listId, int $segmentId)
    {
        $this->mailchimp = $mailchimp;
        $this->listId = $listId;
        $this->segmentId = $segmentId;
    }

    public function addMembers(array $emails): array
    {
        return $this->mailchimp->sendRequest('POST', "lists/{$this->listId}/segments/{$this->segmentId}", [
            'members_to_add' => $emails,
        ]);
    }
}
