<?php

namespace Bounoable\Mailchimp;

class ListMembers
{
    /**
     * @var Mailchimp
     */
    private $mailchimp;

    /**
     * @var string
     */
    private $listId;

    public function __construct(Mailchimp $mailchimp, string $listId)
    {
        $this->mailchimp = $mailchimp;
        $this->listId = $listId;
    }

    public function create(string $email, string $status, array $mergeFields = [], array $body = [], array $query = []): array
    {
        $email = mb_strtolower($email);
        $emailHash = md5($email);

        return $this->mailchimp->sendRequest('PUT', "lists/{$this->listId}/members/{$emailHash}", array_merge([
            'email_address' => $email,
            'status' => $status,
            'status_if_new' => $status,
            'merge_fields' => $mergeFields,
        ], $body), $query);
    }
}
